<div class="form-group">
    {!! Form::label('open_room', trans('exam-configs.open_room')).'：' !!}
    @foreach ($room_list as &$room)
        <label class="checkbox-inline">
            {!! Form::checkbox('open_room[]', $room) !!}
            {{ $room }}
        </label>
    @endforeach
</div>

<div class="form-group">
    {!! Form::label('acad_passed_score', trans('exam-configs.acad_passed_score')).'：' !!}
    {!! Form::input('number', 'acad_passed_score', null, ['class' => 'form-control', 'min' => 0, 'max' => '100']) !!}
</div>

<div class="form-group">
    {!! Form::label('tech_passed_score', trans('exam-configs.tech_passed_score')).'：' !!}
    {!! Form::input('number', 'tech_passed_score', null, ['class' => 'form-control', 'min' => 0, 'max' => '100']) !!}
</div>

<div class="form-group">
    {!! Form::label('latest_cancel_apply_day', trans('exam-configs.latest_cancel_apply_day')).'：' !!}
    {!! Form::input('number', 'latest_cancel_apply_day', null, ['class' => 'form-control', 'min' => 0, 'max' => '127']) !!}
</div>

<div class="form-group">
    {!! Form::label('free_apply_grade', trans('exam-configs.free_apply_grade')).'：' !!}
    {!! Form::select('free_apply_grade', ['1' => 1, '2' => 2, '3' => 3, '4' => 4], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! HTML::recaptcha() !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>

@section('scripts')
    <script>
        (function($)
        {
            $(function()
            {
                load_or_reset_recaptcha();
            });
        })(jQuery);
    </script>
@stop