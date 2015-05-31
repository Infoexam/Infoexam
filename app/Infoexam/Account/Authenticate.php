<?php namespace App\Infoexam\Account;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Authenticate {

    /**
     * Indicates if the user is login or not.
     *
     * @var bool
     */
    public $login = false;

    /**
     * The account model.
     *
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    protected $account = null;

    /**
     * The account model.
     *
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    protected $center = null;

    /**
     * The user's username.
     *
     * @var string|null
     */
    protected $username;

    /**
     * The user's password.
     *
     * @var string|null
     */
    protected $password;

    /**
     * The identify to login.
     *
     * @var string|null
     */
    protected $identity;

    /**
     * Indicates if it should synchronize the password or not.
     *
     * @var bool
     */
    protected $sync;

    /**
     * Indicates if it should record the login log or not.
     *
     * @var bool
     */
    protected $record;

    /**
     * The user's ip.
     *
     * @var string
     */
    protected $user_ip;

    /**
     * Create a new Authenticate instance.
     *
     * @param  string  $username
     * @param  string  $password
     * @param  string  $identity
     */
    public function __construct($username = null, $password = null, $identity = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->identity = $identity;
        $this->user_ip = \Request::ip();

        $this->account = (null === $this->username) ? null : Account::where('username', '=', $this->username)->first();
    }

    /**
     * Execute the login process.
     *
     * @param  bool  $sync
     * @param  bool  $record
     * @return bool
     */
    public function login($sync = true, $record = true)
    {
        if ($this->needRecaptcha() && ! $this->verifyRecaptcha())
        {
            return false;
        }

        if ( ! $this->accountExists())
        {
            $this->fail2ban();

            return false;
        }

        $this->sync = (bool) $sync;

        $this->record = (bool) $record;

        $this->loginUsingLocal();

        return $this->loginFinalCheck();
    }

    /**
     * Check the account exists or not.
     *
     * @return bool
     */
    protected function accountExists()
    {
        return (null !== $this->account);
    }

    /**
     * Login the user using local database.
     *
     * @return void
     */
    protected function loginUsingLocal()
    {
        if (Auth::attempt(['username' => $this->username, 'password' => $this->password]))
        {
            $this->login = true;
        }
        else
        {
            $this->loginUsingCenter();
        }
    }

    /**
     * Login the user using center database.
     *
     * @return void
     */
    protected function loginUsingCenter()
    {
        $this->initializeCenterConnection();

        if (null !== $this->center)
        {
            Auth::loginUsingId($this->account->id);

            $this->login = true;

            if ($this->sync)
            {
                $this->syncLocalPassword();
            }
        }
    }

    /**
     * Initialize the center database connection.
     *
     * @return void
     */
    private function initializeCenterConnection()
    {
        $this->center = new Account();

        $this->center->setConnection('pgsql_elearn');
        $this->center->setTable('std_info');
        $this->center->setKeyName('std_no');

        $this->center = $this->center->where('std_no', '=', $this->username)
            ->where('user_pass', '=', $this->password)
            ->first();
    }

    /**
     * Synchronize the user's password to local database.
     *
     * @return void
     */
    private function syncLocalPassword()
    {
        $this->account->password = bcrypt($this->password);
        $this->account->save();
    }

    /**
     * If login success, check the identify.
     *
     * @return bool
     */
    private function loginFinalCheck()
    {
        if ( ! $this->login)
        {
            $this->fail2ban();
        }
        else
        {
            $identities = ['admin', 'student', 'invigilator'];

            $call = 'is' . ucfirst($this->identity);

            if (in_array($this->identity, $identities, true) &&  $this->account->$call())
            {
                if ($this->record)
                {
                    $this->logging();
                }

                flash()->success(trans('general.login.success'));
            }
            else
            {
                Auth::logout();

                $this->login = false;

                $this->fail2ban();
            }
        }

        return $this->login;
    }

    /**
     * Determine it need to verify the recaptcha or not
     *
     * @return bool
     */
    public function needRecaptcha()
    {
        if (null !== ($fail2ban = Cache::get('fail2ban')))
        {
            $now = Carbon::now();

            foreach ($fail2ban['login'] as $key => &$value)
            {
                if (($this->user_ip === $key) && ($value['frequency'] >= 3) && ($now->diffInMinutes($value['date']) <= 30))
                {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Verify the recaptcha
     *
     * @return bool
     */
    public function verifyRecaptcha()
    {
        $validator = \Validator::make(
            ['recaptcha' => \Request::input('g-recaptcha-response')],
            ['recaptcha' => 'required|recaptcha']
        );

        return ! $validator->fails();
    }

    /**
     * Ban an ip address if it fail more than three times.
     *
     * @return void
     */
    public function fail2ban()
    {
        if ((null === ($fail2ban = Cache::get('fail2ban'))) || ( ! isset($fail2ban['login'][$this->user_ip])))
        {
            $fail2ban['login'][$this->user_ip]['frequency'] = 1;
        }
        else if (($diff = Carbon::now()->diffInMinutes($fail2ban['login'][$this->user_ip]['date'])) > 30)
        {
            $fail2ban['login'][$this->user_ip]['frequency'] -= intval($diff / 30);

            $fail2ban['login'][$this->user_ip]['frequency'] = max($fail2ban['login'][$this->user_ip]['frequency'], 1);
        }
        else
        {
            ++$fail2ban['login'][$this->user_ip]['frequency'];
        }

        $fail2ban['login'][$this->user_ip]['date'] = Carbon::now();

        Cache::forever('fail2ban', $fail2ban);
    }

    /**
     * Log the login log.
     *
     * @return void
     */
    public function logging()
    {
        logging(['level' => 'info', 'action' => 'login', 'content' => null, 'remark' => null]);
    }
}