@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    <div>
        <h2>Logs</h2>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th class="hidden-xs">Level</th>
                    <th>Username</th>
                    <th>Action</th>
                    <th class="hidden-xs">Content</th>
                    <th class="hidden-xs">Remark</th>
                    <th class="hidden-xs">Agent</th>
                    <th class="hidden-xs">IP Address</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td class="hidden-xs">{{ $log->text->{'level'} }}</td>
                        <td>{{ $log->user->getAttribute('username') }}</td>
                        <td>{{ $log->text->{'action'} }}</td>
                        <td class="hidden-xs">{{ $log->text->{'content'} }}</td>
                        <td class="hidden-xs">{{ $log->text->{'remark'} }}</td>
                        <td class="hidden-xs" title="{{ $log->text->{'agent'} or 'none' }}">show</td>
                        <td class="hidden-xs">{{ $log->ip_address }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop