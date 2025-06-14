<div class="col-md-6">
    <div class="order_list">
        <h2>{{ _GL('Order') }}</h2>

        <table class="table table-light">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">{{ _GL('User') }}</td>
                    <td colspan="2"> {{$order->user_name }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('Statusx') }}</td>
                    <td colspan="2"> {{$order->status_text }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('Data') }}</td>
                    <td colspan="2"> {{$order->order_data }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('Data plata') }}</td>
                    <td colspan="2"> {{$order->order_dataplata }}</td>
                </tr>
                <tr>
                    <td colspan="2">{{ _GL('total real pricewotvat') }}</td>
                    <td colspan="2"> {{$order->total_real_pricewotvat }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('total discount value') }}</td>
                    <td colspan="2"> {{$order->total_discount_value }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('total real vat') }}</td>
                    <td colspan="2"> {{$order->total_real_vat }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('total real price') }}</td>
                    <td colspan="2"> {{$order->total_real_price }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('total achitat') }}</td>
                    <td colspan="2"> {{$order->total_achitat }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('total datorie') }}</td>
                    <td colspan="2"> {{$order->total_datorie }}</td>
                </tr>
                
                <tr>
                    <td colspan="2">{{ _GL('comments') }}</td>
                    <td colspan="2"> {{$order->comments }}</td>
                </tr>

            </tbody>
        </table>
    </div>
</div>