<div>
    <p>device_code: <b>{{$info['device_code']}}</b></p>
    <p>expires_in: <b>{{$info['expires_in']}}</b></p>
    <p>user_code: <b>{{$info['user_code']}}</b></p>
    <p>interval: <b>{{$info['interval']}}</b></p>
    <p>verification_uri: <b><a href="{{$info['verification_uri']}}" target="_blank">{{$info['verification_uri']}}</a></b></p>
    <p>verification_uri: <b><a href="{{$info['verification_uri_complete']}}" target="_blank">{{$info['verification_uri_complete']}}</a></b></p>

    <p><b><a href="<?=route('allegro.gettoken', $info['device_code'])?>" target="_blank">GET TOKEN</a></b></p>
</div>