@extends(env('IS_PJAX') ? 'student.layouts.pjax' : 'student.layouts.master')


@section('main')
    <div>
        <div>
            <span>{{ trans('user.name') }}：{{ $info->user_data->name }}</span>
        </div>
        <div>
            <span>{{ trans('user.id') }}：{{ $info->username }}</span>
        </div>
        <div>
            <span>{{ trans('user.department') }}：{{ $info->user_data->department->name }}</span>
        </div>
        <div>
            <span>{{ trans('user.grade') }}：{{ $info->user_data->grade }}</span>
        </div>
        <div>
            <span>{{ trans('user.email') }}：{{ $info->user_data->email }}</span>

            <button type="button" data-target="update-email" class="btn btn-primary btn-xs">{{ trans('general.update') }}</button>

            <div id="update-email">
                {!! Form::open(['route' => 'student.member.info.update', 'method' => 'PATCH']) !!}
                    <div class="form-group">
                        {!!
                            Form::email('email', null, [
                                'class' => 'form-control',
                                'placeholder' => trans('general.email'),
                                'required' => 'true',
                            ])
                        !!}
                    </div>

                    <div class="form-group">
                        {!! HTML::recaptcha() !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit(trans('general.update'), ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                {!! Form::close() !!}

                @include('errors.form')
            </div>
        </div>
    </div>
    <hr>
    <div>
        <div>
            <span>{{ trans('user.acad_score') }}：{{ (is_null($info->accredited_data->acad_score)) ? trans('user.no_data') : $info->accredited_data->acad_score }}</span>
        </div>
        <div>
            <span>{{ trans('user.tech_score') }}：{{ (is_null($info->accredited_data->tech_score)) ? trans('user.no_data') : $info->accredited_data->tech_score }}</span>
        </div>
        <div>
            <span>{{ trans('user.is_passed') }}：{{ ($info->accredited_data->is_passed) ? trans('user.passed') : trans('user.not_passed') }}</span>
        </div>
        <div>
            <span>{{ trans('user.passed_score') }}：{{ (is_null($info->accredited_data->passed_score)) ? trans('user.not_passed') : $info->accredited_data->passed_score }}</span>
        </div>
        <div>
            <span>{{ trans('user.passed_time') }}：{{ (is_null($info->accredited_data->passed_time)) ? trans('user.not_passed') : $info->accredited_data->passed_time }}</span>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function()
        {
            $('#update-email').hide();

            $('button').click(function(e)
            {
                if ($(this).data('target') === 'update-email')
                {
                    $('#update-email').show(300);
                    $(this).hide();
                }
            });

            load_or_reset_recaptcha();
        });
    </script>
@stop