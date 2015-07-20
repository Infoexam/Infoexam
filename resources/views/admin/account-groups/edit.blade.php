@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('account-groups.edit')])

    <div>
        {!! Form::model($group, ['route' => ['admin.account-groups.update', $group->id], 'method' => 'PATCH']) !!}
            @include('admin.account-groups._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@endsection