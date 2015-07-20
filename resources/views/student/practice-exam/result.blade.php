@extends($pjax ? 'student.layouts.pjax' : 'student.layouts.master')

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
                    <td>{{ trans('practice-exam.correct_or_not') }}</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>
                            <span class="shorten-content">{!! HTML::nl2br(str_limit($question->topic, 15, ' ...')) !!}</span>
                            <span class="hidden">{!! HTML::nl2br($question->topic) !!}</span>
                        </td>
                        <td>
                            @foreach ($question->answer as $answer)
                                <span class="shorten-content">{!! HTML::nl2br(str_limit($question->options[$answer-1]->content, 15, ' ...')) !!}</span>
                                <span class="hidden">{!! HTML::nl2br($question->options[$answer-1]->content) !!}</span>
                                <br>
                            @endforeach
                        </td>
                        <td>
                            <span class="shorten-content">{!! HTML::nl2br(str_limit($question->explanation, 15, ' ...')) !!}</span>
                            <span class="hidden">{!! HTML::nl2br($question->explanation) !!}</span>
                        </td>
                        <td>{!! HTML::true_or_false(($question->correct or false)) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(function()
        {
            $('table .shorten-content').click(function()
            {
                if ($(this).text().match(" \.\.\.$"))
                {
                    $(this).next('.hidden').removeClass('hidden');

                    $(this).remove();
                }
            });
        });
    </script>
@endsection