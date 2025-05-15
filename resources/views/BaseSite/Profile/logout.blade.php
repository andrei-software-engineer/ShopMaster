
    <form method="POST" action="{{ route('web.execLogout') }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        
        <div><button type="submit" class="logout-btn">{{_GL('Log_out_btn')}}</button></div>
    </form>
