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
                    <div>
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
@endsection

@section('scripts')
    <script>
        $(function()
        {
            var click_times = 0;

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
                e.preventDefault();

                $('#delete-confirm').modal('show');
                
                /*var count = 0;
                $('input[type="radio"]').each(function () {
                    if( $(this).prop('checked'))
                    {
                        count++;
                    }
                })
                if(count >= 3) {
                    $('form').submit();
                } else if( click_times >= 1) {
                    $('form').submit();
                } else {
                    $('.form-group').append('似乎還有題目尚未作答，若要送出請再按一次送出鍵');
                    click_times++;
                    e.preventDefault();
                }*/
                
                
                /*$('#delete-confirm').on('shown.bs.modal', function () {
                  $('#delete-confirm').focus()
                })*/
            });
        });
    </script>
@endsection