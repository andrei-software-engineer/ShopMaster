<div class="content">
    <h3>{{_GL('Intrebari frecvente')}}</h3><br>
    @if(count($faqs))
        @foreach($faqs as $v)
            @include('BaseSite.Faq.faqContentItem', ['obj' => $v])
        @endforeach
    @endif
</div>