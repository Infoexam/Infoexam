@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('account-groups.list')])

    <div>
        {!! HTML::link_button(route('admin.account-groups.create'), trans('account-groups.create')) !!}
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>{{ trans('account-groups.name') }}</th>
                    <th>{{ trans('account-groups.edit') }}</th>
                    <th>{{ trans('account-groups.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as &$group)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.account-groups.show', $group->name, ['account_groups' => $group->id]) !!}</td>
                        <td>{!! HTML::edit_icon(route('admin.account-groups.edit', ['id' => $group->id])) !!}</td>
                        <td>
                            @include('partials.delete-form', ['route' => ['admin.account-groups.destroy', $group->id]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {!! $groups->render() !!}
    </div>
@stop