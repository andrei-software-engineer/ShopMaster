<div class="product_list">
    <div class="d-flex justify-content-between pb-2">
        <h4>{{ _GL('lista de produse') }}</h4>
        <div class="button_add">
            <a href="{{ route('platform.orderproduct.create', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                <button class="btn btn-default" type="submit"><x-orchid-icon path="plus" class="me-2"/>{{ _GL('Add') }}</button></a>
        </div>
    </div>
    <table class="table table-light">
        <thead>
            <tr>

                <th scope="col">{{ _GL('Descriere') }}</th>
                <th scope="col">{{ _GL('Statusd') }}</th>
                <th scope="col">{{ _GL('Cantitate') }}</th>
                <th scope="col">{{ _GL('real_pricewotvat') }}</th>
                <th scope="col">{{ _GL('discount_percent') }}</th>
                <th scope="col">{{ _GL('real_vat') }}</th>
                <th scope="col">{{ _GL('real_price') }}</th>
                <th ></th>
                <th ></th>
            </tr>
        </thead>

        <tbody>
            @if($data['order']->products)
                @foreach ($data['order']->products as $item)
                    <tr>
                        <td>{{$item->description}}</td>
                        <td>{{ $item->status_text }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->real_pricewotvat }}</td>
                        <td>{{ $item->discount_percent }}</td>
                        <td>{{ $item->real_vat }}</td>
                        <td>{{ $item->real_price }}</td>

                        @if($item->productObj)
                            <td width="1">
                                <a href="{{ route('platform.orderproduct.edit', ['id' => $item->id, 'idorder' => $data['order']->id, 'idproduct' => $item->productObj->id, 'backUrl' => $data['backUrl']]) }}" class="d-inline">
                                    <button class="btn btn-default" type="submit"><x-orchid-icon path="pencil" /></button></a>
                            </td>
                        @endif
                        <td width="1">
                            <a href="{{ route('platform.deleteOrderProduct', ['id' => $item->id, 'backUrl' => $data['backUrl']]) }}"
                                onclick="return confirm('Are you sure you want to delete the product ?');">
                                <button class="btn btn-default" type="submit"><x-orchid-icon path="trash"/></button>
                            </a>
                        </td>

                    </tr>
                    @endforeach
            @endif
        </tbody>
    </table>
</div>