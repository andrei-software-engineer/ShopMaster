<div class="container">
    <div class="home-model-search">
        <form method="POST" action="{{ route('web.execspecialfilter') }}" class="js_af" data-targetid="" >
            <input type="hidden" name="idspecialfilter" value="{{$idspecialfilter}}" />

            <div class="row tab-inputs">
                <div class="col-sm-4"><div id="productpage_specialfilter_marca"><?=$marca?></div></div>
                <div class="col-sm-4"><div id="productpage_specialfilter_model"></div></div>
                <div class="col-sm-4"><div id="productpage_specialfilter_modification"></div></div>
                <div class="col-sm-4"><div id="productpage_specialfilter_category"><?=$category?></div></div>
                <div class="col-sm-4"><div id="productpage_specialfilter_category_detail"></div></div>
                <div class="col-sm-4"><button type="submit" value="{{_GL('Cauta piese')}}">
                <div class="fas-search-icon"></div>
                <div>{{_GL('Cauta piese')}}</div></button>
                </div>
            </div>
        </form>
    </div>
</div>
