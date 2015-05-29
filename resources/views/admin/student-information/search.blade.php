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
                    <th>#</th>
                    <th>{{ trans('student-information.username') }}</th>
                    <th>{{ trans('student-information.name') }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                @foreach($accounts as $account)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{!! HTML::linkRoute('admin.student-information.edit', $account->username, ['user' => $account->username]) !!}</td>
                        <td>{{ $account->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {!! $accounts->appends(Input::query())->render() !!}
    </div>
@stop