
@if ($obj)
    <div  id="faq_item_button_{{$obj->id}}" class="js_accordion " data-prefixbtid="faq_item_button_" data-containerid="faq_item_container_{{$obj->id}}">{{ $obj->_name }}</div>
    @if (count($obj->_childrens))
        <div class="" id="faq_item_container_{{$obj->id}}" >
            @foreach ($obj->_childrens as $v)
                <div> {{ $v->_name }}</div>
            @endforeach
        </div>
    @endif
@endif