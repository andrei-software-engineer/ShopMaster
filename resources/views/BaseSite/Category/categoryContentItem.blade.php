@if($obj)
    <th >
    {{$obj->_name}}
    @foreach($obj->_activeGallery as $v)
        <? if(!$v->systemfileobj) {continue;} ?>
        <a href="<?= $obj->url?>" class="js_alhl">
            <img src="<?=$v->systemfileobj->getUrl(1000)?>" width="15%" title="{{$v->name_show}}" alt="{{$v->systemfileobj->name}}">
        </a>
    @endforeach
    </th>
@endif