<div class="form-group">
    {!! Form::label('topic', trans('exam-questions.topic')) !!}
    {!! Form::textarea('topic', null, ['class' => 'form-control', 'rows' => 5, 'required' => 'true']) !!}
    <br>
    @include('partials.form-image-field', ['name' => 'topic_image', 'options' => ['accept' => 'image/*']])
    <br>
    @if (isset($question) && (null !== $question->image_ssn))
        {!! Form::hidden('topic_image_ssn', $question->image_ssn) !!}
        @include('partials.image', ['image_ssn' => $question->image_ssn])
    @endif
</div>

<hr>

@for ($i = 0; $i < 4; $i++)
    <div class="form-group">
        {!! Form::label('option['.$i.']', trans('exam-questions.options.'.($i+1))) !!}
        {!! Form::textarea('option['.$i.']', ((isset($options) ? $options[$i]->content : null)), ['class' => 'form-control', 'rows' => 5]) !!}
        <br>
        @include('partials.form-image-field', ['name' => 'option_image['.$i.'][]', 'options' => ['accept' => 'image/*', 'multiple' => 'multiple']])
        <br>
        @if (isset($options))
            {!! Form::hidden('option_ssn['.$i.']', $options[$i]->ssn) !!}
            {!! Form::hidden('option_image_ssn['.$i.']', (null === $options[$i]->image_ssn) ? null : implode(',', $options[$i]->image_ssn)) !!}
            @if (null !== $options[$i]->image_ssn)
                @foreach ($options[$i]->image_ssn as $image_ssn)
                    @include('partials.image', ['image_ssn' => $image_ssn, 'use_text' => true])
                @endforeach
            @endif
        @endif
    </div>

    <hr>
@endfor

<div class="form-group">
    {!! Form::label('explanation', trans('exam-questions.explanation')) !!}
    {!! Form::textarea('explanation', null, ['class' => 'form-control', 'rows' => 5]) !!}
</div>

<hr>

<div class="form-group">
    {!! Form::label('level', trans('exam-questions.level')) !!}
    {!!
        Form::select('level', [
            '1' => trans('exam-questions.levels.1'),
            '2' => trans('exam-questions.levels.2'),
            '3' => trans('exam-questions.levels.3')
        ], null, ['class' => 'form-control'])
    !!}
</div>

<div class="form-group">
    <label>
        {{ trans('exam-questions.multiple').'：' }}
        {!! Form::checkbox('multiple', true, null, ['data-checkbox-switch']) !!}
    </label>
</div>

<div class="form-group">
    {!! Form::label('answer', trans('exam-questions.answer')).'：' !!}
    @for ($i = 1; $i <= 4; $i++)
        <label class="checkbox-inline">
            {!! Form::checkbox('answer[]', $i) !!}
            {{ trans('exam-questions.options.'.($i)) }}
        </label>
    @endfor
</div>

<div class="form-group">
    {!! Form::hidden('exam_set_ssn', Request::input('ssn')) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>