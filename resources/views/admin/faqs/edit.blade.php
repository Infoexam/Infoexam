@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('faqs.edit')])

    <div>
        {!! Form::model($faq, ['route' => ['admin.faqs.update', $faq->id], 'method' => 'PATCH']) !!}
            @include('admin.faqs._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@endsection