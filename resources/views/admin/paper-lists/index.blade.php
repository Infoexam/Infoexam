@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('paper-lists.list')])

    <div>
        <ul class="list-inline">
            <li>
                {!! HTML::link_button(route('admin.paper-lists.create'), trans('paper-lists.create')) !!}
            </li>
            <li>
                {!! HTML::link_button(route('admin.paper-lists.index', array_merge(Request::query(), ['auto_generated' => ! $auto_generated])), trans('paper-lists.show_auto_generate_'.intval( ! $auto_generated))) !!}
            </li>
        </ul>
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr class="info">
                    <th>{{ trans('paper-lists.name') }}</th>
                    <th>{{ trans('paper-lists.remark') }}</th>
                    <th class="hidden-xs">{{ trans('paper-questions.create') }}</th>
                    <th class="hidden-xs">{{ trans('paper-lists.edit') }}</th>
                    <th class="hidden-xs">{{ trans('paper-lists.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paper_lists as $paper)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.paper-lists.show', $paper->name, ['paper_lists' => $paper->ssn]) !!}</td>
                        <td>{!! HTML::nl2br($paper->remark) !!}</td>
                        <td class="hidden-xs">{!! HTML::create_icon(route('admin.paper-questions.create', ['ssn' => $paper->ssn])) !!}</td>
                        <td class="hidden-xs">{!! HTML::edit_icon(route('admin.paper-lists.edit', ['paper_lists' => $paper->ssn])) !!}</td>
                        <td class="hidden-xs">
                            @include('partials.delete-form', ['route' => ['admin.paper-lists.destroy', $paper->ssn, 'auto_generated' => $auto_generated, 'page' => $paper_lists->currentPage()]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {!! $paper_lists->appends(Request::query())->render() !!}
    </div>
@endsection