<div class="jurnal">
    <h2>{{ _GL('Jurnal') }}</h2>
    <table class="table table-light">
        <thead>
            <tr>
                <th scope="col">{{ _GL('Pay status') }}</th>
                <th scope="col">{{ _GL('Data') }}</th>
                <th scope="col">{{ _GL('Jurnal Type') }}</th>
                <th scope="col">{{ _GL('Status print') }}</th>
                <th scope="col">{{ _GL('Note journal') }}</th>

            </tr>
        </thead>
        <tbody>
            @if ($data['order']->order_journal)
                @foreach ($data['order']->order_journal as $item)
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