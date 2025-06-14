
    <div class="order_list">

        <table class="table">
            <tbody>
                <tr>
                    <td><b>{{ _GL('ID') }}</b></td>
                    <td>{{ $data['order']->id }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('User') }}</b></td>
                    <td>{{ $data['order']->user_name }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('Status table') }}</b></td>
                    <td>{{ $data['order']->status_text }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('Data') }}</b></td>
                    <td>{{ $data['order']->order_data }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('Data plata') }}</b></td>
                    <td>{{ $data['order']->order_dataplata }}</td>
                </tr>
                <tr>
                    <td><b>{{ _GL('total real pricewotvat') }}</b></td>
                    <td>{{ $data['order']->total_real_pricewotvat }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('total discount value') }}</b></td>
                    <td>{{ $data['order']->total_discount_value }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('total real vat') }}</b></td>
                    <td>{{ $data['order']->total_real_vat }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('total real price') }}</b></td>
                    <td>{{ $data['order']->total_real_price }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('total achitat') }}</b></td>
                    <td>{{ $data['order']->total_achitat }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('total datorie') }}</b></td>
                    <td>{{ $data['order']->total_datorie }}</td>
                </tr>
                
                <tr>
                    <td><b>{{ _GL('comments') }}</b></td>
                    <td>{{ $data['order']->comments }}</td>
                </tr>

            </tbody>
        </table>
    </div>
