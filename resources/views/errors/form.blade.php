@if ($errors->any())
    <ul class="alert alert-danger ul-li-margin-left">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif