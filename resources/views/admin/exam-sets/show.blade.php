@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

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
                <tr class="info">
                    <th>#</th>
                    <th>{{ trans('exam-questions.topic') }}</th>
                    <th>{{ trans('exam-questions.level') }}</th>
                    <th>{{ trans('exam-questions.multiple') }}</th>
                    <th class="hidden-xs">{{ trans('exam-questions.edit') }}</th>
                    <th class="hidden-xs">{{ trans('exam-questions.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exam_set->questions as $question)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.exam-questions.show', trans('exam-questions.show'), [$question->ssn]) !!}</td>
                        <td>
                            {!! HTML::nl2br($question->topic) !!}
                            @include('partials.image', ['image_ssn' => $question->image_ssn, 'use_text' => true])
                        </td>
                        <td>{!! HTML::show_question_level($question->level) !!}</td>
                        <td>{!! HTML::true_or_false($question->multiple) !!}</td>
                        <td class="hidden-xs">{!! HTML::edit_icon(route('admin.exam-questions.edit', ['exam_questions' => $question->ssn])) !!}</td>
                        <td class="hidden-xs">
                            @include('partials.delete-form', ['route' => ['admin.exam-questions.destroy', $question->ssn]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection