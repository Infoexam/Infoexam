<?php

HTML::macro('true_or_false', function($condition)
{
    return ((bool) $condition)
        ? '<span class="glyphicon glyphicon-ok text-green" aria-hidden="true"></span>'
        : '<span class="glyphicon glyphicon-remove text-red" aria-hidden="true"></span>';
});

HTML::macro('icon_menu_down', function()
{
    return '<span class="glyphicon glyphicon-menu-down"></span>';
});

HTML::macro('recaptcha', function()
{
    return '<div class="g-recaptcha" id="g-recaptcha" data-sitekey="6LceEQITAAAAAKALUbnb3GoAyqso_q37fPXX-TOh"></div>';
});

HTML::macro('nl2br', function($content)
{
    return nl2br(e($content));
});

HTML::macro('link_button', function($route, $text)
{
    $route = e($route);
    $text = e($text);

    return <<< EOF
    <a href="{$route}"><button class="btn btn-primary">{$text}</button></a>
EOF;
});

HTML::macro('create_icon', function($route)
{
    $route = e($route);
    $title = e(trans('general.create'));

    return <<< EOF
    <a href="{$route}" title="{$title}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-pencil"></span></a>
EOF;
});

HTML::macro('edit_icon', function($route)
{
    $route = e($route);
    $title = e(trans('general.edit'));

    return <<< EOF
    <a href="{$route}" title="{$title}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-edit"></span></a>
EOF;
});

HTML::macro('show_question_level', function($level)
{
    return e(trans('exam-questions.levels.' . $level));
});