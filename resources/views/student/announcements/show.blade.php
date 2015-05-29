@extends(env('IS_PJAX') ? 'student.layouts.pjax' : 'student.layouts.master')

@section('heading')
    <blockquote>
        <div class="page-header">
            <h2>{{ $announcement->heading }}</h2>
        </div>
    </blockquote>
@stop

@section('main')
    <div>
        <div>
            {!! $announcement->content !!}
        </div>

        @if( ! is_null($announcement->image_ssn))
            @foreach($announcement->image_ssn as $image_ssn)
                @include('partials.image', ['image_ssn' => $image_ssn])
            @endforeach
        @endif

        @if ( ! is_null($announcement->link))
            <span>
                {{ trans('announcements.link').'：' }}
                {!! HTML::link($announcement->link, null, ['target' => '_blank'])  !!}
            </span>
        @endif
        <span title="{{ $announcement->updated_at }}">{{ trans('announcements.updated_at').'：'.$announcement->updated_at->diffForHumans() }}</span>
        <span title="{{ $announcement->created_at }}">{{ trans('announcements.created_at').'：'.$announcement->created_at->diffForHumans() }}</span>
    </div>
@stop