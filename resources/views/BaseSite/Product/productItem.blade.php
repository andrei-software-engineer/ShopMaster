<div class="product-template" id="idproductmainlistitem_{{$obj->id}}">
    <a href="{{$obj->url}}" class="js_alhl">
        <img src="<?=$obj->_defaultGalleryGetUrl(200)?>" title="{{$obj->_name}}" alt="{{$obj->_name}}">
    </a>
    <a href="{{$obj->url}}" class="js_alhl name">{{$obj->id}} - {{$obj->_name}}</a>

    <div class="price">{{$obj->processPrice()}} <span>{{_GL('MDL')}}</span></div>

    <div class="line-btn">
        <form action="{{ route('web.addCart') }}" enctype="multipart/form-data" method="post"  class="js_af" data-targetid="messageresult" id="idformaddbtnlistitem_{{$obj->id}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="idproduct" value={{$obj->id}} />
            <input type="hidden" name="quantity" value= 1 />

            <button type="submit" value="Add" class="btn-add">{{_GL('Add btn')}}</button>
        </form>

        <a rel="nofollow,noindex" id="idfavbtlist_{{$obj->id}}" href="{{route('web.addFavorite', ['idproduct' => $obj->id])}}" class="js_al <?=($obj->isInFavorite) ? 'fav-active' : 'fav-inactive' ?>" data-targetid="messageresult"><i></i></a>
    </div>
</div>