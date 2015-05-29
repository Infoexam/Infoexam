@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('paper-lists.name').'：'.$paper->name])

    <div>
        {!! HTML::link_button(route('admin.paper-lists.index'), trans('paper-lists.list')) !!}
        {!! HTML::link_button(route('admin.paper-questions.create', ['ssn' => $paper->ssn]), trans('paper-questions.create')) !!}
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
                    <th>#</th>
                    <th>{{ trans('paper-questions.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                @foreach($questions as $question)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>
                            {!! HTML::nl2br($question->topic) !!}
                            @include('partials.image', ['image_ssn' => $question->image_ssn])
                        </td>
                        <td>{!! HTML::show_question_level($question->level) !!}</td>
                        <td>{!! HTML::true_or_false($question->multiple) !!}</td>
                        <td>{!! HTML::linkRoute('admin.exam-questions.show', trans('exam-questions.show'), [$question->ssn], ['data-no-pjax', 'target' => '_blank']) !!}</td>
                        <td>
                            @include('partials.delete-form', ['route' => ['admin.paper-questions.destroy', $question->pivot['ssn']]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop