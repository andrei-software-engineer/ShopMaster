
    <div class="detail_order_list">


        <table class="table">

            <tbody>
                
                <tr>
                    <td><b>{{ _GL('Pay status') }}</b></td>
                    <td> {{ $data['order']->paystatus_text }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('Payment method') }}</b></td>
                    <td> {{ $data['order']->paymenthod_text }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('Delivery method') }}</b></td>
                    <td> {{ $data['order']->metodalivrare_text }}</td>
                </tr>
                
                <tr>
                    <td><b>{{ _GL('destinatar name') }}</b></td>
                    <td> {{ $data['order']->destinatar_name }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('destinatar company') }}</b></td>
                    <td> {{ $data['order']->destinatar_company }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('destinatar phone') }}</b></td>
                    <td> {{ $data['order']->destinatar_phone }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('destinatar email') }}</b></td>
                    <td> {{ $data['order']->destinatar_email }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('destinatar address') }}</b></td>
                    <td> {{ $data['order']->destinatar_address }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('destinatar delivery number') }}</b></td>
                    <td> {{ $data['order']->destinatar_delivery_number }}</td>
                </tr>

                <tr>
                    <td><b>{{ _GL('destinatar location') }}</b></td>
                    <td> {{ $data['order']->destinatar_location }}</td>
                </tr>


            </tbody>
        </table>
    </div>

