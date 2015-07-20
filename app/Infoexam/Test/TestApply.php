<?php

namespace App\Infoexam\Test;

use App\Infoexam\Core\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestApply extends Entity
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_id', 'test_list_id', 'apply_time', 'paid_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $ssn = true;

    public function account()
    {
        return $this->belongsTo('App\Infoexam\Account\Account');
    }

    public function test_list()
    {
        return $this->belongsTo('App\Infoexam\Test\TestList');
    }

    public function test_result()
    {
        return $this->hasOne('App\Infoexam\Test\TestResult');
    }
}