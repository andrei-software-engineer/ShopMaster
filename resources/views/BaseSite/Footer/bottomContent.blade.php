@if (count($menus))
    <ul>
        @foreach($menus as $item)
            <li><a href={{$item->url}} class="js_alhl">  {{$item->_name}}</a></li>
        @endforeach
    </ul>
@endif