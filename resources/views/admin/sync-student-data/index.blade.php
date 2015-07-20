@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('sync-student-data.title')])

    <div>
        {!! Form::open(['route' => 'admin.sync-student-data.execute', 'method' => 'POST']) !!}
            <div class="radio">
                <label>
                    {!! Form::radio('sync_type', 'local_to_center_all_override', null, ['required' => 'required']) !!}
                    {{ trans('sync-student-data.local_to_center_all_override') }}
                </label>
            </div>

            <hr>

            <div class="radio">
                <label>
                    {!! Form::radio('sync_type', 'local_to_center_specific', null, ['required' => 'required']) !!}
                    {{ trans('sync-student-data.local_to_center_specific') }}
                </label>
            </div>

            <div class="form-group">
                {!!
                    Form::text('local_to_center_specific_username', null, [
                        'id' => 'local_to_center_specific_username',
                        'class' => 'form-control',
                        'placeholder' => trans('sync-student-data.local_to_center_specific_username'),
                        'disabled' => 'disabled'
                    ])
                !!}
            </div>

            <hr>
            <!--
                <div class="radio">
                    <label>
                        {!! Form::radio('sync_type', 'center_to_local_all', null, ['required' => 'required']) !!}
                        {{-- trans('sync-student-data.center_to_local_all') --}}
                    </label>
                </div>

                <hr>
                -->
            <div class="radio">
                <label>
                    {!! Form::radio('sync_type', 'center_to_local_all_override', null, ['required' => 'required']) !!}
                    {{ trans('sync-student-data.center_to_local_all_override') }}
                </label>
            </div>

            <hr>

            <div class="radio">
                <label>
                    {!! Form::radio('sync_type', 'center_to_local_specific', null, ['required' => 'required']) !!}
                    {{ trans('sync-student-data.center_to_local_specific') }}
                </label>
            </div>

            <div class="form-group">
                {!!
                    Form::text('center_to_local_specific_username', null, [
                        'id' => 'center_to_local_specific_username',
                        'class' => 'form-control',
                        'placeholder' => trans('sync-student-data.center_to_local_specific_username'),
                        'disabled' => 'disabled'
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
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('input[type="radio"]').change(function()
            {
                $('input[type="text"]').attr('disabled','disabled');

                if($(this).val().indexOf('specific') >= 0)
                {
                    $('#'+($(this).val())+'_username').removeAttr('disabled');
                }
            });

            load_or_reset_recaptcha();
        });
    </script>
@endsection