@if($obj)

    <div class="js_alhl category-template" data-href="{{$obj->url}}" >

    <img src="<?=$obj->_defaultGalleryGetUrl(100)?>" title="{{$obj->_name}}" alt="{{$obj->_name}}">
    <div>{{$obj->_name}}</div>
    </div>
@endif
