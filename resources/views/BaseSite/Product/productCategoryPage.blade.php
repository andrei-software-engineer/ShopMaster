@if ($obj)
    @if ($obj['produse'])
        @foreach ($obj['produse'] as $v)
            <ul>@include('BaseSite.Product.productCategoryItem', ['obj' => $v])</ul>
        @endforeach
    @endif
    {{ $obj['paginate'] }}
@endif
