<select name="idcategory" id="idproductlist_category" class="js_CA_select" data-useselected="1" data-oneach="1"  >
    <option value="" >{{_GL('Alegeti categoria')}}</option>
    @if(count($objects))
        @foreach($objects as $v)
            <option value={{$v->id}} >{{$v->_name}}</option>
        @endforeach
    @endif 
</select> 