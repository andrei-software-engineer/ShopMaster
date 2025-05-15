<? /* ADV_TYPE_VIDEO */ ?>
@if ($obj)
    @if ($obj->systemvideoobj)
        <p><?= $obj->systemvideoobj->getHtmlScript(600, 300) ?></p>
    @endif
@endif
