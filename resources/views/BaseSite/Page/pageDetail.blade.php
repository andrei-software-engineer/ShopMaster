<section class="container page">
    @if($obj)
        <h1>{{$obj->_name}}</h1>
        <div class="content">
            
            <?= $obj->_description?>
            <div class="video">
                @foreach($obj->_activeVideos as $v)
                    <? if(!$v->systemvideoobj) {continue;} ?>
                        <?=$v->systemvideoobj->getHtmlScript()?>
                @endforeach
            </div>
            <div class="gallery">
                @foreach($obj->_activeGallery as $v)
                    <? if(!$v->systemfileobj) {continue;} ?>
                    <a href="<?= $v->systemfileobj->getUrl(500, 500)?>" class="js_alhl" target="">
                        <img src="<?=$v->systemfileobj->getUrl(200)?>" width="200px" title="{{$v->name_show}}" alt="{{$v->systemfileobj->name}}">
                    </a>
                @endforeach
            </div>
            <div>
                @foreach($obj->_activeAttachements as $v)
                    <? if(!$v->systemfileobj) {continue;} ?>
                    <a href="{{$v->url}}" class="js_alhl" title="{{$v->name_show}}">{{$v->name_show}}</a>
                @endforeach
            </div>
        </div>
    @endif
</section>