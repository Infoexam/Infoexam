@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => (trans('exam-sets.name') . '：' . $exam_set->name)])

    <div>
        {!! HTML::link_button(route('admin.exam-sets.index'), trans('exam-sets.list')) !!}
        {!! HTML::link_button(route('admin.exam-questions.create', ['ssn' => $exam_set->ssn]), trans('exam-questions.create')) !!}
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('exam-questions.topic') }}</th>
                    <th>{{ trans('exam-questions.level') }}</th>
                    <th>{{ trans('exam-questions.multiple') }}</th>
                    <th>{{ trans('exam-questions.edit') }}</th>
                    <th>{{ trans('exam-questions.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $question)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.exam-questions.show', trans('exam-questions.show'), [$question->ssn]) !!}</td>
                        <td>
                            {!! HTML::nl2br($question->topic) !!}
                            @include('partials.image', ['image_ssn' => $question->image_ssn, 'use_text' => true])
                        </td>
                        <td>{!! HTML::show_question_level($question->level) !!}</td>
                        <td>{!! HTML::true_or_false($question->multiple) !!}</td>
                        <td>{!! HTML::edit_icon(route('admin.exam-questions.edit', ['exam_questions' => $question->ssn])) !!}</td>
                        <td>
                            @include('partials.delete-form', ['route' => ['admin.exam-questions.destroy', $question->ssn]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop