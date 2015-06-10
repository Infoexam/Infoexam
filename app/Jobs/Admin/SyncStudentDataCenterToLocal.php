<?php

namespace App\Jobs\Admin;

use App\Infoexam\Account\Account;
use App\Infoexam\Account\AccreditedDatum;
use App\Infoexam\Account\Department;
use App\Infoexam\Account\UserDatum;
use App\Infoexam\Account\UserGroup;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class SyncStudentDataCenterToLocal extends Job implements SelfHandling
{
    protected $override, $specific, $username;

    /**
     * Create a new job instance.
     *
     * @param bool $override
     * @param bool $specific
     * @param string|null $username
     */
    public function __construct($override = false, $specific = false, $username = null)
    {
        $this->override = (bool) $override;
        $this->specific = (bool) $specific;
        $this->username = $username;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $center = new Account();
        $center->setConnection('pgsql_elearn');
        $center->setTable('std_info');
        $center->setKeyName('std_no');
        $center = $center->leftJoin('std_login', 'std_info.std_no', '=', 'std_login.user_id')
            ->select('std_info.*', 'std_login.stat', 'std_login.pass_time', 'std_login.pass_grade', 'std_login.grade1', 'std_login.grade2', 'std_login.test_count', 'std_login.pass_y', 'std_login.pass_s');

        if ( ! $this->specific)
        {
            $data = $center->get();
        }
        else
        {
            if (null === ($datum = $center->where('std_info.std_no', '=', $this->username)->first()))
            {
                return;
            }

            $data = [$datum];
        }

        unset($center);

        foreach ($data as &$datum)
        {
            try
            {
                $account = Account::where('username', '=', $datum->std_no)->first();

                $pass_or_not = ('Y' == $datum->stat);

                $department_id = Department::where('code', '=', $datum->deptcd)->firstOrFail();

                if (null !== $account)
                {
                    $info = [
                        'name' => trim($datum->name),
                        'id_number' => $datum->id_num,
                        'gender' => $datum->sex,
                        'email' => $datum->email,
                        'grade' => $datum->now_grade,
                        'class' => $datum->now_class,
                        'department_id' => $department_id->id,
                    ];

                    $account->userData->lockForUpdate();
                    $account->userData->fill($info)->save();
                }
                else
                {
                    DB::transaction(function() use ($datum, $pass_or_not, $department_id)
                    {
                        $info_acc = [
                            'username' => $datum->std_no,
                            'password' => bcrypt($datum->user_pass),
                        ];

                        $info_user = [
                            'name' => trim($datum->name),
                            'id_number' => $datum->id_num,
                            'gender' => $datum->sex,
                            'email' => $datum->email,
                            'grade' => $datum->now_grade,
                            'class' => $datum->now_class,
                            'department_id' => $department_id->id,
                        ];

                        $info_accredited = [
                            'free_acad' => ($datum->now_grade > 2) ? 0 : 1,
                            'free_tech' => ($datum->now_grade > 2) ? 0 : 1,
                            'is_passed' => $pass_or_not,
                            'passed_score' => ($pass_or_not) ? $datum->pass_grade : null,
                            'passed_year' => ($pass_or_not) ? $datum->pass_y : null,
                            'passed_semester' => ($pass_or_not) ? $datum->pass_s : null,
                            'passed_time' => ($pass_or_not) ? $datum->pass_time : null,
                            'acad_score' => ($datum->grade1) ? $datum->grade1 : null,
                            'tech_score' => ($datum->grade2) ? $datum->grade2 : null,
                            'test_count' => ($datum->test_count) ? $datum->test_count : 0,
                        ];

                        $info_group = [
                            'group_id' => 3
                        ];

                        $account = new Account();

                        $account->fill($info_acc)->save();

                        if ( ! $account->exists)
                        {
                            throw new ModelNotFoundException;
                        }

                        $user_data = new UserDatum();

                        $accredited_data = new AccreditedDatum();

                        $group = new UserGroup();

                        $user_data->fill($info_user);

                        $accredited_data->fill($info_accredited);

                        $group->fill($info_group);

                        $account->userData()->save($user_data);

                        $account->accreditedData()->save($accredited_data);

                        $account->groups()->save($group);

                        if ( ! $account->userData->exists || ! $account->accreditedData->exists)
                        {
                            throw new ModelNotFoundException;
                        }
                    });
                }
            }
            catch (ModelNotFoundException $e)
            {
                logging(['level' => 'warning', 'action' => 'syncStudentDataFailed', 'content' => ['username' => $datum->std_no, 'name' => trim($datum->name)], 'remark' => 'CenterToLocal']);
            }
        }
    }
}