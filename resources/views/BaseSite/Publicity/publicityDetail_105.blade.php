<? /* ADV_TYPE_IMAGE */ ?>

@if ($obj)

        @if ($obj->systemfileobj)
            @if ($obj->urltogo)
                <a href="<?= $obj->urltogo ?>" class="js_alhl" target="{{ $obj->targettype }}">
            @endif
                <div class="img" style="background-image:url(<?= $obj->systemfileobj->getUrl(1920, 500) ?>)"></div>
            @if ($obj->urltogo)
                </a>
            @endif
        @endif

@endif
