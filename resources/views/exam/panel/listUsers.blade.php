@extends($pjax ? 'exam.layouts.pjax' : 'exam.layouts.master')

@section('main')
    <div>
        <div>
            {!! HTML::link_button(route('exam.panel.show', ['ssn' => $test->ssn]), 'Go Back') !!}
        </div>

        <br>

        <table class="table table-hover table-bordered text-center">
            <thead>
                <tr class="info">
                    <th class="col-xs-2">{{ trans('user.id') }}</th>
                    <th class="col-xs-2">{{ trans('user.name') }}</th>
                    <th class="col-xs-2">{{ trans('exam.panel.tested') }}</th>
                    <th class="col-xs-3 danger">{{ trans('exam.panel.allowRelogin') }}</th>
                    <th class="col-xs-3 danger">{{ trans('test-lists.extend_time') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($test->applies as $apply)
                    <tr>
                        <td>{{ $apply->account->username }}</td>
                        <td>{{ $apply->account->userData->name }}</td>
                        <td>{!! HTML::true_or_false(null !== $apply->test_result_id) !!}</td>
                        @if (null === $apply->test_result_id)
                            <td>-</td>
                            <td>-</td>
                        @else
                            <td>
                                {!! Form::open(['route' => ['exam.panel.updateUser', 'ssn' => $test->ssn, 'user' => $apply->ssn], 'method' => 'PATCH']) !!}
                                    {!! Form::checkbox('allowRelogin', true, $apply->test_result->allow_relogin, ['data-checkbox-switch', 'data-on-text' => '是', 'data-off-text' => '否']) !!}
                                    {!! Form::hidden('type', 'allowRelogin') !!}
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(['route' => ['exam.panel.updateUser', 'ssn' => $test->ssn, 'user' => $apply->ssn], 'method' => 'PATCH']) !!}
                                    <div class="row">
                                        <div class="col-xs-1"></div>

                                        <div class="col-xs-6">
                                            {!! Form::input('number', 'exam_time_extends', $apply->test_result->exam_time_extends, ['class' => 'form-control', 'required' => 'required', 'min' => 0]) !!}
                                        </div>

                                        <div class="col-xs-4">
                                            {!! Form::submit(trans('general.update'), ['class' => 'btn btn-danger form-control']) !!}
                                        </div>

                                        <div class="col-xs-1"></div>
                                    </div>

                                    {!! Form::hidden('type', 'examTimeExtends') !!}
                                {!! Form::close() !!}
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(function()
        {
            $('input[data-checkbox-switch]').on('switchChange.bootstrapSwitch', function() {
                $(this).bootstrapSwitch('toggleReadonly', true);

                $(this).closest('form').submit();
            });
        });
    </script>
@endsection