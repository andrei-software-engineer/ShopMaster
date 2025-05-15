@foreach ($objects as $v)
<div class="col-sm-4">
    <label>
        <input type="checkbox" name="filter[{{ $idfilter }}][]" value="{{ $v->id }}">
        {{ $v->_name }}
    </label>
</div>
@endforeach
