@if($_infosParams)
    <?= $_infosParams ?>
@endif
<div class="content form-section">

    <form method="POST" action="{{ route('web.execSettings') }}"  >
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    
        <div class="col-sm-6">
            <div class="my-2">
                <label>{{_GL('Current Password')}}</label>
                <input type="password" id="current_password" name="current_password">
            </div>
            <div class="my-2">
                <label>{{_GL('New Password')}}</label>
                <input type="password" id="new_password" name="new_password">
            </div>
            <div class="my-2">
                <label>{{_GL('Confirm New Password')}}</label>
                <input type="password" id="confirm_new_password" name="confirm_new_password"><br><br>
            </div>

        
            <div class="my-4"><button type="submit" >{{_GL('Change_password_btn')}}</button></div>
        </div>
    </form>
    <br> 
    
</div>