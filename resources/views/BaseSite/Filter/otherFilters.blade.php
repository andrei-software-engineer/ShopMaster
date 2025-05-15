@foreach ($otherFilters as $k => $v)
    @foreach ($v as $v1)
        <input type="hidden" name="filter[{{ $k }}][]" value="{{ $v1 }}">
    @endforeach
@endforeach
