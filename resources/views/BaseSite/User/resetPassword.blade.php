<div class="container mt-4">
    <div class="log-box form-section">


    <form method="POST" action="{{ route('web.execResetPassword') }}"  >

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <input type="hidden" name="_uid" value="{{ request()->query()['uid']}}" />
        <h2>{{_GL('Reset Password Form')}}</h2>
        <div class="my-2">
            <label>{{_GL('Email')}}</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="my-2">
            <label>{{_GL('New Password')}}</label>
            <input type="password" id="new_password" name="new_password">
        </div>
        <div class="my-2">
            <label>{{_GL('Confirm New Password')}}</label>
            <input type="password" id="confirm_new_password" name="confirm_new_password">
        </div>

        <div class="my-4"><button type="submit">{{_GL('Change_password_btn')}}</button></div>
    </form>
    </div>
</div>