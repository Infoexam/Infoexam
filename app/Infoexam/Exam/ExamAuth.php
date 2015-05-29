<?php namespace App\Infoexam\Exam;

use App\Infoexam\Account\Authenticate;
use App\Infoexam\Admin\TestList;
use App\Infoexam\Student\TestApply;
use App\Infoexam\Student\TestResult;
use Auth;
use Carbon\Carbon;

class ExamAuth {

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
    protected $apply = null;

    /**
     * Indicates if the user is login or not.
     *
     * @var bool
     */
    protected $login;

    /**
     * Create a new ExamAuth instance.
     *
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

            if (/*$this->account->isInvigilator() ||*/ ($this->existExam() && $this->nonMultiLogin() && $this->initializeTestResult()))
            {
                $this->login = true;

                $auth->logging();

                /* 該換 */
                session()->put('test_ssn', $this->apply->test_list);

                return true;
            }
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
            flash()->error('Oops! There is no test now.');
        }
        else
        {
            $test_lists = TestList::getRecentlyExams()->toArray();

            $test_id = array_merge(array_column($test_lists, 'id'));

            $apply = TestApply::whereIn('test_list_id', $test_id)->where('account_id', '=', $this->account->id)->get(['id', 'test_list_id', 'test_result_id']);

            if (1 !== $apply->count())
            {
                flash()->error('Oops! Maybe you visit here at the wrong time.');
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

        flash()->error('Oops! Maybe you had already signed in before.');

        return false;
    }

    /**
     * Check the user already has exam data in session.
     *
     * @return bool
     */
    public function ensureHasExam()
    {
        if ($this->login && (null !== session('test_ssn')))
        {
            return true;
        }

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
        return true;

        $test_result = TestResult::create(['test_apply_id' => $this->apply->id]);

        if ($test_result->exists)
        {
            $this->apply->test_result_id = $test_result->id;

            $this->apply->save();

            return true;
        }

        flash()->error('Oops! There is something wrong.');

        return false;
    }
}