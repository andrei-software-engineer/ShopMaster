@if (count($objects))
    <ul class="nav navbar-nav">
        {{_GLA('Level')}} {{$level}}
        @foreach($objects as $obj)
            <li>
                @if($obj->url) 
                    <a href={{$obj->url}} class="js_alhl">{{$obj->_name}}</a>
                @endif
                @if(!$obj->url) 
                    {{$obj->_name}}
                @endif
            </li>
            <section>
                @include('BaseSite.BaseViews.partials.mainMenu', array('objects' => $obj->_childrens, 'level' => $level + 1))
            </section>
        @endforeach
    </ul>
@endif