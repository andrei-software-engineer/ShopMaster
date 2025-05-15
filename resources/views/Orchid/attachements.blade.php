<div>
    @if($obj)
        @if ($obj->systemfileobj)
            <a href="{{$obj->systemfileobj->getUrl()}}" class="js_alhl" target="">
                {{ $obj->name_show }}
            </a>
        @endif
    @endif
</div>