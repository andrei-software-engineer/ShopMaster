<div class="product-template">
    @if($obj->productObj)

        <img src="<?= $obj->productObj->_defaultGalleryGetUrl(500, 500) ?>">


        {{$obj->productObj->id}} - <a href="{{$obj->productObj->url}}" class="js_alhl name">{{$obj->productObj->_name}}</a>

        <div class="price">{{$obj->productObj->processPrice()}} <span>{{_GL('MDL')}}</span></div>
    @endif

    <div>
        <a rel="nofollow,noindex" id="idfavbtlist_{{$obj->id}}" href="{{route('web.addFavorite', ['idproduct' => $obj->idproduct])}}" class="js_al <?=($obj->productObj->isInFavorite) ? 'fav-active' : 'fav-inactive' ?>" data-targetid="messageresult"><i></i></a>
    </div>

</div>