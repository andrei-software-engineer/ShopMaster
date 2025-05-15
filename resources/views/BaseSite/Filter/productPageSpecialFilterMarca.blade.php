<select name="idmarca" id="idproductpagespecialfiltermarca" class="js_CA_select" data-useselected="1" data-oneach="1"  >
    <option value="" >{{ _GL('Marca') }}</option>
    @if(count($objects))
        @foreach($objects as $v)
            <option value={{$v->id}} >{{$v->_name}}</option>
        @endforeach
    @endif 
</select> 

<select name="idmarca" id="idproductpagespecialfiltermarca" class="js_CA_select" data-useselected="1" data-oneach="1"  >
    <option value="" data-href="<?=route('web.specialfilter.homemodel', ['id' => $selectedId, 'idMarca' => 0])?>" data-targetid="homepage_specialfilter_model" >{{_GL('Marca')}}</option>
    @if(count($objects))
        @foreach($objects as $v)
            <option value={{$v->id}} data-href="<?=route('web.specialfilter.homemodel', ['id' => $selectedId, 'idMarca' => $v->id])?>" data-targetid="homepage_specialfilter_model">{{$v->_name}}</option>
        @endforeach
    @endif 
</select> 
