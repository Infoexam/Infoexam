@extends(env('IS_PJAX') ? 'student.layouts.pjax' : 'student.layouts.master')

@section('heading')
    <blockquote>
        <div class="page-header">
            <h2>{{ trans('announcements.list') }}</h2>
        </div>
    </blockquote>
@stop

@section('main')
    <div>
        <div class="text-center">
            {!! $announcements->render() !!}
        </div>
        <div>
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>{{ trans('announcements.title') }}</th>
                        <th>{{ trans('announcements.updated_at') }}</th>
                        <th>{{ trans('announcements.created_at') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($announcements as $announcement)
                        <tr>
                            <td>{!! HTML::linkRoute('student.announcements.show', $announcement->heading, ['heading' => $announcement->heading]) !!}</td>
                            <td title="{{ $announcement->updated_at }}">{{ $announcement->updated_at->diffForHumans() }}</td>
                            <td title="{{ $announcement->created_at }}">{{ $announcement->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop