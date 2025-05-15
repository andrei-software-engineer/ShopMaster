@if($obj)

            @if ($obj->url)
                <li  class="breadcrumb-item active">
                    <a href="{{ $obj->url }}" class="js_alhl" >{{ $obj->_name }}</a>
                </li>
            @else
                <li class="breadcrumb-item ">
                    {{ $obj->_name }}
                </li>
            @endif

@endif