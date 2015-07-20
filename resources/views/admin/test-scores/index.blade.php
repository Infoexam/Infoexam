@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('test-scores.title')])

    <div>
        <h3>{{ trans('test-scores.uploadScores') }}</h3><br>

        {!! Form::open(['route' => ['admin.test-scores.store'], 'method' => 'POST', 'files' => true, 'class' => 'form-inline']) !!}
        <fieldset>
            <div class="form-group">
                {!! Form::label('ssn', trans('test-scores.testList') . '：') !!}
                {!! Form::select('ssn', $lists, null, ['class' => 'form-control', 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::file('scores', ['required']) !!}
            </div>

            <div class="form-group">
                <label>
                    {!! Form::checkbox('overwrite', true) !!}
                    {{ trans('test-scores.overwrite') }}
                </label>
            </div>

            {!! Form::submit(trans('test-scores.upload'), ['class' => 'btn btn-success form-control']) !!}
        </fieldset>
        {!! Form::close() !!}

        @include('errors.form')
    </div>

    <hr>

    <div>
        <h3>{{ trans('test-scores.show') }}</h3><br>

        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr class="info">
                    <th>{{ trans('test-lists.ssn') }}</th>
                    <th>{{ trans('test-lists.test_type') }}</th>
                    <th>{{ trans('test-lists.apply_type') }}</th>
                    <th>{{ trans('test-lists.std_real_test_num') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tests as $test)
                    <tr>
                        <td>{{ $test->ssn }}</td>
                        <td>{{ trans('test-lists.test_types.'.($test->test_type)) }}</td>
                        <td>{{ trans('test-lists.apply_types.'.($test->apply_type)) }}</td>
                        <td>{{ $test->std_real_test_num . ' / ' .$test->std_apply_num }}</td>
                        <td>{!! HTML::linkRoute('admin.test-scores.show', trans('test-scores.show'), ['test_scores' => $test->ssn]) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection