@if($obj)
    <li class="page-item"><a href="{{$obj->url}}" class="page-link <?=$obj->jsClass?> <?=($obj->current) ? ' active ' : '' ?>" data-targetid="<?=$obj->targetId?>">{{$obj->name}}</a></li>
@endif
