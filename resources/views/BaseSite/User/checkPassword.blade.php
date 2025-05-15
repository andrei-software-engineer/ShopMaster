<div class="container mt-4">
    <div class="log-box form-section">

        <form method="POST" action="{{ route('web.execCheckPassword') }}"  >
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <h2>{{_GL('Reset_password')}}</h2>
            <div class="my-2">
                <label>{{_GL('Email')}}</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="my-4"><button type="submit" >{{_GL('Reset_password_btn')}}</button></div>
        </form>
        <hr>
        <div class="my-1 text-center">            
            <a href="{{route('web.signIn')}}" class="js_alhl">{{_GL('Sign In')}}</a>
        </div>
        <div class="my-1 text-center">
            <a href="{{route('web.signUp')}}" class="js_alhl">{{_GL('Sign Up')}}</a>
        </div>
    </div>
</div>