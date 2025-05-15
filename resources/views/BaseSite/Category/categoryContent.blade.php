@if($categories)
    <table style="width:100%">
        <tr>
            @foreach($categories as $item)
                @include('BaseSite.Category.categoryContentItem', array('obj' => $item,))
            @endforeach
        </tr>
    </table>
@endif