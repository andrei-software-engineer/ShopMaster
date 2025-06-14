<div class="category-head">
    
    @if($obj)
    <h1>{{$obj->_name}}</h1>
    @endif


    <div class="row form-line mx-2">

        <div class="col-sm-3">
            <label><?=_GL('orderByProduct')?></label>
            <select class="js_CA_select"  data-useselected="1">
                <option value="" ></option>
                    @foreach ($orderbyvals as $k => $v) 
                        @php
                            $t = $ourlparams;
                            if (!isset($t['od'])) $t['od'] = [];
                            $t['od']['o'] = $k;
                        @endphp
                        <option value="{{$k}}" <?=($o == $k) ? ' selected="selected" ' : '' ?> data-href="<?=route('web.product.list', $t)?>" >{{$v}}</option>
                    @endforeach
            </select> 
        </div>

        <div class="col-sm-2">
            <label><?=_GL('onPageProduct')?></label>
            <select class="js_CA_select"  data-useselected="1">
                <option value="" ></option>
                    @foreach ($opvals as $v) 
                        @php
                            $t = $opurlparams;
                            if (!isset($t['od'])) $t['od'] = [];
                            $t['od']['op'] = $v;
                        @endphp
                        <option value="{{$v}}" <?=($op == $v) ? ' selected="selected" ' : '' ?> data-href="<?=route('web.product.list', $t)?>" >{{$v}}</option>
                    @endforeach
            </select> 

        </div>
    </div>
</div>
