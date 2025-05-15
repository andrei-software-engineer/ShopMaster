<div>
    @if($obj)
        
        @if ($obj->systemfileobj)
        <a href="{{$obj->systemfileobj->getUrl()}}" class="js_alhl" target="">
            <img src='{{$obj->systemfileobj->getUrl(200)}}'  alt="{{ $obj->name_show }}" class='rounded-1'>
        </a>
        @endif
        @if ($obj->systemfileobjMobile)
        <a href="{{$obj->systemfileobjMobile->getUrl()}}" class="js_alhl" target="">
            <img src='{{$obj->systemfileobjMobile->getUrl(200)}}'  alt="{{ $obj->name_show }}" class='rounded-1'>
        </a>
        @endif
    @endif
</div>