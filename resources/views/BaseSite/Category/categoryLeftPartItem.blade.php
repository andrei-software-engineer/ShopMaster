
    <li><a href="{{$obj->url}}" class="js_alhl <?=($isselected) ? ' test1 ' : ''?> ">
        <img src="<?=$obj->_defaultGalleryGetUrl(50)?>" width="20" title="{{$obj->_name}}" alt="{{$obj->_name}}">

        {{$obj->_name}}
    </a></li>

    @if (count($childs))
        @foreach ($childs as $v)
            <li>
                <a href="{{$v->url}}" class="js_alhl ">
                    <img src="<?=$v->_defaultGalleryGetUrl(50)?>" width="20" title="{{$v->_name}}" alt="{{$v->_name}}">

                    {{$v->_name}}
                </a>
            </li>
        @endforeach
    @endif
