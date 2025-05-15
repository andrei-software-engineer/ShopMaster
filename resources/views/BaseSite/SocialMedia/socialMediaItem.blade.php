@if($obj)
    <a href="<?= $obj->socialUrl?>" class="js_alhl" target="">
        @if($obj->systemfileobj)
            <img src="<?= $obj->systemfileobj->getUrl() ?>" width="20px" height="20px" title="{{$obj->name_show}}" alt="{{$obj->systemfileobj->name}}">
        @endif
    </a>
@endif