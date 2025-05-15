<div class="content p-2">
    <div class="row p-0 m-0">
        @if($obj)
            @if($obj['favorite'])
                @foreach($obj['favorite'] as $v)   
                    <div class="col-sm-3 p-1"  id="idfavlistitem_{{$v->productObj->id}}">@include('BaseSite.Favorite.favoriteItem', ['obj' => $v])</div>
                @endforeach
                {{$obj['paginate']}}
            @endif
        @endif
    </div>
</div>