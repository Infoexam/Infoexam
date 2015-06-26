@extends(env('IS_PJAX') ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('test-applies.list')])

    <div class="text-center">
        {!! $test_lists->appends(Request::query())->render() !!}
    </div>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr class="info">
                    <th>{{ trans('test-lists.ssn') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.start_time') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.test_time') }}</th>
                    <th>{{ trans('test-lists.test_type') }}</th>
                    <th>{{ trans('test-lists.apply_type') }}</th>
                    <th>{{ trans('test-lists.std_apply_num') }}</th>
                    <th>{{ trans('test-applies.' . (('POST' === $method) ? 'apply' : 'transform')) }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($test_lists as $test_list)
                    <tr>
                        <td>{{ $test_list->ssn }}</td>
                        <td class="hidden-xs">{{ $test_list->start_time }}</td>
                        <td class="hidden-xs">{{ $test_list->end_time->diffInMinutes($test_list->start_time) }}</td>
                        <td class="{{ starts_with($test_list->test_type, '2') ? 'danger' : '' }}">{{ trans('test-lists.test_types.'.($test_list->test_type)) }}</td>
                        <td>{{ trans('test-lists.apply_types.'.($test_list->apply_type)) }}</td>
                        <td>{{ $test_list->std_apply_num . ' / ' . $test_list->std_num_limit }}</td>
                        <td>
                            {!! Form::open(['route' => [$route, $test_list->ssn], 'method' => $method]) !!}
                                {!! Form::button('<span class="glyphicon glyphicon-plus"></span>', [
                                        'type' => 'submit',
                                        'title' =>  trans('test-applies.' . (('POST' === $method) ? 'apply' : 'transform')),
                                        'class' => 'btn btn-default btn-lg'
                                    ])
                                !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop