<?
    $showclass = 'opened';
    $hideclass = 'hided';
?>

    <form method="POST" action="{{ route('web.execfiltersleftpartvalue') }}" class="js_af" data-targetid="" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}" /> 
        <input type="hidden" name="idcategory" value={{$idcategory}}>
        <?=$otherFilters?>

        <ul class="navleft">

            <li class="js_al_h <?=($isloaded) ? $showclass : $hideclass ?> " data-showclass="{{$showclass}}" data-hideclass="{{$hideclass}}" data-isloaded="{{$isloaded}}" data-href="<?=route('web.filter.loadfiltervalues',['id' => $idfilter])?>" data-targetid="filter_values_list_<?=$idfilter?>">
                {{$obj->identifier}}
            </li>
        

            <li id="filter_values_list_<?=$idfilter?>"><?=$filterValues?></li>
        </ul>

    </form>
