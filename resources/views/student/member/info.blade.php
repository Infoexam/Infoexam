@extends($pjax ? 'student.layouts.pjax' : 'student.layouts.master')

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
                    <td>{{ $guard->user()->userData->name }}</td>
                    <td>{{ $guard->user()->username }}</td>
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
                    <td>{{ $guard->user()->userData->department->name }}</td>
                    <td>{{ $guard->user()->userData->grade }}</td>
                    <td>
                        <span>{{ $guard->user()->userData->email }}</span>

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
                    <td>{{ ($guard->user()->accreditedData->is_passed) ? trans('user.passed') : trans('user.not_passed') }}</td>
                    <td>{{ (null === ($guard->user()->accreditedData->passed_score)) ? trans('user.not_passed') : $guard->user()->accreditedData->passed_score }}</td>
                    <td>{{ (null === ($guard->user()->accreditedData->passed_time)) ? trans('user.not_passed') : $guard->user()->accreditedData->passed_time }}</td>
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
                    <td>{{ (null === ($guard->user()->accreditedData->acad_score)) ? trans('user.no_data') : $guard->user()->accreditedData->acad_score }}</td>
                    <td>{{ (null === ($guard->user()->accreditedData->tech_score)) ? trans('user.no_data') : $guard->user()->accreditedData->tech_score }}</td>
                </tr>
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
                $('#update-email').hide();

                $('button').click(function()
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
@endsection