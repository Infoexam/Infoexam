@extends(env('IS_PJAX') ? 'exam.layouts.pjax' : 'exam.layouts.master')

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
                        @foreach($queustion->options as $option)
                            <div class="radio checkbox">
                                <label>
                                    @if($queustion->multiple)
                                        {!! Form::checkbox($queustion->ssn . '[]', $option->ssn, null) !!}
                                    @else
                                        {!! Form::radio($queustion->ssn, $option->ssn, null, ['required']) !!}
                                    @endif
                                    <span>{!! HTML::nl2br($option->content) !!}</span>
                                </label>
                                @if(null !== $option->image_ssn)
                                    @foreach($option->image_ssn as $image_ssn)
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
@stop

@section('scripts')
    <script>
        $(function()
        {
            //
        });
    </script>
@stop