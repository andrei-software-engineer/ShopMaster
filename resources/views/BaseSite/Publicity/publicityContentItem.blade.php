@if($obj)
    @foreach($obj->_activeGallery as $v)
        <? if(!$v->systemfileobj) {continue;} ?>
        <a href="<?= $v->systemfileobj->getUrl(500, 500)?>" class="js_al">
            <img src="<?=$v->systemfileobj->getUrl(500,500)?>"  title="{{$v->name_show}}" alt="{{$v->systemfileobj->name}}">
        </a>
    @endforeach

    @foreach($obj->_activeVideos as $v)
        <? if(!$v->systemvideoobj) {continue;} ?>
        <p><?=$v->systemvideoobj->getHtmlScript()?></p>
    @endforeach
@endif