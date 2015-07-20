@extends($pjax ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('faqs.list')])

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