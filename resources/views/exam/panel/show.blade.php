@extends($pjax ? 'exam.layouts.pjax' : 'exam.layouts.master')

@section('main')
    <div>
        <div>
            {!! HTML::link_button(route('exam.panel.index'), 'Go Back') !!}
        </div>
        <br>

        <table class="table table-hover table-bordered text-center">
            <thead>
                <tr class="info">
                    <th class="col-xs-3">{{ trans('test-lists.ssn') }}</th>
                    <th class="col-xs-3">{{ trans('test-lists.room') }}</th>
                    <th class="col-xs-3">{{ trans('test-lists.std_real_test_num') }}</th>
                    <th class="col-xs-3 danger">{{ trans('test-lists.test_started') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $test->ssn }}</td>
                    <td>{{ $test->room }}</td>
                    <td>{{ $test->std_real_test_num . ' / ' . $test->std_apply_num }}</td>
                    <td>
                        {!! Form::open(['route' => ['exam.panel.update', $test->ssn], 'method' => 'PATCH']) !!}
                            {!! Form::checkbox('test_started', true, $test->test_started, ['data-checkbox-switch', 'data-on-text' => '進行中', 'data-off-text' => '尚未開始']) !!}
                            {!! Form::hidden('type', 'test_started') !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-hover table-bordered text-center">
            <thead>
                <tr class="info">
                    <th class="col-xs-3">{{ trans('test-lists.start_time') }}</th>
                    <th class="col-xs-3">{{ trans('test-lists.end_time') }}</th>
                    <th class="col-xs-3">{{ trans('test-lists.test_time') }}</th>
                    <th class="col-xs-3 danger">{{ trans('test-lists.extend_time') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $test->start_time }}</td>
                    <td>{{ $test->end_time }}</td>
                    <td>{{ $test->end_time->diffInMinutes($test->start_time) }}</td>
                    <td>
                        {!! Form::open(['route' => ['exam.panel.update', $test->ssn], 'method' => 'PATCH']) !!}
                            <div class="row">
                                <div class="col-xs-1"></div>

                                <div class="col-xs-6">
                                    {!! Form::input('number', 'extend_time', 0, ['class' => 'form-control', 'required' => 'required', 'min' => 0]) !!}
                                </div>

                                <div class="col-xs-4">
                                    {!! Form::submit(trans('general.update'), ['class' => 'btn btn-danger form-control']) !!}
                                </div>

                                <div class="col-xs-1"></div>
                            </div>

                            {!! Form::hidden('type', 'extend_time') !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(function()
        {
            $('input[data-checkbox-switch]').on('switchChange.bootstrapSwitch', function(event, state) {
                $(this).bootstrapSwitch('toggleReadonly', true);

                $(this).closest('form').submit();
            });
        });
    </script>
@endsection