@extends($pjax ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('test-applies.applies')])

    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr class="info">
                    <th>{{ trans('test-lists.ssn') }}</th>
                    <th>{{ trans('test-lists.start_time') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.test_time') }}</th>
                    <th>{{ trans('test-lists.room') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.test_type') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.apply_type') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.std_apply_num') }}</th>
                    <th>{{ trans('test-applies.paid_status') }}</th>
                    <th class="hidden-xs danger">{{ trans('test-applies.apply.cancel') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($test_applies as $test_apply)
                    <tr>
                        <td>{{ $test_apply->test_list->ssn }}</td>
                        <td>{{ $test_apply->test_list->start_time }}</td>
                        <td class="hidden-xs">{{ $test_apply->test_list->end_time->diffInMinutes($test_apply->test_list->start_time) }}</td>
                        <td>{{ $test_apply->test_list->room }}</td>
                        <td class="hidden-xs">{{ trans('test-lists.test_types.'.($test_apply->test_list->test_type)) }}</td>
                        <td class="hidden-xs">{{ trans('test-lists.apply_types.'.($test_apply->test_list->apply_type)) }}</td>
                        <td class="hidden-xs">{{ $test_apply->test_list->std_apply_num . ' / ' . $test_apply->test_list->std_num_limit }}</td>
                        <td>{!! HTML::true_or_false(null !== $test_apply->paid_at) !!}</td>
                        <td class="hidden-xs">
                            @include('partials.delete-form', ['route' => ['student.test-applies.destroy', $test_apply->ssn]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection