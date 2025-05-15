<div class="content form-section">

    <?= $_infosParams ?>
    
    <form method="POST" action="{{ route('web.execProfile') }}" class="js_af" data-targetid="main" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <h2>{{_GL('Profile_page')}}</h2>
        <hr>
        <div class="col-sm-6">
            <div class="my-2">
                <label for="nume">{{_GL('Name')}}</label>
                <input type="text" id="nume" name="nume" value="{{$user->nume}}">
            </div>

            <div class="my-2">
                <label for="prenume">{{_GL('Surname')}}</label>
                <input type="text" id="prenume" name="prenume" value="{{$user->prenume}}">
            </div>

            <div class="my-2">
                <label for="email">{{_GL('Email')}}</label>
                <input type="email" id="email" name="email" value="{{$userEmail}}">
            </div>

            <div class="my-2">
                <label for="phone">{{_GL('Phone')}}</label>
                <input type="text" id="phone" name="phone" value="{{$user->phone}}">
            </div>
            
            <div class="my-2">
                <label for="mobil">{{_GL('Mobil')}}</label>
                <input type="text" id="mobil" name="mobil" value="{{$user->mobil}}">
            </div>

            <div class="my-4"><button type="submit" >{{_GL('Save_btn')}}</button></div>
        </div>
    </form>
    <br> 
</div>