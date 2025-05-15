<div class="container mt-4">
    {{-- @if($_infosParams)
        <?= $_infosParams ?>
    @endif --}}

    <div class="log-box form-section">
        <form method="POST" action="{{ route('web.execSignIn') }}" >

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <h2>{{_GL('Sign_in_form')}}</h2>
            <div class="my-2">
                <label>{{_GL('Email')}}</label>
                <input type="text" id="email" name="email">
            </div>
            <div class="my-2">
                <label>{{_GL('Password')}}</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="my-4"><button type="submit" >{{_GL('Sign_in_btn')}}</button></div>
        </form>

        <hr>
        <div class="my-1 text-center"><a href="{{route('web.signUp')}}" class="js_alhl">{{_GL('Sign Up')}}</a></div>
        <div class="my-1 text-center"><a href="{{route('web.checkPassword')}}" class="js_alhl">{{_GL('Forgot Password')}}</a></div>
    </div>
</div>