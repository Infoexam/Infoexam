@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('student-information.search')])

    <div class="text-center">
        {!! $accounts->appends(Request::query())->render() !!}
    </div>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>{{ trans('student-information.username') }}</th>
                    <th>{{ trans('student-information.name') }}</th>
                    <th>{{ trans('student-information.department') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as &$account)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.student-information.edit', $account->username, ['user' => $account->username]) !!}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->userData->department->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {!! $accounts->appends(Request::query())->render() !!}
    </div>
@stop