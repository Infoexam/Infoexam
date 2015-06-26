@extends(env('IS_PJAX') ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    <div>
        <table class="table table-hover table-bordered text-center">
            <thead>
                <tr class="info">
                    <th class="col-xs-6">{{ trans('user.name') }}</th>
                    <th class="col-xs-6">{{ trans('user.id') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $info->userData->name }}</td>
                    <td>{{ $info->username }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-hover table-bordered text-center">
            <thead>
                <tr class="info">
                    <th class="col-xs-3">{{ trans('user.department') }}</th>
                    <th class="col-xs-3">{{ trans('user.grade') }}</th>
                    <th class="col-xs-6">{{ trans('user.email') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $info->userData->department->name }}</td>
                    <td>{{ $info->userData->grade }}</td>
                    <td>
                        <span>{{ $info->userData->email }}</span>

                        <button type="button" data-target="update-email" class="btn btn-success btn-xs">{{ trans('general.update') }}</button>

                        <div id="update-email">
                            <br>

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
                                    {!! Form::submit(trans('general.update'), ['class' => 'btn btn-success form-control']) !!}
                                </div>
                            {!! Form::close() !!}

                            @include('errors.form')
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr>

        <table class="table table-hover table-bordered text-center">
            <thead>
                <tr class="success">
                    <th class="col-xs-4">{{ trans('user.is_passed') }}</th>
                    <th class="col-xs-4">{{ trans('user.passed_score') }}</th>
                    <th class="col-xs-4">{{ trans('user.passed_time') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ ($info->accreditedData->is_passed) ? trans('user.passed') : trans('user.not_passed') }}</td>
                    <td>{{ (null === ($info->accreditedData->passed_score)) ? trans('user.not_passed') : $info->accreditedData->passed_score }}</td>
                    <td>{{ (null === ($info->accreditedData->passed_time)) ? trans('user.not_passed') : $info->accreditedData->passed_time }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-hover table-bordered text-center">
            <thead>
                <tr class="success">
                    <th class="col-xs-6">{{ trans('user.acad_score') }}</th>
                    <th class="col-xs-6">{{ trans('user.tech_score') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ (null === ($info->accreditedData->acad_score)) ? trans('user.no_data') : $info->accreditedData->acad_score }}</td>
                    <td>{{ (null === ($info->accreditedData->tech_score)) ? trans('user.no_data') : $info->accreditedData->tech_score }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@stop

@section('scripts')
    <script>
        (function($)
        {
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
        })(jQuery);
    </script>
@stop