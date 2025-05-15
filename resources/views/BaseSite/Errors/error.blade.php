@if($errors->any())
    <ul>
    @foreach($errors->all() as $error)
        <li>{{_GL('error')}}</li>
    @endforeach
    </ul>
@endif