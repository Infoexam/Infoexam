@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('exam-questions.show')])

    <div>
        {!! HTML::link_button(route('admin.exam-sets.show', ['exam-sets' => $exam_set->ssn]), trans('exam-questions.list')) !!}
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <tbody>
                <tr>
                    <th class="text-center">{{ trans('exam-questions.topic') }}</th>
                    <td>
                        {!! HTML::nl2br($question->topic) !!}
                        @include('partials.image', ['image_ssn' => $question->image_ssn])
                    </td>
                </tr>
                <?php $i = 1; ?>
                @foreach($options as $option)
                    <tr>
                        <th class="text-center">{{ trans('exam-questions.options.'.($i++)) }}</th>
                        <td>
                            {!! HTML::nl2br($option->content) !!}
                            @if(null !== $option->image_ssn)
                                @foreach($option->image_ssn as $image_ssn)
                                    @include('partials.image', ['image_ssn' => $image_ssn, 'use_text' => true])
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th class="text-center">{{ trans('exam-questions.level') }}</th>
                    <td>{{ HTML::show_question_level($question->level) }}</td>
                </tr>
                <tr>
                    <th class="text-center">{{ trans('exam-questions.multiple') }}</th>
                    <td>{!! HTML::true_or_false($question->multiple) !!}</td>
                </tr>
                <tr>
                    <th class="text-center">{{ trans('exam-questions.answer') }}</th>
                    <td>{{ $question->answer }}</td>
                </tr>
                <tr>
                    <th class="text-center">{{ trans('exam-questions.explanation') }}</th>
                    <td>{!! HTML::nl2br($question->explanation) !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
@stop