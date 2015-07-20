@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('test-scores.testList') . '：' . $ssn])

    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr class="info">
                    <th>{{ trans('user.id') }}</th>
                    <th>{{ trans('user.name') }}</th>
                    <th>{{ trans('test-scores.scores') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applies as $apply)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.student-information.edit', $apply->account->username, ['user' => $apply->account->username]) !!}</td>
                        <td>{{ $apply->account->userData->name }}</td>
                        @if (null !== $apply->test_result)
                            <td data-score-changeable>
                        @else
                            <td>
                        @endif
                            <div data-score-show>
                                {{ (null === $apply->test_result) ? trans('test-scores.absent') : ((null === $apply->test_result->score) ? trans('test-scores.scoreNotArrive') : $apply->test_result->score) }}
                            </div>

                            @if (null !== $apply->test_result)
                                <div class="hidden" data-score-form>
                                    {!! Form::open(['route' => ['admin.test-scores.update', 'test_scores' => $apply->ssn], 'method' => 'PATCH', 'data-no-pjax']) !!}
                                    <fieldset>
                                        <div class="form-group">
                                            {!! Form::input('number', 'score', $apply->test_result->score, ['class' => 'form-control', 'style' => 'width: 128px;', 'placeholder' => trans('test-scores.scores'), 'max' => 255]) !!}
                                        </div>
                                    </fieldset>
                                    {!! Form::close() !!}
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        (function($)
        {
            $(function()
            {
                $(document).on('dblclick', 'td[data-score-changeable]', function()
                {
                    $(this).find('div[data-score-show]').hide();

                    $(this).find('div[data-score-form]').removeClass('hidden').show();
                });

                $('form').submit(function(e)
                {
                    e.preventDefault();

                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

                    var form = $(this);

                    $.post(
                            this.action,
                            {
                                _method: 'PATCH',
                                score: $(this).find('input[name="score"]').val()
                            },
                            function(data)
                            {
                                if (true === data.success)
                                {
                                    form.closest('div[data-score-form]').hide();

                                    form.closest('td[data-score-changeable]')
                                            .find('div[data-score-show]')
                                            .show().html((null === data.score) ? '-' : data.score);
                                }
                                else
                                {
                                    alert('Update Failed.');
                                }
                            }
                    );
                });
            });
        })(jQuery);
    </script>
@endsection