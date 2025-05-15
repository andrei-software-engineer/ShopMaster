<div class="product_list">
    <h2>{{ _GL('lista de produse') }}</h2>
    <table class="table table-light">
        <thead>
            <tr>

                <th scope="col">{{ _GL('Descriere') }}</th>
                <th scope="col">{{ _GL('Status') }}</th>
                <th scope="col">{{ _GL('Cantitate') }}</th>
                <th scope="col">{{ _GL('real_pricewotvat') }}</th>
                <th scope="col">{{ _GL('discount_percent') }}</th>
                <th scope="col">{{ _GL('real_vat') }}</th>
                <th scope="col">{{ _GL('real_price') }}</th>

            </tr>
        </thead>

        <tbody>
            @if($order->products)
                @foreach ($order->products as $item)
                    <tr>
                        <td>{{$item->description}}</td>
                        <td>{{ $item->status_text }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->real_pricewotvat }}</td>
                        <td>{{ $item->discount_percent }}</td>
                        <td>{{ $item->real_vat }}</td>
                        <td>{{ $item->real_price }}</td>

                    </tr>
                    @endforeach
            @endif
        </tbody>
    </table>
</div>