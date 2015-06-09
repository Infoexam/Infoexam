<footer class="center-block">
    <nav class="list-inline">
        <ul>
            <li class="copyright">{{ trans('general.copyright') }}</li>
            <li>｜</li>
            <li class="dropup">
                <span>Language</span>
                <span class="xbtn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></span>
                <ul class="dropdown-menu">
                    <li>{!! HTML::linkRoute(\Route::getCurrentRoute()->getName(), '繁體中文', array_merge(\Request::query(), ['lan' => 'zh-TW']), ['data-no-pjax']) !!}</li>
                    <li>{!! HTML::linkRoute(\Route::getCurrentRoute()->getName(), 'English', array_merge(\Request::query(), ['lan' => 'en']), ['data-no-pjax']) !!}</li>
                </ul>
            </li>
        </ul>
    </nav>
</footer>