<div >
    <form method="POST" action="{{ route('web.execfiltersleftpartvalue') }}" class="js_af" data-targetid="" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}" /> 
        <input type="hidden" name="idcategory" value={{$idcategory}}>
        <input type="hidden" name="idfilter" value={{$obj->id}}>
        <?=$otherFilters?>

        {{$obj->identifier}}<br>

        @if(!empty($filterRange[$obj->id]))
            <input type="text" name="filter[{{ $obj->id }}][]" value={{ (!empty($filterRange[$obj->id][0])) ? ($filterRange[$obj->id][0]) : 324 }}>
            <input type="text" name="filter[{{ $obj->id }}][]" value={{ (!empty($filterRange[$obj->id][1])) ? ($filterRange[$obj->id][1]) : 234 }}>
        @else
            <input type="text" name="filter[{{ $obj->id }}][]" value="">
            <input type="text" name="filter[{{ $obj->id }}][]" value="">
        @endif

        <button type="submit"><div>{{ _GL('CautaX') }}</div></button>
    </form>
    <br>
</div>