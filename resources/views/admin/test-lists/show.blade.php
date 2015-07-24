@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('test-applies.applies')])

    <div>
        <ul class="list-inline">
            <li>
                {!! HTML::link_button(route('admin.test-lists.index'), trans('test-applies.list')) !!}
            </li>
            <li>
                {!! HTML::link_button(route('admin.test-lists.apply', ['ssn' => $ssn]), trans('test-applies.apply')) !!}
            </li>
            <li>
                <a href="{{ route('admin.test-lists.dl-pc2-list', ['ssn' => $ssn]) }}" data-no-pjax><button class="btn btn-primary">{{ trans('test-applies.dlPc2List') }}</button></a>
            </li>
        </ul>
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr class="info">
                    <th>{{ trans('user.id') }}</th>
                    <th>{{ trans('user.name') }}</th>
                    <th class="hidden-xs">{{ trans('test-applies.apply.time') }}</th>
                    <th>{{ trans('test-applies.paid_status') }}</th>
                    <th class="hidden-xs">{{ trans('test-applies.apply.cancel') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applies as $apply)
                    <tr>
                        <td>{{ $apply->account->username }}</td>
                        <td>{{ $apply->account->userData->name }}</td>
                        <td class="hidden-xs">{{ $apply->apply_time }}</td>
                        <td>{!! HTML::true_or_false(null !== $apply->paid_at) !!}</td>
                        <td class="hidden-xs">
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
@endsection