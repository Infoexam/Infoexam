@extends($pjax ? 'exam.layouts.pjax' : 'exam.layouts.master')

@section('main')
    <div>
        {!! Form::open(['route' => 'student.practice-exam.result', 'method' => 'POST', 'data-no-pjax']) !!}
            <div>
                @foreach ($questions as $queustion)
                    <div>
                        <h3>{!! HTML::nl2br($queustion->topic) !!}</h3>
                        @include('partials.image', ['image_ssn' => $queustion->image_ssn])
                    </div>
                    @if ($queustion->multiple)
                        <div>
                    @else
                        <div data-single>
                    @endif
                        @foreach ($queustion->options as $option)
                            <div class="radio checkbox">
                                <label>
                                    @if ($queustion->multiple)
                                        {!! Form::checkbox($queustion->ssn . '[]', $option->ssn) !!}
                                    @else
                                        {!! Form::radio($queustion->ssn, $option->ssn, null) !!}
                                    @endif
                                    <span>{!! HTML::nl2br($option->content) !!}</span>
                                </label>
                                @if (null !== $option->image_ssn)
                                    @foreach ($option->image_ssn as $image_ssn)
                                        @include('partials.image', ['image_ssn' => $image_ssn])
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr>
                @endforeach
            </div>

            <div class="form-group">
                {!! Form::submit('送出', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="warning-modal" tabindex="-1" role="dialog" aria-labelledby="warning-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="warning-modal-label">{{ trans('exam.warning.questionsNotChoose') }}</h4>
                </div>
                <div class="modal-body">
                    <span>{{ trans('exam.warning.stillSubmit') }}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="sub">{{ trans('general.yes') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.no') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function()
        {
            var c = $('input[type="radio"]').size() / 4;
            
            $(window).bind('beforeunload', function()
            {
                $('form').submit();
            });
            
            $(window).on('blur' , function()
            {
                $('form').submit();
            });
            
            $(document).keydown(function(e)
            {
                if (e.ctrlKey || e.altKey || e.shiftKey || e.which === 8)
                {
                    e.preventDefault();
                }
            });
            
            $('.form-group').click(function(e)
            {
                var count = 0;

                $('input[type="radio"]').each(function ()
                {
                    if($(this).prop('checked'))
                    {
                        count++;
                    }
                });
            
                if (count >= 4)
                {
                    $('form').submit();
                }
                else
                {
                    e.preventDefault();

                    $('#warning-modal').modal('show');
                    
                    $('#sub').click(function ()
                    {
                        $('form').submit();
                    });
                }
            });
        });
    </script>
@endsection