@extends(env('IS_PJAX') ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => 'A Certain Scientific Railgun'])

    <div>
        <ul>
            <li>1</li>
            <li>2</li>
        </ul>
    </div>
@stop