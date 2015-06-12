@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => $name])

    <div>
        <ul>
            @foreach ($exam_set_tag->exam_sets as $exam_set)
                <li>{!! HTML::linkRoute('admin.exam-sets.show', $exam_set->name, ['exam_sets' => $exam_set->ssn]) !!}</li>
            @endforeach
        </ul>
    </div>
    <div>
        {!! HTML::link_button(route('admin.exam-set-tags.index'), trans('exam-set-tags.list')) !!}
    </div>
@stop