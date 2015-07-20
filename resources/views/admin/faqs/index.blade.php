@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('faqs.list')])

    <div>
        {!! HTML::link_button(route('admin.faqs.create'), trans('faqs.create')) !!}
    </div>
    <br>
    <div>
        @foreach ($faqs as $faq)
            <div>
                <ul class="list-inline">
                    <li>
                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                    </li>
                    <li>
                        <span class="question">{{ $faq->question }}</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.faqs.edit', ['faqs' => $faq->id]) }}">
                            <button type="button" class="btn btn-success btn-xs">{{ trans('general.update') }}</button>
                        </a>
                    </li>
                    <li>
                        {!! Form::open(['route' => ['admin.faqs.destroy.images', $faq->id], 'method' => 'DELETE']) !!}
                            {!! Form::button(trans('faqs.delete.image'), [
                                    'type' => 'submit',
                                    'class' => 'btn btn-warning btn-xs',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#delete-confirm'
                                ])
                            !!}
                        {!! Form::close() !!}
                    </li>
                    <li>
                        {!! Form::open(['route' => ['admin.faqs.destroy', $faq->id], 'method' => 'DELETE']) !!}
                            {!! Form::button(trans('general.delete'), [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#delete-confirm'
                                ])
                            !!}
                        {!! Form::close() !!}
                    </li>
                </ul>
            </div>
            <div class="answer">
                {!! $faq->answer !!}
                @if (isset($faq->image_ssn))
                    @include('partials.image', ['image_ssn' => $faq->image_ssn])
                @endif
            </div>
        @endforeach
    </div>
    <div class="text-center">
        {!! $faqs->render() !!}
    </div>
@endsection

@section('scripts')
    <script>
        (function($)
        {
            $(function()
            {
                $('.answer').hide();

                $('.glyphicon-question-sign, .question').click(function()
                {
                    $(this).closest('div').next('div').stop(true, false).toggle(250);
                });
            });
        })(jQuery);
    </script>
@endsection