<div class="auto roles">
    <table class="table table-bordered border bg-white">
        <thead>
            <tr>
                <th colspan="1" class="text-white bg-primary">{{ _GLA('route') }} </th>
                @foreach ($data['roles'] as $role)
                    <th class="text-white bg-primary">{{ $role->name }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($data['routes'] as $k => $v)
                <tr>
                    <td colspan={{ 1 + count($data['roles']) }} 
                        class="js_CA_click section1 bg-dark text-white" 
                        data-toggleinfo=".js_modul_{{$k}}">
                        <i class="fa fa-th"></i>{{$k}}
                    </td>
                </tr>

                @foreach ($v as $k1 => $v1)
                    <tr class="js_modul_{{$k}} " style="display:none;">
                        <td colspan={{ 1 + count($data['roles']) }}
                                class="js_CA_click section2 bg-secondary text-white" 
                                data-toggleinfo=".js_modul_methos_{{$k}}_{{$k1}}">
                                <i class="fa fa-flag-checkered"></i>{{$k1}}
                        </td>
                    </tr >
                        

                    @foreach ($v1 as $k2 => $v2)
                        <tr class="js_modul_methos_{{$k}}_{{$k1}} " style="display:none;">
                            <td class="section3">{{$v2}}</td>
                            @foreach ($data['roles'] as $role)
                                <td >
                                    <input {{ ($data['results']['routes'][$k][$k1][$v2][$role->id]) ? 'checked' : '' }} type="checkbox" value="{{$role->id}}" class="js_CA_checkbox" data-checked="1" data-unchecked="0" data-updateurl="{{$data['saveurl']}}&route={{$k}}.{{$k1}}&role_id={{$role->id}}&module={{$k}}&method={{$v2}}&value=">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
                </div>
            @endforeach
        </tbody>
    </table>
</div>