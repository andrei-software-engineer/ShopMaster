@if (count($objs))
    <ul class="nav navbar-nav">
        {{$level}}
        @foreach($objs as $obj)
            <ul>
                @if($obj->url) 
                    <a href={{$obj->url}} class="js_alhl">{{$obj->_name}}</a>
                @endif
                @if(!$obj->url) 
                    {{$obj->_name}}
                @endif
            </ul>
            <section>
                @include('BaseSite.Category.categoryLevels', array('objs' => $obj->_childrens, 'level' => $level + 1))
            </section>
        @endforeach
    </ul>
@endif