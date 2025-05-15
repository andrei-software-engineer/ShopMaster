
@if (count($objects))
    @foreach($objects as $v)
        <div>
            @include('BaseSite.Faq.faqItem', ['obj' => $v])
        </div>
    @endforeach

@endif
