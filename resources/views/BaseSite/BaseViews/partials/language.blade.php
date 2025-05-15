@if(count($objects))
    @foreach ($objects as $v)

        @if($v->id == $_langId)
            <div class="item">{{$v->code2}}</div>
        @else
            <form method="POST" action="{{ route('web.execchangeLg') }}" enctype="multipart/form-data" class="js_af" data-targetid="messageresult" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="_backUrl" value="{{ $_backUrl }}" />
                <input type="hidden" name="id" value="{{$v->id}}" />
                <input type="hidden" name="_params" value="{{$_params}}" />

                <button type="submit" >{{$v->code2}}</button>
            </form>
        @endif

    @endforeach
@endif