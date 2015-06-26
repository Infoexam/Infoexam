@extends(env('IS_PJAX') ? 'exam.layouts.pjax' : 'exam.layouts.master')

@section('main')
    <div>
        @foreach ($exams as $exam)
            <table class="table table-hover table-bordered text-center">
                <thead>
                    <tr class="info">
                        <th class="col-xs-3">{{ trans('test-lists.ssn') }}</th>
                        <th class="col-xs-3">{{ trans('test-lists.room') }}</th>
                        <th class="col-xs-3">{{ trans('test-lists.start_time') }}</th>
                        <th class="col-xs-3">{{ trans('test-lists.test_started') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{!! HTML::linkRoute('exam.panel.show', $exam->ssn, ['ssn' => $exam->ssn]) !!}</td>
                        <td>{{ $exam->room }}</td>
                        <td>{{ $exam->start_time->format('m-d H:s') }}</td>
                        <td>{!! HTML::true_or_false($exam->test_started) !!}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    </div>
@stop