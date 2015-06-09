@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('exam-set-tags.list')])

    <div>
        {!! HTML::link_button(route('admin.exam-set-tags.create'), trans('exam-set-tags.create')) !!}
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>{{ trans('exam-set-tags.name') }}</th>
                    <th>{{ trans('exam-set-tags.edit') }}</th>
                    <th>{{ trans('exam-set-tags.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.exam-set-tags.show', $tag->name, ['exam_set_tags' => $tag->name]) !!}</td>
                        <td>{!! HTML::edit_icon(route('admin.exam-set-tags.edit', ['exam_set_tags' => $tag->name])) !!}</td>
                        <td>
                            @include('partials.delete-form', ['route' => ['admin.exam-set-tags.destroy', $tag->name]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop