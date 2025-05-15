
<div>
    @if($obj)
        @if ($obj->systemvideoobj)
            <?=$obj->systemvideoobj->getHtmlScript()?>
        @endif
    @endif
</div>