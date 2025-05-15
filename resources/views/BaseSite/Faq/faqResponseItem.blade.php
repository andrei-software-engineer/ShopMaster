@if ($obj)
    <HR>
        <p>{{$obj->_name}} </p>
        <p>{{$obj->id}}</p>
        <p>{{$obj->status}}</p>
        <p>{{$obj->_idlang}}</p>
        <p>{{$obj->_author}}</p>
        <?= $obj->_description?>
    <HR>
@endif