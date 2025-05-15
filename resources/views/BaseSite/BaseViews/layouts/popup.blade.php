<div id={{$_idpopup}} class="js_CA_click pop-up" data-remove="#{{$_idpopup}}">
    <div class="align-pop-up">
        <div class="js_CA_click content-pop form-section" data-stopp="1">
            <h2>{{_GL('Sign_in_form')}}</h2>
            <form method="POST" action="{{ route('web.execSignIn') }}" >

                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <button type="button" class="js_CA_click close" data-remove="#{{$_idpopup}}"><i class="bi bi-x"></i></button>

                <div class="mb-2">
                    <label>{{_GL('Email')}}</label>
                    <input type="text" id="email" name="email">
                </div>
                <div class="mb-2">
                    <label>{{_GL('Password')}}</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="mb-4">
                    <button type="submit" >{{_GL('Signin')}}</button>
                </div>
            </form>
            
            @include($_view, ['_mainParams' => $_mainParams])
            <hr>

            <div class="my-1 text-center"><a href="{{route('web.signUp')}}" >{{_GL('Sign Up')}}</a></div>
            <div class="my-1 text-center"><a href="{{route('web.checkPassword')}}" >{{_GL('Forgot Password')}}</a></div>
        </div>
    </div>
</div>