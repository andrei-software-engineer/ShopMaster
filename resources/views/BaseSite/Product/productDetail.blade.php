@if ($obj)
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="content">
                    <h2>{{ $obj->_name }}</h2>

                    @foreach ($obj->_activeGallery as $v)
                        <? if(!$v->systemfileobj) {continue;} ?>
                        <img src="<?= $v->systemfileobj->getUrl(500, 500) ?>" title="{{ $v->name_show }}"
                            alt="{{ $v->systemfileobj->name }}">
                    @endforeach
                </div>
                <div class="content"><?= $obj->_description ?></div>
                @foreach ($obj->_activeVideos as $v)
                    <div class="content">
                        <? if(!$v->systemvideoobj) {continue;} ?>
                        <?= $v->systemvideoobj->getHtmlScript() ?>
                    </div>
                @endforeach
                @foreach ($obj->_activeAttachements as $v)
                    <div class="content">
                        <? if(!$v->systemfileobj) {continue;} ?>
                        <a href="{{ $v->url }}" class="js_alhl"
                            title="{{ $v->name_show }}">{{ $v->name_show }}</a>
                    </div>
                @endforeach
            </div>
            <div class="col-sm-3">
                <div class="content addcart-pr">
                    <div class="name">{{ _GL('Adauga in Cos') }}</div>
                    <div class="price"><b id="productPriceDetail_{{ $obj->id }}"></b><span><?= _GL('MDL') ?></span></div>
                    
                    <form method="POST" action="{{ route('web.addCart') }}" class="js_af" data-targetid="messageresult" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="idproduct" value={{ $obj->id }} />
                        <div class="quantity">

                            <button type="button" class="js_minus_btn"
                                data-idquantity="quantityProductDetail_{{ $obj->id }}">-</button>
                            
                            <input type="text" class="js_product_quantity" name="quantity"
                            id="quantityProductDetail_{{ $obj->id }}" data-idproduct="{{ $obj->id }}" />

                            <button type="button" class="js_plus_btn"
                                data-idquantity="quantityProductDetail_{{ $obj->id }}">+</button>

                        </div>
                    <button type="submit" class="add-btn">{{ _GL('Adauga produsul') }}</button>
                </form>

                <table class="hidden" id="offerList_{{ $obj->id }}">
                    <tr data-min="0" data-max="10">
                        <td data-price="<?= $obj->processPrice() ?>" data-tax="<?= $obj->processPrice() ?>"
                            data-discount="<?= $obj->processPrice() ?>" data-realprice="<?= $obj->processPrice() ?>">
                        </td>
                    </tr>
                    <tr data-min="11" data-max="-1">
                        <td data-price="<?= $obj->processPrice() ?>" data-tax="<?= $obj->processPrice() ?>"
                            data-discount="<?= $obj->processPrice() ?>" data-realprice="<?= $obj->processPrice() ?>">
                        </td>
                    </tr>
                </table>
                <hr>
                <a rel="nofollow,noindex" id="idfavbtlist_{{ $obj->id }}"
                    href="{{ route('web.addFavorite', ['idproduct' => $obj->id]) }}"
                    class="js_al <?= $obj->isInFavorite ? 'fav-active' : 'fav-inactive' ?>"
                    data-targetid="messageresult"><i></i></a>
            </div>
        </div>

    </div>
    </div>

    <?= $_ProductVisitedList ?>
@endif
