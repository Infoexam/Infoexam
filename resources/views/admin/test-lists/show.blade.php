@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('test-applies.applies')])

    <div>
        {!! HTML::link_button(route('admin.test-lists.index'), trans('test-applies.list')) !!}
        {!! HTML::link_button(route('admin.test-lists.apply', ['ssn' => $ssn]), trans('test-applies.apply')) !!}
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>{{ trans('user.id') }}</th>
                    <th>{{ trans('user.name') }}</th>
                    <th>{{ trans('test-applies.apply.time') }}</th>
                    <th>{{ trans('test-applies.paid_status') }}</th>
                    <th>{{ trans('test-applies.apply.cancel') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applies as $apply)
                    <tr>
                        <td>{{ $apply->account->username }}</td>
                        <td>{{ $apply->account->userData->name }}</td>
                        <td>{{ $apply->apply_time }}</td>
                        <td>{!! HTML::true_or_false(null !== $apply->paid_at) !!}</td>
                        <td>
                            @include('partials.delete-form', ['route' => ['admin.test-lists.apply.destroy', $ssn, $apply->ssn]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {!! $applies->render() !!}
    </div>
@stop