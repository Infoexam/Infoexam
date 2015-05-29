<?php namespace App\Commands\Admin;

use App\Commands\Command;
use App\Infoexam\Account\Account;
use App\Infoexam\Account\AccreditedDatum;
use App\Infoexam\Account\UserDatum;
use App\Infoexam\Account\Department;
use App\Infoexam\Account\UserGroup;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SyncStudentDataCenterToLocal extends Command implements SelfHandling {

    protected $override, $specific, $username;

    public function __construct($override = false, $specific = false, $username = null)
    {
        $this->override = $override;
        $this->specific = $specific;
        $this->username = $username;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        \DB::reconnect('mysql');
        \DB::reconnect('pgsql_elearn');

        $pg_connection = new Account();
        $pg_connection->setConnection('pgsql_elearn');
        $pg_connection->setTable('std_info');
        $pg_connection->setKeyName('std_no');
        $pg_connection = $pg_connection->leftJoin('std_login', 'std_info.std_no', '=', 'std_login.user_id')
            ->select('std_info.*', 'std_login.stat', 'std_login.pass_time', 'std_login.pass_grade', 'std_login.grade1', 'std_login.grade2', 'std_login.test_count', 'std_login.pass_y', 'std_login.pass_s');

        if ($this->specific)
        {
            $center_data = $pg_connection->where('std_info.std_no', '=', $this->username)
                ->first();

            if (is_null($center_data))
            {
                return;
            }

            $center_datas = [$center_data];
        }
        else
        {
            $center_datas = $pg_connection->get();
        }

        foreach ($center_datas as $center_data) {

            $account = Account::where('username', '=', $center_data->std_no)->first();

            $pass_or_not = ($center_data->stat == 'Y') ? true : false;

            $department_id = Department::where('code', '=', $center_data->deptcd)->firstOrFail();

            if (is_null($account))
            {
                \DB::transaction(function() use ($center_data, $pass_or_not, $department_id)
                {
                    $account = new Account();
                    $account->username = $center_data->std_no;
                    $account->password = bcrypt($center_data->user_pass);
                    $account->save();

                    if (0 === $account->id)
                    {
                        throw new ModelNotFoundException;
                    }

                    $user_data = new UserDatum();
                    $user_data->account_id = $account->id;
                    $user_data->name = trim($center_data->name);
                    $user_data->id_number = $center_data->id_num;
                    $user_data->gender = $center_data->sex;
                    $user_data->email = $center_data->email;
                    $user_data->grade = $center_data->now_grade;
                    $user_data->class = $center_data->now_class;
                    $user_data->department_id = $department_id->id;
                    $user_data->save();

                    if (0 === $user_data->id)
                    {
                        throw new ModelNotFoundException;
                    }

                    $accredited_data = new AccreditedDatum();
                    $accredited_data->account_id = $account->id;
                    $accredited_data->free_acad = ($center_data->now_grade > 2) ? 0 : 1;
                    $accredited_data->free_tech = ($center_data->now_grade > 2) ? 0 : 1;
                    $accredited_data->is_passed = ($pass_or_not) ? true : false;
                    $accredited_data->passed_score = ($pass_or_not) ? $center_data->pass_grade : null;
                    $accredited_data->passed_year = ($pass_or_not) ? $center_data->pass_y : null;
                    $accredited_data->passed_semester = ($pass_or_not) ? $center_data->pass_s : null;
                    $accredited_data->passed_time = ($pass_or_not) ? $center_data->pass_time : null;
                    $accredited_data->acad_score = ($center_data->grade1) ? $center_data->grade1 : null;
                    $accredited_data->tech_score = ($center_data->grade2) ? $center_data->grade2 : null;
                    $accredited_data->test_count = ($center_data->test_count) ? $center_data->test_count : 0;
                    $accredited_data->save();

                    if (0 === $accredited_data->id)
                    {
                        throw new ModelNotFoundException;
                    }

                    $group = new UserGroup();
                    $group->account_id = $account->id;
                    $group->group_id = 3;
                    $group->save();
                });
            }
            else
            {
                \DB::transaction(function() use ($account, $center_data, $department_id)
                {
                    $account->user_data->name = trim($center_data->name);
                    $account->user_data->id_number = $center_data->id_num;
                    $account->user_data->gender = $center_data->sex;
                    $account->user_data->email = $center_data->email;
                    $account->user_data->grade = $center_data->now_grade;
                    $account->user_data->class = $center_data->now_class;
                    $account->user_data->department_id = $department_id->id;
                    $account->user_data->save();
                });
            }

        }
    }

}
