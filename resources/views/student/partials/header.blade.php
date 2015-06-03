<header class="center-block">
    <img class="banner" src="/assets/images/banner.png" alt="banner">
    <nav class="toolbar">
        @if(\App\Infoexam\Account\Account::isStudent())
            <ul class="list-inline pull-left">
                <li class="dropdown">
                    <a href="{{ route('student.member.info') }}">
                        <span class="btn">{{ \Auth::user()->username }}</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="{{ route('student.member.info') }}">
                        <span class="btn">{{ \Auth::user()->userData->name }}</span>
                    </a>
                </li>
            </ul>
        @endif
        <ul class="list-inline pull-right">
            <li class="dropdown">
                <a href="{{ route('student.index') }}" title="{{ trans('general.home') }}">
                    <span class="btn glyphicon glyphicon-home" aria-hidden="true"></span>
                </a>
            </li>
            <li class="dropdown">
                <a href="{{ route('student.announcements.index') }}">
                    <span class="btn">{{ trans('announcements.nav_title') }}</span>
                </a>
            </li>
            @if (\App\Infoexam\Account\Account::isStudent())
                <li class="dropdown">
                    <a href="{{ route('student.practice-exam.index') }}">
                        <span class="btn">{{ trans('practice-exam.title') }}</span>
                    </a>
                </li>
                <li class="dropdown">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">{{ trans('test-applies.title') }}{!! HTML::icon_menu_down() !!}</span>
                    <ul class="dropdown-menu">
                        <li>{!! HTML::linkRoute('student.test-applies.manage', trans('test-applies.manage')) !!}</li>
                        <li>{!! HTML::linkRoute('student.test-applies.apply', trans('test-applies.apply_student')) !!}</li>
                        <li>{!! HTML::linkRoute('student.test-applies.manage-unite', trans('test-applies.manage_unite')) !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">{{ trans('user.title') }}{!! HTML::icon_menu_down() !!}</span>
                    <ul class="dropdown-menu">
                        <li>{!! HTML::linkRoute('student.member.info', trans('user.info')) !!}</li>
                        <li>{!! HTML::linkRoute('student.test-applies.history', trans('test-applies.history')) !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="{{ route('student.logout') }}" title="{{ trans('general.logout') }}" data-no-pjax>
                        <span class="btn glyphicon glyphicon-log-out" aria-hidden="true"></span>
                    </a>
                </li>
            @endif
            @if( ! \Auth::check())
                <li class="dropdown">
                    <a href="{{ route('student.login') }}" title="{{ trans('general.login') }}">
                        <span class="btn glyphicon glyphicon-log-in" aria-hidden="true"></span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</header>