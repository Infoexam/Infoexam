@extends($pjax ? 'exam.layouts.pjax' : 'exam.layouts.master')

@section('main')
    <div id="timer">
    </div>
    <div>
        {!! Form::open(['route' => ['exam.submit'], 'method' => 'POST', 'data-no-pjax']) !!}
            <div>
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#page_1" aria-controls="page_1" role="tab" data-toggle="tab">Page 1</a></li>
                        @for ($i = 2, ($count = $questions->count() / $paging + 1); $i < $count; ++$i)
                            <li role="presentation"><a href="#page_{{ $i }}" aria-controls="page_{{ $i }}" role="tab" data-toggle="tab">Page {{ $i }}</a></li>
                        @endfor
                    </ul>
                </div>
                <div class="tab-content">
                    <?php $i = 1; ?>
                    @foreach ($questions->chunk($paging) as $chunk)
                        <div role="tabpanel" class="tab-pane fade {{ 1 === $i ? 'in active' : '' }}" id="page_{{ ceil($i / $paging) }}">
                            @foreach ($chunk as $question)
                                <div>
                                    <h3>{{ $i++ }}. {!! HTML::nl2br($question->topic) !!}</h3>
                                    @if (isset($question->image_ssn))
                                        @include('partials.image', ['image_ssn' => $question->image_ssn])
                                    @endif
                                </div>
                                <div>
                                    @foreach ($question->options as $option)
                                        <div class="radio checkbox">
                                            <label>
                                                @if ($question->multiple)
                                                    {!! Form::checkbox($question->ssn . '[]', $option->ssn) !!}
                                                @else
                                                    {!! Form::radio($question->ssn, $option->ssn) !!}
                                                @endif
                                                <span>{!! HTML::nl2br($option->content) !!}</span>
                                            </label>
                                            @if (isset($option->image_ssn))
                                                @include('partials.image', ['image_ssn' => $option->image_ssn])
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    {!! Form::submit('送出', ['class' => 'btn btn-primary form-control']) !!}
                </div>
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
    <script>var time_difference = {{ max($examTime, 1) }};</script>
    <script>
        function dosomething()
        {
            $('form').submit();
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
            time(parseInt(time_difference / 86400), parseInt(time_difference / 3600 % 24), parseInt(time_difference / 60 % 60), parseInt(time_difference % 60));

            $('[id$=page] a').click(function(e)
            {
                e.preventDefault();
                $(this).tab('show');
            });

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

                if (count >= c)
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