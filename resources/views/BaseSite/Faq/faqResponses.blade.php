@if($obj)
    <HR>
        <div>
            {{$obj->_name}}
            @if(count($objects))
                @foreach($objects as $c)
                    @include('BaseSite.Faq.faqResponseItem',['obj' => $c])
                @endforeach
            @endif
        </div>
    <HR>
@endif