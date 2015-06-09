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
        <div class="col-lg-12 col-xs-12">學科測驗</div>
        @foreach ($exam_sets as &$exam_set)
            <div class="col-lg-3 col-xs-12 practice-exam text-center">
                {!! HTML::linkRoute('student.practice-exam.testing', $exam_set->name, ['exam_set_tag' => $exam_set->name], ['data-no-pjax']) !!}
            </div>
        @endforeach
    </div>
    <div>
        <div class="col-lg-12 col-xs-12">術科測驗</div>
    </div>
@stop