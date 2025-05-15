@if($obj)
    <div class="js_alhl mark-template" data-href="{{$obj->url}}" >
      <img src="<?=$obj->_defaultGalleryGetUrl(100)?>" title="{{$obj->_name}}" alt="{{$obj->_name}}">
      <div class="mark-title">{{$obj->_name}}</div>
    </div>
@endif
