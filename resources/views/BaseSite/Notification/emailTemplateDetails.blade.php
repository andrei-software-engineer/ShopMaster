@if($obj)
    <p>{{ _GL('Id') }}   {{$obj->id}}</p>
    <p>{{ _GL('status') }}   {{$obj->status}}</p>
    <p>{{ _GL('idfromemail') }}   {{$obj->idfromemail}}</p>
    <p>{{ _GL('identifier') }}   {{$obj->identifier}}</p>
    <p>{{ _GL('toemail') }}   {{$obj->toemail}}</p>
    <p>{{ _GL('cc') }}   {{$obj->replyto}}</p>
    <p>{{ _GL('cc') }}   {{$obj->cc}}</p>
    <p>{{ _GL('bcc') }}   {{$obj->bcc}}</p>
    <p>{{ _GL('_idlang') }}   {{$obj->_idlang}}</p>
    <p>{{ _GL('fromname') }}   {{$obj->_fromname}}</p>
    <p>{{ _GL('_toname') }}   {{$obj->_toname}}</p>
    {{ _GL('message') }}   <?= $obj->_message?>
@endif