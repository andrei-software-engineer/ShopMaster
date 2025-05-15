@if($obj)
    @if($obj->product)
        <br>
        {{_GL('Name')}} : {{$obj->product->_name}} <br>
        {{_GL('Link')}} : <a href="{{$obj->product->url}}"  class="js_alhl">{{$obj->product->_name}}</a> <br>
        {{_GL('Price')}} : {{$obj->product->price}} <br>

        @foreach($obj->product->_activeGallery as $v)
            <? if(!$v->systemfileobj) {continue;} ?>
            <img src="<?=$v->systemfileobj->getUrl(500, 500)?>" title="{{$v->name_show}}" alt="{{$v->systemfileobj->name}}">
        @endforeach


        <form method="POST" action="{{ route('web.addCart') }}" class="js_af" data-targetid="messageresult" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="idproduct" value={{$obj->product->id}} />
            <input type="hidden" name="quantity" value= 1 />

            <input type="submit" value="Add">
        </form>

        <a rel="nofollow,noindex" id="idfavbtlist_{{$obj->product->id}}" href="{{route('web.addFavorite', ['idproduct' => $obj->product->id])}}" class="js_al <?=($obj->product->isInFavorite) ? 'fav-active' : 'fav-inactive' ?>" data-targetid="messageresult">Favorite</a>
    @endif
@endif
<br>