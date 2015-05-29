@extends(env('IS_PJAX') ? 'exam.layouts.pjax' : 'exam.layouts.master')

@section('main')
    <div id="timer">
    </div>
    <div>
        {!! Form::open(['route' => 'exam.submit', 'method' => 'POST']) !!}
            <div>
                @foreach ($questions as $queustion)
                    <div>
                        <h3>{!! HTML::nl2br($queustion->topic) !!}</h3>
                        @include('partials.image', ['image_ssn' => $queustion->image_ssn])
                    </div>
                    <div>
                        @foreach ($queustion->options as $option)
                            <div class="radio">
                                <label>
                                    {!! Form::radio($queustion->ssn, $option->ssn, null, ['required']) !!}
                                    <span>{!! HTML::nl2br($option->content) !!}</span>
                                </label>
                                @include('partials.image', ['image_ssn' => $option->image_ssn])
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
        function dosomething() {
            alert('time up');
        }

        function time(day, hour, minute, second)
        {
            $('#timer').text('剩餘時間：' + day + ' 天 ' + hour + ' 小時 ' + minute + ' 分 ' + second + ' 秒');

            if ( ! (second || minute || hour || day))
            {
                dosomething();
            }
            else
            {
                --second;

                if (second === -1)
                {
                    --minute;
                    second = 59;

                    if (minute === -1)
                    {
                        --hour;
                        minute = 59;

                        if (hour === -1)
                        {
                            --day;
                            hour = 23;
                        }
                    }
                }

                setTimeout(function ()
                {
                    time(day , hour , minute , second);
                }, 1000);
            }
        }

        $(function()
        {
            var time_difference = {{ ($diff = $test_data->end_time->timestamp - Carbon\Carbon::now()->timestamp) ? $diff : 0 }};

            time(
                    parseInt(time_difference / 86400),
                    parseInt(time_difference / 3600 % 24),
                    parseInt(time_difference / 60 % 60),
                    parseInt(time_difference % 60)
            );
        });
    </script>
@stop