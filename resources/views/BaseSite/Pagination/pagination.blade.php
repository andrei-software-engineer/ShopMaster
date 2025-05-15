<nav >
  <ul class="pagination">

    @if ($firstPage)
        @include('BaseSite.Pagination.paginationItem', ['obj' => $firstPage])
    @endif

    @if ($prevPage)
        @include('BaseSite.Pagination.paginationItem', ['obj' => $prevPage])
    @endif


    @foreach ($links as $obj)
        @include('BaseSite.Pagination.paginationItem', ['obj' => $obj])
    @endforeach


    @if ($nextPage)
        @include('BaseSite.Pagination.paginationItem', ['obj' => $nextPage])
    @endif

    @if ($lastPage)
        @include('BaseSite.Pagination.paginationItem', ['obj' => $lastPage])
    @endif

    </ul>
</nav>