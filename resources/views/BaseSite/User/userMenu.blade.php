<div class="content">
    @if($_userMenu)
        <ul class="nav flex-column">
            @if(count($_userMenu['objects']))
                @foreach($_userMenu['objects'] as $obj)
                    <li class="nav-item my-1">
                        @if($obj->url) 
                            <a href={{$obj->url}} class="{{($obj->_isActive ? ' active ' : '' ) }} js_alhl">{{$obj->_name}}</a>
                        @else
                            {{$obj->_name}}
                        @endif
                    </li>
                    @if($obj->_childrens)
                        <section>
                            @include('BaseSite.User.userMenu', array('_userMenu' => $obj->_childrens, 'level' => $_userMenu['level'] + 1))
                        </section> 
                    @endif
                @endforeach
            @endif
        </ul>
        <hr>
        @include('BaseSite.Profile.logout')
    @endif
</div>