
@if($obj)
    @include('BaseSite.Publicity.publicityDetail_'.$obj->advtype, ['obj' => $obj])
@endif
