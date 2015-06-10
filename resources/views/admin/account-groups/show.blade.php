@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => $group->name . ' - ' . trans('account-groups.show')])

    <div>
        {!! HTML::link_button(route('admin.account-groups.index'), trans('account-groups.list')) !!}
    </div>
    <br>
    <div class="text-center">
        {!! $accounts->appends(Request::query())->render() !!}
    </div>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>{{ trans('student-information.username') }}</th>
                    <th>{{ trans('student-information.name') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as &$account)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.student-information.edit', $account->username, ['user' => $account->username]) !!}</td>
                        <td>{{ $account->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {!! $accounts->appends(Request::query())->render() !!}
    </div>
@stop