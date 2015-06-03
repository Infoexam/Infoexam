@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    <div>
        <h2>Logs</h2>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>Level</th>
                    <th>Username</th>
                    <th>Action</th>
                    <th>Content</th>
                    <th>Remark</th>
                    <th>IP Address</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as &$log)
                    <tr>
                        <td>{{ $log->text->{'level'} }}</td>
                        <td>{{ $log->user->getAttribute('username') }}</td>
                        <td>{{ $log->text->{'action'} }}</td>
                        <td>{{ $log->text->{'content'} }}</td>
                        <td>{{ $log->text->{'remark'} }}</td>
                        <td>{{ $log->ip_address }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop