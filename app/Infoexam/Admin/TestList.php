<?php namespace App\Infoexam\Admin;

use App\Commands\Admin\AutoGeneralPaper;
use App\Infoexam\Core\Entity;
use App\Infoexam\Exam\ExamConfig;
use App\Infoexam\Paper\PaperList;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestList extends Entity {

    use SoftDeletes;

    protected $fillable = ['ssn', 'start_time', 'end_time', 'room', 'apply_type', 'test_type', 'std_num_limit', 'std_apply_num', 'std_real_test_num', 'paper_list_id', 'allow_apply', 'test_enable'];

    protected $dates = ['start_time', 'end_time', 'deleted_at'];

    public function applies()
    {
        return $this->hasMany('App\Infoexam\Student\TestApply');
    }

    public function scopeRoom($query, $param)
    {
        $query->where('room', '=', $param);
    }

    public function scopeTested($query, $param = false)
    {
        $query->where('end_time', ($param) ? '<' : '>=', Carbon::now());
    }

    public static function getOpenRoom()
    {
        $list = unserialize(ExamConfig::firstOrFail()->open_room);

        foreach ($list as $key => $value)
        {
            $list[$value] = $value;
            unset($list[$key]);
        }

        return $list;
    }

    public static function getApplyType()
    {
        return [
            trans('test-lists.apply_student') => [
                '1_1' => trans('test-lists.apply_types.1_1'),
                '1_2' => trans('test-lists.apply_types.1_2'),
                '1_3' => trans('test-lists.apply_types.1_3'),
            ],
            trans('test-lists.apply_unite') => [
                '2_1' => trans('test-lists.apply_types.2_1'),
                '2_2' => trans('test-lists.apply_types.2_2'),
            ],
        ];
    }

    public static function getTestType()
    {
        return [
            '1_1' => trans('test-lists.test_types.1_1'),
            '1_2' => trans('test-lists.test_types.1_2'),
            '2_1' => trans('test-lists.test_types.2_1'),
            '2_2' => trans('test-lists.test_types.2_2'),
        ];
    }

    public static function getRecentlyExams()
    {
        return self::where('start_time', '<', Carbon::now()->addMinutes(30))
            ->whereBetween('end_time', [Carbon::now(), Carbon::now()->addDays(100)])
            ->get(['id']);

//        未來的版本
//        return self::whereBetween('start_time', [Carbon::now()->addMinutes(30), Carbon::now()->endOfDay()->addMinutes(30)])
//            ->get(['id']);
    }

    public function create_test(array $attributes = [])
    {
        $this->attributes['start_time'] = Carbon::parse($attributes['start_time']);
        $this->attributes['end_time'] = Carbon::parse($attributes['start_time'])->addMinutes(intval($attributes['test_time']));
        $this->attributes['room'] = $attributes['room'];

        if ($this->is_duplicate($this->attributes['start_time'], $this->attributes['end_time'], $this->attributes['room']))
        {
            flash()->error(trans('test-lists.test_time_conflict'));

            return false;
        }

        $this->attributes['apply_type'] = $attributes['apply_type'];
        $this->attributes['test_type'] = $attributes['test_type'];
        $this->attributes['std_num_limit'] = $attributes['std_num_limit'];
        $this->attributes['ssn'] = (Carbon::parse($this->attributes['start_time'])->format('Ymd')).($this->attributes['room']).(Carbon::parse($this->attributes['start_time'])->format('H'));
        $this->attributes['paper_list_id'] = $this->getPaperListId($attributes);

        if (false === $this->attributes['paper_list_id'])
        {
            return false;
        }

        $this->save();

        return $this->exists;
    }

    public function is_duplicate(&$start_time, &$end_time, &$room)
    {
        $count = TestList::room($room)
            ->where(function($query) use ($start_time, $end_time)
            {
                $query->where(function($query) use ($start_time)
                {
                    $query->where('start_time', '<=', $start_time)
                        ->where('end_time', '>=', $start_time);
                })
                ->orWhere(function($query) use ($start_time, $end_time)
                {
                    $query->where('start_time', '>=', $start_time)
                        ->where('end_time', '<=', $end_time);
                });
            })
            ->count(['id']);

        return boolval($count);
    }

    public function getPaperListId(&$attributes)
    {
        /*
         * X_O
         * X：1：電腦應用能力；2：電腦軟體能力
         * O：1：學科；2：術科
         */

        $test_type = explode('_', $attributes['test_type']);

        if (2 == $test_type[1])
        {
            return null;
        }
        else if (1 == $attributes['test_paper_type'])
        {
            /*
             * 自動產生試卷
             */
            return \Bus::dispatch(new AutoGeneralPaper($attributes['test_paper_auto'], $attributes['test_paper_auto_level'], $attributes['test_paper_auto_number']));
        }
        else
        {
            if (null === ($list = PaperList::where('ssn', '=', $attributes['test_paper_specific'])->first()))
            {
                flash()->error('Paper not exist.');

                return false;
            }

            return $list->id;
        }
    }

}