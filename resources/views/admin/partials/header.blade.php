<header class="center-block">
    <img class="banner" src="/assets/images/banner.png" alt="banner">
    @if (\App\Infoexam\Account\Account::isAdmin())
        <nav class="toolbar">
            <ul class="list-inline pull-right">
                <li class="dropdown">
                    <a href="{{ route('admin.index') }}" title="{{ trans('general.home') }}">
                        <span class="btn glyphicon glyphicon-home" aria-hidden="true"></span>
                    </a>
                </li>
                <li class="dropdown">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">{{ trans('student-information.nav_title') }}{!! HTML::icon_menu_down() !!}</span>
                    <ul class="dropdown-menu">
                        <li>{!! HTML::linkRoute('admin.student-information.index', trans('student-information.title')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.sync-student-data.index', trans('sync-student-data.title')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.account-groups.index', trans('account-groups.title')) !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">{{ trans('test-lists.title') }}{!! HTML::icon_menu_down() !!}</span>
                    <ul class="dropdown-menu">
                        <li>{!! HTML::linkRoute('admin.test-lists.index', trans('test-lists.list')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.test-lists.create', trans('test-lists.create')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.exam-configs.edit', trans('exam-configs.title')) !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">{{ trans('paper-lists.title') }}{!! HTML::icon_menu_down() !!}</span>
                    <ul class="dropdown-menu">
                        <li>{!! HTML::linkRoute('admin.paper-lists.index', trans('paper-lists.list')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.paper-lists.create', trans('paper-lists.create')) !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">{{ trans('exam-sets.title') }}{!! HTML::icon_menu_down() !!}</span>
                    <ul class="dropdown-menu">
                        <li>{!! HTML::linkRoute('admin.exam-sets.index', trans('exam-sets.list')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.exam-sets.create', trans('exam-sets.create')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.exam-set-tags.index', trans('exam-set-tags.title')) !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">{{ trans('website-configs.nav_title') }}{!! HTML::icon_menu_down() !!}</span>
                    <ul class="dropdown-menu">
                        <li>{!! HTML::linkRoute('admin.announcements.index', trans('announcements.list')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.announcements.create', trans('announcements.create')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.website-configs.edit', trans('website-configs.title')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.website-configs.ips.index', trans('website-configs.ips.title')) !!}</li>
                        <li>{!! HTML::linkRoute('admin.website-logs', 'Logs') !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="{{ route('admin.logout') }}" title="{{ trans('general.logout') }}" data-no-pjax>
                        <span class="btn glyphicon glyphicon-log-out" aria-hidden="true"></span>
                    </a>
                </li>
            </ul>
        </nav>
    @endif
</header>
