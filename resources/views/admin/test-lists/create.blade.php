@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('test-lists.create')])

    <div>
        {!! Form::open(['route' => 'admin.test-lists.store', 'method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('start_time', trans('test-lists.start_time')) !!}
                {!! Form::input('datetime-local', 'start_time', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('test_time', trans('test-lists.test_time')) !!}
                {!! Form::input('number', 'test_time', null, ['class' => 'form-control', 'required' => 'required', 'min' => 1, 'max' => '360']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('room', trans('test-lists.room')) !!}
                {!! Form::select('room', $open_room, null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('apply_type', trans('test-lists.apply_type')) !!}
                {!! Form::select('apply_type', $apply_type, null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('std_num_limit', trans('test-lists.std_num_limit')) !!}
                {!! Form::input('number', 'std_num_limit', null, ['class' => 'form-control', 'required' => 'required', 'min' => 1, 'max' => '255']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('test_type', trans('test-lists.test_type')) !!}
                {!! Form::select('test_type', $test_type, null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group" id="test_paper">
                {!! Form::label('test_paper', trans('test-lists.test_paper').'：') !!}
                <label class="radio-inline">
                    {!! Form::radio('test_paper_type', 1) !!}
                    {{ trans('test-lists.test_paper_type.auto') }}
                </label>
                <label class="radio-inline">
                    {!! Form::radio('test_paper_type', 0) !!}
                    {{ trans('test-lists.test_paper_type.specific') }}
                </label>
                <div id="test_paper_type">
                    <div id="test_paper_type_auto">
                        <div class="form-group">
                            {!! Form::label('test_paper_auto_number', trans('test-lists.test_paper_auto_number')) !!}
                            {!! Form::input('number', 'test_paper_auto_number', null, ['class' => 'form-control', 'min' => 1, 'max' => '100']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('test_paper_auto_level', trans('exam-questions.level')) !!}
                            {!!
                                Form::select('test_paper_auto_level', [
                                    '0' => trans('test-lists.random_level'),
                                    '1' => trans('exam-questions.levels.1'),
                                    '2' => trans('exam-questions.levels.2'),
                                    '3' => trans('exam-questions.levels.3')
                                ], 2, ['class' => 'form-control'])
                            !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('test_paper_auto', trans('test-lists.test_paper_auto')) !!}
                            @foreach ($exam_sets as $exam_set)
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('test_paper_auto[]', $exam_set->ssn) !!}
                                        {{ $exam_set->name.' ('.(('A' === $exam_set->category) ? trans('exam-sets.application') : trans('exam-sets.software')).')' }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="test_paper_type_specific">
                        {!! Form::label('test_paper_specific', trans('test-lists.test_paper_auto')) !!}
                        {!! Form::select('test_paper_specific', $paper_lists, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::submit(trans('general.create'), ['class' => 'btn btn-primary form-control']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <script>
        $(function()
        {
            $('#test_paper_type_auto').hide();
            $('#test_paper_type_specific').hide();

            $('#test_type').change(function()
            {
                var test_type = $(this).val().split('_');

                (test_type[1] == 1) ? ($('#test_paper').show()) : ($('#test_paper').hide());
            });

            $('input:radio[name="test_paper_type"]').click(function()
            {
                if ($(this).val() == 1)
                {
                    $('#test_paper_type_auto').show();
                    $('#test_paper_type_specific').hide();
                }
                else
                {
                    $('#test_paper_type_auto').hide();
                    $('#test_paper_type_specific').show();
                }
            });
        });
    </script>
@endsection