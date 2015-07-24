<?php

namespace App\Infoexam\Exam;

use App\Infoexam\Account\Authenticate;
use App\Infoexam\Test\TestList;
use App\Infoexam\Test\TestApply;
use App\Infoexam\Test\TestListRepository;
use App\Infoexam\Test\TestResult;
use Auth;
use Carbon\Carbon;

class ExamAuth
{
    /**
     * The account model.
     *
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    protected $account = null;

    /**
     * The test apply model.
     *
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    public $apply = null;

    /**
     * Indicates if the user is login or not.
     *
     * @var bool
     */
    protected $login;

    /**
     * Indicates if the user is reLogin or not.
     *
     * @var bool
     */
    protected $reLogin = false;

    /**
     * Create a new ExamAuth instance.
     */
    public function __construct()
    {
        $this->login = Auth::check();

        if ($this->login)
        {
            $this->account = Auth::user();
        }
    }

    /**
     * Execute the login process.
     *
     * @param  string|null  $username
     * @param  string|null  $password
     * @return bool
     */
    public function login($username = null, $password = null)
    {
        $auth = new Authenticate($username, $password, 'student');

        if ( ! $auth->login(false, false))
        {
            flash()->error('Invalid username or password.');
        }
        else
        {
            $this->setAccount(Auth::user());

            if ($this->account->isInvigilator() || ($this->existExam() && $this->isExamStarted() && $this->nonMultiLogin() && $this->initializeTestResult()))
            {
                $this->login = true;

                $auth->logging();

                session()->put('examUser', true);

                return true;
            }

            $auth->fail2ban();

            Auth::logout();
        }

        return false;
    }

    /**
     * Check the user has exam or not.
     *
     * @return bool
     */
    public function existExam()
    {
        if (null === $this->account)
        {
            flash()->error(trans('exam.error.signInAtWrongTime'));
        }
        else
        {
            $test_id = TestListRepository::getRecentlyExamIds();

            $apply = TestApply::with(['test_list'])
                ->whereIn('test_list_id', $test_id)
                ->where('account_id', '=', $this->account->id)
                ->get(['id', 'test_list_id', 'test_result_id']);

            if (1 !== $apply->count())
            {
                flash()->error(trans('exam.error.signInAtWrongTime'));
            }
            else
            {
                $this->apply = $apply[0];

                return true;
            }
        }

        return false;
    }

    /**
     * Check the exam is started or not.
     *
     * @return bool
     */
    public function isExamStarted()
    {
        if ($this->apply->test_list->test_started && $this->apply->test_list->start_time < Carbon::now())
        {
            return true;
        }

        flash()->error(trans('exam.error.examNotStart'));

        return false;
    }

    /**
     * Check the user had login.
     *
     * @return bool
     */
    public function nonMultiLogin()
    {
        if ((null !== $this->apply) && (null === $this->apply->test_result))
        {
            return true;
        }

        if (true === (bool) $this->apply->test_result->allow_relogin)
        {
            $this->apply->test_result->allow_relogin = false;

            $this->apply->test_result->save();

            $this->reLogin = true;

            return true;
        }

        flash()->error(trans('exam.error.multiSignIn'));

        return false;
    }

    /**
     * Set the account model.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $account
     * @return void
     */
    public function setAccount($account = null)
    {
        $this->account = $account;
    }

    /**
     * Check the user is invigilator or not.
     *
     * @return bool
     */
    public function isInvigilator()
    {
        return $this->account->isInvigilator();
    }

    /**
     * Initialize the test result record.
     *
     * @return bool
     */
    public function initializeTestResult()
    {
        if ($this->reLogin)
        {
            if ((null !== $this->apply) && (null !== $this->apply->test_result_id))
            {
                session()->flash('exam_time_extends', $this->apply->test_result->exam_time_extends);
            }

            return true;
        }

        $test_result = TestResult::create(['test_apply_id' => $this->apply->id]);

        if ($test_result->exists)
        {
            $this->apply->test_result_id = $test_result->id;

            $this->apply->save();

            $this->apply->test_list->increment('std_real_test_num');

            if ( ! starts_with($this->apply->test_list->apply_type, '2'))
            {
                if (ends_with($this->apply->test_list->test_type, '1'))
                {
                    $this->apply->account->accreditedData->decrement('free_acad');
                }
                else
                {
                    $this->apply->account->accreditedData->decrement('free_tech');
                }
            }

            return true;
        }

        flash()->error(trans('exam.error.initializeFailed'));

        return false;
    }
}