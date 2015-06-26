@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('test-lists.list')])

    <div>
        <ul class="list-inline">
            <li>
                {!! HTML::link_button(route('admin.test-lists.create'), trans('test-lists.create')) !!}
            </li>
            <li>
                {!! HTML::link_button(route('admin.test-lists.index', array_merge(Request::query(), ['tested' => ! $tested])), trans('test-lists.show_tested_'.intval( ! $tested))) !!}
            </li>
        </ul>
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr class="info">
                    <th>{{ trans('test-lists.ssn') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.start_time') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.test_time') }}</th>
                    <th>{{ trans('test-lists.test_type') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.apply_type') }}</th>
                    <th>{{ trans('test-lists.std_apply_num') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.test_enable') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.allow_apply') }}</th>
                    <th class="hidden-xs">{{ trans('test-lists.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($test_lists as $test_list)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.test-lists.show', $test_list->ssn, ['test_lists' => $test_list->ssn]) !!}</td>
                        <td class="hidden-xs">{{ $test_list->start_time }}</td>
                        <td class="hidden-xs">{{ $test_list->end_time->diffInMinutes($test_list->start_time) }}</td>
                        <td>{{ trans('test-lists.test_types.'.($test_list->test_type)) }}</td>
                        <td class="hidden-xs">{{ trans('test-lists.apply_types.'.($test_list->apply_type)) }}</td>
                        <td>{{ $test_list->std_apply_num . ' / ' .$test_list->std_num_limit }}</td>
                        <td class="hidden-xs">
                            {!! Form::open(['route' => ['admin.test-lists.update', $test_list->ssn], 'method' => 'PATCH']) !!}
                                {!! Form::checkbox('test_enable', true, $test_list->test_enable, ['data-checkbox-switch', 'data-on-text' => trans('general.on'), 'data-off-text' => trans('general.off'), ($check_time = ((\Carbon\Carbon::now() >= $test_list->start_time) ? 'disabled' : 'data-nothing'))]) !!}
                                {!! Form::hidden('page', \Request::input('page', 1)) !!}
                                {!! Form::hidden('type', 'test_enable') !!}
                            {!! Form::close() !!}
                        </td>
                        <td class="hidden-xs">
                            {!! Form::open(['route' => ['admin.test-lists.update', $test_list->ssn], 'method' => 'PATCH']) !!}
                                {!! Form::checkbox('allow_apply', true, $test_list->allow_apply, ['data-checkbox-switch', 'data-on-text' => trans('general.open'), 'data-off-text' => trans('general.off'), $check_time]) !!}
                                {!! Form::hidden('page', \Request::input('page', 1)) !!}
                                {!! Form::hidden('type', 'apply_status') !!}
                            {!! Form::close() !!}
                        </td>
                        <td class="hidden-xs">
                            @if ('disabled' === $check_time)
                                -
                            @else
                                @include('partials.delete-form', ['route' => ['admin.test-lists.destroy', $test_list->ssn]])
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr class="hidden-xs">
                    <td colspan="6">全部選取</td>
                    <td>
                        {!! Form::open(['route' => ['admin.test-lists.update.all'], 'method' => 'PATCH']) !!}
                            {!! Form::hidden('list', $test_list_ssn) !!}
                            {!! Form::hidden('page', Request::input('page', 1)) !!}
                            {!! Form::hidden('type', 'test_enable_all') !!}
                            {!! Form::hidden('update_all_status', 1) !!}
                            {!! Form::submit(trans('general.on'), ['class' => 'btn btn-success', 'data-update-status' => 1]) !!}
                            {!! Form::submit(trans('general.off'), ['class' => 'btn btn-default', 'data-update-status' => 0]) !!}
                        {!! Form::close() !!}
                    </td>
                    <td>
                        {!! Form::open(['route' => ['admin.test-lists.update.all'], 'method' => 'PATCH']) !!}
                            {!! Form::hidden('list', $test_list_ssn) !!}
                            {!! Form::hidden('page', Request::input('page', 1)) !!}
                            {!! Form::hidden('type', 'apply_status_all') !!}
                            {!! Form::hidden('update_all_status', 1) !!}
                            {!! Form::submit(trans('general.open'), ['class' => 'btn btn-success', 'data-update-status' => 1]) !!}
                            {!! Form::submit(trans('general.off'), ['class' => 'btn btn-default', 'data-update-status' => 0]) !!}
                        {!! Form::close() !!}
                    </td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {!! $test_lists->appends(Request::query())->render() !!}
    </div>
@stop

@section('scripts')
    <script>
        $(function()
        {
            $('input[data-checkbox-switch]').on('switchChange.bootstrapSwitch', function(event, state) {
                $(this).bootstrapSwitch('toggleReadonly', true);

                $(this).closest('form').submit();
            });

            $('input[data-update-status], button[data-update-status]').click(function()
            {
                var status_value = $(this).data('update-status');

                $('input[name="update_all_status"]').val(status_value);
            });
        });
    </script>
@stop