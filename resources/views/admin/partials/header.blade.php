<header class="center-block">
    {!! HTML::image('assets/images/banner.png', 'banner', ['class' => 'banner'], true) !!}
    @if (\App\Infoexam\Account\Account::isAdmin())
        <div class="toolbar">
            <div class="navbar-header">
                <span class="cursor-pointer navbar-toggle collapsed glyphicon glyphicon-th-list" data-toggle="collapse" data-target="#collapse-menu"></span>
                <a href="{{ route('admin.index') }}" title="{{ trans('general.home') }}">
                    <span class="xbtn glyphicon glyphicon-home"></span>
                </a>
                <a href="{{ route('admin.logout') }}" title="{{ trans('general.logout') }}" data-no-pjax>
                    <span class="xbtn glyphicon glyphicon-log-out" aria-hidden="true"></span>
                </a>
            </div>
            <nav class="collapse navbar-collapse" id="collapse-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        {!! HTML::navigation_dropdown_title(trans('student-information.nav_title')) !!}
                        <ul class="dropdown-menu">
                            <li>{!! HTML::linkRoute('admin.student-information.index', trans('student-information.title')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.sync-student-data.index', trans('sync-student-data.title')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.account-groups.index', trans('account-groups.title')) !!}</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        {!! HTML::navigation_dropdown_title(trans('test-lists.title')) !!}
                        <ul class="dropdown-menu">
                            <li>{!! HTML::linkRoute('admin.test-lists.index', trans('test-lists.list')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.test-lists.create', trans('test-lists.create')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.exam-configs.edit', trans('exam-configs.title')) !!}</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        {!! HTML::navigation_dropdown_title(trans('paper-lists.title')) !!}
                        <ul class="dropdown-menu">
                            <li>{!! HTML::linkRoute('admin.paper-lists.index', trans('paper-lists.list')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.paper-lists.create', trans('paper-lists.create')) !!}</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        {!! HTML::navigation_dropdown_title(trans('exam-sets.title')) !!}
                        <ul class="dropdown-menu">
                            <li>{!! HTML::linkRoute('admin.exam-sets.index', trans('exam-sets.list')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.exam-sets.create', trans('exam-sets.create')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.exam-set-tags.index', trans('exam-set-tags.title')) !!}</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        {!! HTML::navigation_dropdown_title(trans('website-configs.nav_title')) !!}
                        <ul class="dropdown-menu">
                            <li>{!! HTML::linkRoute('admin.announcements.index', trans('announcements.list')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.announcements.create', trans('announcements.create')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.website-configs.edit', trans('website-configs.title')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.website-configs.ips.index', trans('website-configs.ips.title')) !!}</li>
                            <li>{!! HTML::linkRoute('admin.website-logs', 'Logs') !!}</li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    @endif
</header>