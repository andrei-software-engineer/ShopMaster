<div class="jurnal">
    <h2>{{ _GL('Jurnal') }}</h2>
    <table class="table table-light">
        <thead>
            <tr>
                <th scope="col">{{ _GL('Pay statu') }}</th>
                <th scope="col">{{ _GL('Data') }}</th>
                <th scope="col">{{ _GL('Jurnal Type') }}</th>
                <th scope="col">{{ _GL('Statusss') }}</th>
                <th scope="col">{{ _GL('Note') }}</th>

            </tr>
        </thead>
        <tbody>
            @if ($order->order_journal)
                @foreach ($order->order_journal as $item)
                    <tr>
                        <td>{{ $item->paystatus_text }}</td>
                        <td>{{ $item->data_text }}</td>
                        <td>{{ $item->orderjurnaltype_text }}</td>
                        <td>{{ $item->status_text }}</td>
                        <td>{{ $item->note }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>