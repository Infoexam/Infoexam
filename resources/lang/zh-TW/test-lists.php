<?php

return [

    'title' => '測驗系統',
    'list' => '測驗列表',
    'create' => '新增測驗',
    'change_apply_status' => '切換預約狀態',
    'change_test_status' => '切換測驗狀態',
    'delete' => '刪除測驗',

    'show_tested_1' => '顯示已結束測驗',
    'show_tested_0' => '顯示尚未結束測驗',

    'allow_apply' => '預約狀態',
    'test_enable' => '測驗狀態',
    'test_started' => '測驗進行中',
    'ssn' => '測驗代碼',
    'start_time' => '測驗起始時間',
    'end_time' => '測驗結束時間',
    'test_time' => '測驗時長',
    'extend_time' => '延長時間',
    'room' => '測驗教室',
    'std_num_limit' => '人數限制',
    'std_apply_num' => '報名人數',
    'std_real_test_num' => '到考人數',

    'personal_apply' => '學生個人預約',
    'department_apply' => '系所統一預約 (大二)',
    'department_apply_class' => '班別',

    'apply_type' => '預約類型',
    'apply_student' => '學生自行預約',
    'apply_unite' => '統一預約時段',
    'apply_types' => [
        '1_1' => '通用自行預約',
        '1_2' => '大四專屬預約',
        '1_3' => '大二專屬預約',
        '2_1' => '科系統一預約',
        '2_2' => '衝堂補考預約',
    ],

    'test_type' => '測驗類別',
    'test_types' => [
        '1_1' => '電腦應用能力(學科)',
        '1_2' => '電腦應用能力(術科)',
        '2_1' => '電腦軟體能力(學科)',
        '2_2' => '電腦軟體能力(術科)',
    ],

    'test_paper' => '考試試卷',
    'test_paper_type' => [
        'auto' => '自動產生試卷',
        'specific' => '指定考試試卷',
    ],
    'test_paper_auto' => '題庫選擇',
    'test_paper_auto_number' => '題目數目',
    'test_paper_specific' => '考試試卷',
    'random_level' => '隨機',

    'question_insufficient' => '題目數不足，所選題庫題目數僅有 :number 題',
    'test_time_conflict' => '考試時段已有其他場次測驗',

];