<?php

return [

    'title' => '預約系統',
    'list' => '測驗列表',
    'history' => '歷史測驗',
    'manage' => '查詢預約',
    'manage_unite' => '統一預約管理',
    'dlPc2List' => '下載 PC^2 名單',

    'apply' => '預約',
    'applies' => '預約列表',
    'apply.success' => '預約成功',
    'apply.failed' => '預約失敗',
    'apply.cancel' => '取消預約',
    'apply.time' => '預約時間',

    'transform' => '場次更換',
    'transform.failed' => '更換失敗，超過更換期限或選擇了不同類別的測驗',

    'paid_status' => '繳費狀況',
    'scores' => '測驗成績',
    'scores.null' => '缺考',

    'apply_student' => '測驗預約',

    'error' => [
        'invalid_apply' => '無效的操作',
        'test_not_found' => '不存在的測驗',

        'already_passed_acad' => '你已通過學科測驗',
        'already_passed_tech' => '你已通過術科測驗',

        'too_late_to_apply' => '已超過可預約之時間限制',
        'test_is_full' => '此場測驗已無名額',
        'is_csie' => '資工系同學僅能參加 "電腦軟體能力" 類型的測驗',
        'specific_grade' => [
            '2' => '此場測驗為大二專屬預約',
            '4' => '此場測驗為大四專屬預約'
        ],

        'apply_the_same_test' => '你已預約此場測驗',
        'already_apply_test_in_same_week' => '於當週已有其他預約',
        'too_late_too_cancel_apply' => '已超過可取消預約之時間限制，最晚需於 :days 前申請取消測驗',
        'absent_test' => '過去一週內有缺考紀錄，系統已暫時停止你預約的權力',

        'admin' => [
            'destroy_failed' => '刪除失敗，該測驗已開始或已有同學預約',
            'is_csie' => '學生 :name (:username) 為資工系同學，不符合此測驗類型，因此已略過預約',
            'apply_the_same_test' => '學生 :name (:username) 已預約此場測驗，因此已略過預約',
            'already_apply_test_in_same_week' => '學生 :name (:username) 已於當週有其他測驗，因此已略過預約',
        ],
    ],

];