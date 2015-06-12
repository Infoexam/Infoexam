@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('website-configs.ips.list')])

    <div class="text-danger">
        <p>{{ trans('general.attention') }}：</p>
        <ul>
            <li>{{ trans('website-configs.ips.student_page_blacklist') }}</li>
            <li>{{ trans('website-configs.ips.exam_admin_page_whitelist') }}</li>
        </ul>
    </div>
    <div>
        {!! HTML::link_button(route('admin.website-configs.ips.create'), trans('website-configs.ips.create')) !!}
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>{{ trans('website-configs.ips.ip') }}</th>
                    <th>{{ trans('website-configs.ips.student_page') }}</th>
                    <th>{{ trans('website-configs.ips.exam_page') }}</th>
                    <th>{{ trans('website-configs.ips.admin_page') }}</th>
                    <th class="hidden-xs">{{ trans('website-configs.ips.edit') }}</th>
                    <th class="hidden-xs">{{ trans('website-configs.ips.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ips as $ip)
                    <tr>
                        <td>{{ $ip->ip }}</td>
                        <td>{!! HTML::true_or_false($ip->student_page) !!}</td>
                        <td>{!! HTML::true_or_false($ip->exam_page) !!}</td>
                        <td>{!! HTML::true_or_false($ip->admin_page) !!}</td>
                        <td class="hidden-xs">{!! HTML::edit_icon(route('admin.website-configs.ips.edit', ['ips' => $ip->id])) !!}</td>
                        <td class="hidden-xs">
                            @include('partials.delete-form', ['route' => ['admin.website-configs.ips.destroy', $ip->id]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop