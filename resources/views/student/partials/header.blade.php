<header class="center-block">
    {!! HTML::image('assets/images/banner.png', 'banner', ['class' => 'banner'], true) !!}
    <div class="toolbar">
        <div class="navbar-header">
            <span class="cursor-pointer navbar-toggle collapsed glyphicon glyphicon-th-list" data-toggle="collapse" data-target="#collapse-menu"></span>
            <a href="{{ route('student.index') }}" title="{{ trans('general.home') }}">
                <span class="xbtn glyphicon glyphicon-home" aria-hidden="true"></span>
            </a>
            @if ($guard->guest())
                <a href="{{ route('student.login') }}" title="{{ trans('general.login') }}">
                    <span class="xbtn glyphicon glyphicon-log-in" aria-hidden="true"></span>
                </a>
            @else
                <a href="{{ route('student.logout') }}" title="{{ trans('general.logout') }}" data-no-pjax>
                    <span class="xbtn glyphicon glyphicon-log-out" aria-hidden="true"></span>
                </a>
            @endif
        </div>
        <nav class="collapse navbar-collapse" id="collapse-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="xbtn" href="{{ route('student.announcements.index') }}">
                        {{ trans('announcements.nav_title') }}
                    </a>
                </li>
                @if ( ! $guard->guest() && $guard->user()->isStudent())
                    <li class="dropdown">
                        <a class="xbtn" href="{{ route('student.practice-exam.index') }}">
                            {{ trans('practice-exam.title') }}
                        </a>
                    </li>
                    <li class="dropdown">
                        {!! HTML::navigation_dropdown_title(trans('test-applies.title')) !!}
                        <ul class="dropdown-menu">
                            <li>{!! HTML::linkRoute('student.test-applies.manage', trans('test-applies.manage')) !!}</li>
                            <li>{!! HTML::linkRoute('student.test-applies.apply', trans('test-applies.apply_student')) !!}</li>
                            <li>{!! HTML::linkRoute('student.test-applies.manage-unite', trans('test-applies.manage_unite')) !!}</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        {!! HTML::navigation_dropdown_title(trans('user.title')) !!}
                        <ul class="dropdown-menu">
                            <li>{!! HTML::linkRoute('student.member.info', trans('user.info')) !!}</li>
                            <li>{!! HTML::linkRoute('student.test-applies.history', trans('test-applies.history')) !!}</li>
                        </ul>
                    </li>
                @endif
                <li class="dropdown">
                    <a class="xbtn" href="{{ route('student.faqs.index') }}">
                        {{ trans('faqs.nav_title') }}
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-right stu-info">
                @if ( ! $guard->guest() && $guard->user()->isStudent())
                    <li class="pull-right">
                        <a class="xbtn" href="{{ route('student.member.info') }}">
                            <span>{{ $guard->user()->username }}</span>
                        </a>
                    </li>
                    <li class="pull-right">
                        <a class="xbtn" href="{{ route('student.member.info') }}">
                            <span>{{ $guard->user()->userData->name }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</header>