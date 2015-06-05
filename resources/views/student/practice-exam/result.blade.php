@extends(env('IS_PJAX') ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('practice-exam.result')])

    <div class="text-danger">
        <p>{{ trans('general.attention') }}：</p>
        <ul>
            <li>{{ trans('practice-exam.questions_are_copyright') }}</li>
        </ul>
    </div>
    <div>
        {{ trans('practice-exam.score') . '：' . $score . ' '. trans('practice-exam.point') }}
    </div>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <td>{{ trans('exam-questions.topic') }}</td>
                    <td>{{ trans('exam-questions.answer') }}</td>
                    <td>{{ trans('exam-questions.explanation') }}</td>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as &$question)
                    <tr>
                        <td>{!! HTML::nl2br(str_limit($question->topic, 15, ' ...')) !!}</td>
                        <td>
                            @foreach($question->answer as $answer)
                                {!! HTML::nl2br($question->options[$answer-1]->content) !!}
                                <br>
                            @endforeach
                        </td>
                        <td>{!! HTML::nl2br(str_limit($question->explanation, 15, ' ...')) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop