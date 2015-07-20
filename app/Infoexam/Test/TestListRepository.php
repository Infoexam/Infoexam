<?php

namespace App\Infoexam\Test;

use App\Infoexam\Core\Repository;
use App\Infoexam\Exam\ExamConfig;
use Carbon\Carbon;

class TestListRepository extends Repository
{
    /**
     * Get opened rooms.
     *
     * @return Array
     */
    public static function getOpenRooms()
    {
        $room = [];

        foreach (unserialize(ExamConfig::firstOrFail()->open_room) as $value)
        {
            $room[$value] = $value;
        }

        return $room;
    }

    /**
     * Get test applying types.
     *
     * @return Array
     */
    public static function getApplyTypes()
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

    /**
     * Get test testing types.
     *
     * @return Array
     */
    public static function getTestTypes()
    {
        return [
            '1_1' => trans('test-lists.test_types.1_1'),
            '1_2' => trans('test-lists.test_types.1_2'),
            '2_1' => trans('test-lists.test_types.2_1'),
            '2_2' => trans('test-lists.test_types.2_2'),
        ];
    }

    /**
     * Get recently exams.
     *
     * @return Array
     */
    public static function getRecentlyExams()
    {
        return TestList::where('start_time', '<', Carbon::now()->addDays(5))
            ->whereBetween('end_time', [Carbon::now(), Carbon::now()->addDays(100)])
            ->orderBy('start_time')
            ->get(['id', 'ssn', 'start_time', 'room', 'test_started']);

        // 正式版本
//        return TestList::whereBetween('start_time', [Carbon::now()->addMinutes(30), Carbon::now()->endOfDay()->addMinutes(30)])
//            ->orderBy('start_time')
//            ->get(['id', 'ssn', 'start_time', 'room', 'test_started']);
    }

    /**
     * Get recently exams id.
     *
     * @return Array
     */
    public static function getRecentlyExamIds()
    {
        return self::getRecentlyExams()->pluck('id')->all();
    }

    public static function getTestsStudentCanApply()
    {
        return TestList::where('test_enable', '=', true)
            ->where('allow_apply', '=', true)
            ->where('apply_type', 'like', '1\_%')
            ->where('start_time', '>=', Carbon::now()->addDays(1)->startOfDay())
            ->orderBy('start_time', 'asc')
            ->paginate(10, ['ssn', 'start_time', 'end_time', 'room', 'apply_type', 'test_type', 'std_num_limit', 'std_apply_num']);
    }

    public static function getUniteTestsStudentCanManage()
    {
        return TestList::where('test_enable', '=', true)
            ->where('allow_apply', '=', true)
            ->where('apply_type', 'like', '2_%')
            ->where('start_time', '>=', Carbon::now()->addDays(1)->startOfDay())
            ->orderBy('start_time', 'asc')
            ->paginate(10, ['ssn', 'start_time', 'end_time', 'room', 'apply_type', 'test_type', 'std_num_limit', 'std_apply_num']);
    }

    public static function getTestScoresAdminManage()
    {
        return TestList::where('end_time', '<=', Carbon::now())
            ->orderBy('end_time', 'desc')
            ->paginate(10, ['ssn', 'apply_type', 'test_type', 'std_apply_num', 'std_real_test_num']);
    }

    public static function getTestScoresListsAdminManage()
    {
        return TestList::where('end_time', '<=', Carbon::now())
            ->orderBy('end_time', 'desc')
            ->lists('ssn', 'ssn');
    }
}