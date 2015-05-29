@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('announcements.list')])

    <div>
        {!! HTML::link_button(route('admin.announcements.create', [], true), trans('announcements.create')) !!}
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>{{ trans('announcements.title') }}</th>
                    <th>{{ trans('announcements.updated_at') }}</th>
                    <th>{{ trans('announcements.created_at') }}</th>
                    <th>{{ trans('announcements.edit') }}</th>
                    <th>{{ trans('announcements.delete.image') }}</th>
                    <th>{{ trans('announcements.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($announcements as $announcement)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.announcements.show', $announcement->heading, [$announcement->id]) !!}</td>
                        <td title="{{ $announcement->updated_at }}">{{ $announcement->updated_at->diffForHumans() }}</td>
                        <td title="{{ $announcement->created_at }}">{{ $announcement->created_at->diffForHumans() }}</td>
                        <td>{!! HTML::edit_icon(route('admin.announcements.edit', ['id' => $announcement->id]) ) !!}</td>
                        <td>
                            @include('partials.delete-form', ['route' => ['admin.announcements.destroy.images', $announcement->id]])
                        </td>
                        <td>
                            @include('partials.delete-form', ['route' => ['admin.announcements.destroy', $announcement->id]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {!! $announcements->render() !!}
    </div>
@stop