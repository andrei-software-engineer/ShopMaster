@foreach ($filterValues as $item)
    <input type="checkbox" name="filter[{{ $idfilter }}][]" value={{ $item->id }} id="input_filter_value_{{$item->id}}"
        <?= in_array($item->id, $checkedVals) ? ' checked ' : '' ?>>

    <label for="input_filter_value_{{$item->id}}">{{ $item->_name }} </label> <br>
@endforeach


<button type="submit">
    <div>{{ _GL('Cauta') }}</div>
</button>
