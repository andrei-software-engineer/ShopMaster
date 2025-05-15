<div>
    <? //dd( $params) ?>
    <textarea name="{{$params['filedname']}}" class="jsCkeditor_Parameters" id="{{$params['mainid']}}">{{$params['value']}}</textarea>

    <table id="{{$params['mainid']}}__tb_tagslist" style="display: none;">
        @foreach ($params['obj']->_gallery as $v)
        <tr>
            <td data-name="value">IMG={{$v->systemfileobj->getUrl(500, 500)}}</td>
            <td data-name="drop_text">{{$v->name_show}}</td>
            <td data-name="drop_label">{{$v->name_show}} (IMG)</td>
        </tr>
        @endforeach
        @foreach ($params['obj']->_attachements as $v)
        <tr>
            <td data-name="value">A={{$v->url}}</td>
            <td data-name="drop_text">{{$v->name_show}}</td>
            <td data-name="drop_label">{{$v->name_show}} (Attachment)</td>
        </tr>
        @endforeach
        <? /*
        @foreach ($params['obj']->_videos as $v)
        <tr>
            <td data-name="value">{{$v->standardScript}}</td>
            <td data-name="drop_text">{{$v->name_show}}</td>
            <td data-name="drop_label">{{$v->name_show}} (Video)</td>
        </tr>
        @endforeach
        */ ?>
    </table>
</div>