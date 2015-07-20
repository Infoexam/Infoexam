@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => $announcement->heading])

    <div>
        <ul class="list-inline">
            <li>
                {!! HTML::link_button(route('admin.announcements.edit', ['announcements' => $announcement->id]), trans('announcements.edit')) !!}
            </li>
            <li>
                {!! Form::open(['route' => ['admin.announcements.destroy.images', $announcement->id], 'method' => 'DELETE']) !!}
                    {!! Form::button(e(trans('announcements.delete.image')), [
                            'type' => 'submit',
                            'class' => 'btn btn-primary',
                            'data-toggle' => 'modal',
                            'data-target' => '#delete-confirm'
                        ])
                    !!}
                {!! Form::close() !!}
            </li>
        </ul>
    </div>
    <br>
    <div class="announcement-show">
        <div class="announcement-img clearfix">
            @if (isset($announcement->image_ssn))
                @include('partials.image', ['image_ssn' => $announcement->image_ssn])
            @endif
        </div>
        
        <div class="announcement-content">
            {!! $announcement->content !!}
        </div>

        @if (null !== $announcement->link)
            <span class="release-info">
                {{ trans('announcements.link').'：' }}
                {!! HTML::link($announcement->link, null, ['target' => '_blank'])  !!}
            </span>
        @endif
        <span class="release-info" title="{{ $announcement->updated_at }}">{{ trans('announcements.updated_at').'：'.$announcement->updated_at->diffForHumans() }}</span>
        <span class="release-info" title="{{ $announcement->created_at }}">{{ trans('announcements.created_at').'：'.$announcement->created_at->diffForHumans() }}</span>
    </div>
@endsection