@if(count($objects))
    @foreach($objects as $v)
        @include('BaseSite.Publicity.publicityContentItem', ['obj' => $v])
    @endforeach
@endif