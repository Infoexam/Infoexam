@extends(env('IS_PJAX') ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('announcements.list')])

    <div class="text-center">
        {!! $announcements->appends(Request::query())->render() !!}
    </div>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr class="info">
                    <th>{{ trans('announcements.title') }}</th>
                    <th>{{ trans('announcements.updated_at') }}</th>
                    <th class="hidden-xs">{{ trans('announcements.created_at') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td class="text-left announcement-heading">{!! HTML::linkRoute('student.announcements.show', $announcement->heading, ['heading' => $announcement->heading]) !!}</td>
                        <td title="{{ $announcement->updated_at }}">{{ $announcement->updated_at->diffForHumans() }}</td>
                        <td class="hidden-xs" title="{{ $announcement->created_at }}">{{ $announcement->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop