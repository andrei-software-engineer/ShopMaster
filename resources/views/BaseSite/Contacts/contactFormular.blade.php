<div class="contact-form content">
    <h2>{{_GL('Scrie-ne, te putem ajuta!')}}</h2>
    <p>{{_GL('Completează formularul și obține răspuns la orice întrebare.')}}</p>

    <form method="POST" action="{{ route('web.execContactsForm') }}" class="js_af" data-targetid="messageresult" >

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <label>{{_GL('Prenumele Dvs.')}}</label>
        <input type="text" id="name" name="name"><br><br>

        <label> {{_GL('Nr. de telefon')}}</label>
        <input type="phone" name="phone"><br><br>

        <label for="email"> {{_GL('Adresa Dvs. de e-mail:')}}</label>
        <input type="email" id="email" name="email"><br><br>

        <label> {{_GL('Mesajul')}}</label>
        <textarea name="message" id="message"></textarea><br><br>

        <button type="submit">{{_GL('Trimite mesajul')}}</button>
    </form>
</div>