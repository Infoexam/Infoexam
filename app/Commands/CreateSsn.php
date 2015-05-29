<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class CreateSsn extends Command implements SelfHandling {

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Execute the command.
     *
     * @return string|boolean
     */
    public function handle()
    {
        $attempts = 100;

        $length = $this->model->getConnection()->getDoctrineColumn($this->model->getTable(), 'ssn')->getLength();

        while ($attempts--)
        {
            $ssn = str_random($length);

            if (is_null($this->model->where('ssn', '=', $ssn)->first(['ssn'])))
            {
                return $ssn;
            }
        }

        flash()->error(trans('error.ssn_attempts_failed'));

        return false;
    }

}
