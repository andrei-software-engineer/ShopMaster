<div class="product-template" >
    @if($item['product'])
        <a href="{{$item['product']->url}}" class="js_alhl">
            <img src="<?=$item['product']->_defaultGalleryGetUrl(200)?>" title="{{$item['product']->_name}}" alt="{{$item['product']->_name}}">
        </a>
        <a href="{{$item['product']->url}}" class="js_alhl name">{{$item['product']->id}} - {{$item['product']->_name}}</a>

        <div class="price"><span id="productPriceDetail_{{$item['product']->id}}"></span><?=_GL('MDL')?></div>

        <table class="hidden" id="offerList_{{ $item['product']->id }}">
            @if($item['product']->offersObj)
                @foreach($item['product']->offersObj as $offer) 
                    <tr data-min="{{$offer->minq}}" data-max="{{$offer->maxq}}">
                        <td data-price="{{$offer->real_price}}" data-tax="{{$offer->real_price}}" data-discount="{{$offer->real_price}}" data-realprice="{{$offer->real_price}}"></td>
                    </tr>
                @endforeach
            @else   
                <tr data-min="0" data-max="10">
                    <td data-price="<?=$item['product']->processPrice()?>" data-tax="<?=$item['product']->processPrice()?>" data-discount="<?=$item['product']->processPrice()?>" data-realprice="<?=$item['product']->processPrice()?>"></td>
                </tr>
            @endif
            

        </table>  

        <button type="submit" class="js_plus_btn" data-idquantity="quantityProductDetail_{{ $item['product']->id }}">
            +
        </button>
        <input type="text" class="js_product_quantity" name="quantity"
            id="quantityProductDetail_{{ $item['product']->id }}" data-updatewcart=1
            data-UpdateURL="{{route('web.saveQuantityx', ['idproduct' => $item['product']->id])}}"  
            data-idproduct="{{ $item['product']->id }}" 
            value="{{$item['quantity']}}"/> 

        <button type="submit" class="js_minus_btn" data-idquantity="quantityProductDetail_{{ $item['product']->id }}">
            -
        </button>

        <div class="">
            <form method="POST" action="{{ route('web.deleteCart') }}" class="js_af" data-targetid="messageresult" id="idformbtnlistitem_{{$item['product']->id}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="_backUrl" value="{{ $item['_backUrl'] }}" />
                <input type="hidden" name="idproduct" value={{ $item['product']->id }} />
            
                <input type="submit" value="Sterge">
            </form>
        </div>

    @endif
</div>