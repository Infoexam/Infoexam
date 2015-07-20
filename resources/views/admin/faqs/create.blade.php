@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('faqs.create')])

    <div>
        {!! Form::open(['route' => 'admin.faqs.store', 'method' => 'POST']) !!}
            @include('admin.faqs._form', ['submitButtonText' => trans('general.create')])
        {!! Form::close() !!}
    </div>
@endsection