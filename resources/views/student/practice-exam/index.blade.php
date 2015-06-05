@extends(env('IS_PJAX') ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('practice-exam.exam_sets_select')])

    <div class="text-danger">
        <p>{{ trans('general.attention') }}：</p>
        <ul>
            <li>{{ trans('practice-exam.like_real_exam') }}</li>
            <li>{{ trans('practice-exam.questions_are_copyright') }}</li>
        </ul>
    </div>
    <div>
        @foreach($exam_sets as &$exam_set)
            <div>
                {!! HTML::linkRoute('student.practice-exam.testing', $exam_set->name, ['exam_set_tag' => $exam_set->name], ['data-no-pjax']) !!}
            </div>
        @endforeach
    </div>
@stop