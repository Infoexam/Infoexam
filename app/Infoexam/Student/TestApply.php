<?php namespace App\Infoexam\Student;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestApply extends Model {

    use SoftDeletes;

    protected $fillable = ['ssn', 'account_id', 'test_list_id', 'apply_time', 'paid_at'];

    protected $dates = ['deleted_at'];

    public function account()
    {
        return $this->belongsTo('App\Infoexam\Account');
    }

    public function test_list()
    {
        return $this->belongsTo('App\Infoexam\Admin\TestList');
    }

    public function test_result()
    {
        return $this->hasOne('App\Infoexam\Student\TestResult');
    }

}
