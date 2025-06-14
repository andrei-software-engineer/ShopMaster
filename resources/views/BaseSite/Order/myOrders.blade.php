<section class="container page">
    <?= $_infosParams?>
    
    <div class="content">
    @if(count($orders))
        <table>
            <tr>
                <th>{{ _GL('Id') }} | </th>
                <th>{{ _GL('Statuss') }} | </th>
                <th>{{ _GL('Status Plata') }} | </th>
                <th>{{ _GL('Data') }}                         | </th>
                <th>{{ _GL('Data Plata') }}         | </th>
                <th>{{ _GL('Pret') }} | </th>
                <th>{{ _GL('Discount') }} | </th>
                <th>{{ _GL('Actions') }} | </th>
            </tr>

            @foreach($orders as $v)   
                <tr>
                    <td><a href={{$v->url}} class="js_alhl">{{$v->id}} </a></td>
                    <td>{{$v->status_text}}</td>
                    <td>{{$v->paystatus_text}}</td>
                    <td>{{_GDTT($v->data)}}</td>
                    <td>{{_GDTT($v->dataplata)}}</td> 
                    <td>{{$v->total_real_price}}</td>
                    <td>{{$v->total_discount_value}}</td>
                </tr>
            @endforeach
        </table>
        <br>
        <?=$paginate?>
    @endif
    </div>
</div>