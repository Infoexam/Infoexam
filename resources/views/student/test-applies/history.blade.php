@extends($pjax ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('test-applies.history')])

    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr class="info">
                    <th>{{ trans('test-lists.ssn') }}</th>
                    <th>{{ trans('test-lists.test_type') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.apply_type') }}</th>
                    <th>{{ trans('test-applies.scores') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($test_applies as $test_apply)
                    <tr>
                        <td>{{ $test_apply->test_list->ssn }}</td>
                        <td>{{ trans('test-lists.test_types.'.($test_apply->test_list->test_type)) }}</td>
                        <td class="hidden-xs">{{ trans('test-lists.apply_types.'.($test_apply->test_list->apply_type)) }}</td>
                        <td>{{ (null === $test_apply->test_result) ? trans('test-scores.absent') : ((null === $test_apply->test_result->score) ? trans('test-scores.scoreNotArrive') : $test_apply->test_result->score) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection