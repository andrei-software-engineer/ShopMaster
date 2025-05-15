<form method="POST" action="{{route('web.execCommandForm')}}" >

  <input type="hidden" name="_token" value="{{ csrf_token() }}" />

  <label >{{ _GL('Nume') }} </label>
  <input type="text" id="fname" name="fname"><br><br>

  <label >{{ _GL('Phone') }}</label>
  <input type="te"  name="phone"><br><br>

  <label for="email">{{ _GL('Enter your email') }}</label>
  <input type="email" id="email" name="email"><br><br>

  <label for="replyto">{{ _GL('MaReply torca') }} </label>
  <input type="email" id="replyto" name="replyto"><br><br>

  <label>{{ _GL('Message') }}</label>
  <textarea name="message" id="message"></textarea><br><br>

<input type="submit" value="Submit" >
</form>