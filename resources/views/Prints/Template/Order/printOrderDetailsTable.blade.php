<div class="">
    <div class="detail_order_list">


        <table class="table table-light">
            <thead>
                
            </thead>
            <tbody>
                
                <tr>
                    <td colspan="2">{{ _GL('Pay status') }}</td>
                    <td colspan="2"> {{ $data['order']->paystatus_text }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('Payment method') }}</td>
                    <td colspan="2"> {{ $data['order']->paymenthod_text }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('Delivery method') }}</td>
                    <td colspan="2"> {{ $data['order']->metodalivrare_text }}</td>
                </tr>
                
                <tr>
                    <td colspan="2">{{ _GL('destinatar name') }}</td>
                    <td colspan="2"> {{ $data['order']->destinatar_name }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('destinatar company') }}</td>
                    <td colspan="2"> {{ $data['order']->destinatar_company }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('destinatar phone') }}</td>
                    <td colspan="2"> {{ $data['order']->destinatar_phone }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('destinatar email') }}</td>
                    <td colspan="2"> {{ $data['order']->destinatar_email }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('destinatar address') }}</td>
                    <td colspan="2"> {{ $data['order']->destinatar_address }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('destinatar delivery number') }}</td>
                    <td colspan="2"> {{ $data['order']->destinatar_delivery_number }}</td>
                </tr>

                <tr>
                    <td colspan="2">{{ _GL('destinatar location') }}</td>
                    <td colspan="2"> {{ $data['order']->destinatar_location }}</td>
                </tr>


            </tbody>
        </table>
    </div>

</div>