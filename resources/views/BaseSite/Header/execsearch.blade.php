<div class="search">
    <form method="post" action="{{ route('web.product.list.search') }}"  enctype="multipart/form-data" class="js_af" data-targetid="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <input type="text" name="filter[search]" placeholder="{{_GL('Cod produs, numar original, nume piesa')}} ">
        
        <button type="submit" value="Search"><i class="fas-search"></i><span>{{_GL('Cauta')}}</span></button>
    </form>
</div>