<? /* ADV_TYPE_CTA */ ?>

@if ($obj)
        @if($obj->systemfileobj)
            <div class="img" style="background-image:url(<?= $obj->systemfileobj->getUrl(1920, 500) ?>)"></div>
        @endif

        @if($obj->urltogo)
            <a href="<?= $obj->urltogo?>" class="js_alhl" target="{{$obj->targettype}}" >
        @endif
            <h1>{{$obj->name_show}}</h1>
        @if($obj->urltogo)
            </a>
        @endif
@endif
