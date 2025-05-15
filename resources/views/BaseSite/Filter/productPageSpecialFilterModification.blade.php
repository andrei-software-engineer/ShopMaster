

<select name="idmodification" id="idproductlist_modification" class="js_CA_select" data-useselected="1" data-oneach="1"  >
    <option value="" >{{ _GL('Marca') }}</option>
    @if(count($objects))
        @foreach($objects as $v)
            <option value={{$v->id}} >{{$v->_name}}</option>
        @endforeach
    @endif 
</select> 