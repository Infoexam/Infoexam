@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('paper-questions.create')])

    <div class="questions-selected-pad">
        <span>已選題目數：</span>
        <span id="questions_selected">0</span>
    </div>
    <div>
        {!! Form::open(['route' => 'admin.paper-questions.store', 'method' => 'POST']) !!}
            @foreach ($exam_sets as $exam_set)
                <div class="exam-sets">
                    <div class="questions-title">
                        <span class="glyphicon glyphicon-plus xbtn" aria-hidden="true"></span>
                        <span class="xbtn">{{ $exam_set->name }}</span>
                    </div>
                    <div class="questions-group">
                        @foreach ($exam_set->questions as $question)
                            <div class="checkbox questions-pad">
                                <label>
                                    {!! Form::checkbox('questions[]', $question->ssn) !!}
                                    {!! HTML::nl2br($question->topic) !!}
                                    @include('partials.image', ['image_ssn' => $question->image_ssn, 'use_text' => true])
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                </div>
            @endforeach

            <div class="form-group">
                {!! Form::hidden('paper_ssn', Request::input('ssn')) !!}
            </div>

            <div class="form-group">
                {!! Form::submit(trans('general.create'), ['class' => 'btn btn-primary form-control']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@stop

@section('scripts')
    <script>
        (function($)
        {
            $(function()
            {
                $('span.glyphicon.glyphicon-plus').parent('div').next('div').hide();
                $('span.glyphicon.glyphicon-plus, span.glyphicon.glyphicon-minus').parent('div').click(function()
                {
                    $(this).next('div').stop(true, false).toggle(250);
                    $(this).children('.glyphicon').toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');
                });

                $('input[type="checkbox"]').change(function()
                {
                    var s = '#questions_selected';
                    var v = parseInt($(s).text());
                    $(this).prop('checked') ? ($(s).text(v+1)) : ($(s).text(v-1));
                });
            });
        })(jQuery);
    </script>
@stop