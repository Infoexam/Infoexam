@extends($pjax ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    <div class="row">
        <div class="col-xs-12 col-lg-5">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="info">
                        <th>{{ trans('test-lists.room') }}</th>
                        <th>{{ trans('test-lists.test_type') }}</th>
                        <th>{{ trans('test-lists.start_time') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($test_lists as $test_list)
                        <tr>
                            <td>{{ $test_list->room }}</td>
                            <td>{{ trans('test-lists.test_types.' . $test_list->test_type) }}</td>
                            <td>{{ $test_list->start_time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-xs-12 col-lg-7">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="info">
                        <th>{{ trans('announcements.heading') }}</th>
                        <th>{{ trans('announcements.created_at') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($announcements as $announcement)
                        <tr>
                            <td class="text-left announcement-heading">{!! HTML::linkRoute('student.announcements.show', $announcement->heading, ['heading' => $announcement->heading]) !!}</td>
                            <td title="{{ $announcement->created_at }}">{{ $announcement->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection