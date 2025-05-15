<div class="bennefits-template">
    @if($obj)
        <div>
            @foreach($obj->_activeGallery as $v)
                <? if(!$v->systemfileobj) {continue;} ?>
                <a href="<?= $v->systemfileobj->getUrl(500, 500)?>" target="" class="js_alhl">
                    <img src="<?=$v->systemfileobj->getUrl(500, 500)?>" height="40px" title="{{$v->name_show}}" alt="{{$v->systemfileobj->name}}">
                </a>
            @endforeach
        </div>
        <div><a href="<?= $obj->url?>" target="" class="js_alhl">{{$obj->_name}}</a></div>
    @endif
</div>