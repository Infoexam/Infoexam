@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    <div>
        <iframe src="{{ route('admin.website-logs.basic') }}" style="overflow:hidden;height:768px;width:100%" height="100%" width="100%"></iframe>
    </div>
@endsection