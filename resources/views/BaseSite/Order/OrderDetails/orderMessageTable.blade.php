<div class="message"  id="order_message_web_details">
    <h2>{{ _GL('Mesaje') }}</h2>

    <table class="table table-light">
        <thead>
            <tr>
                <th scope="col">{{ _GL('Image') }}</th>
                <th scope="col">{{ _GL('Messaje') }}</th>
                <th scope="col">{{ _GL('Message Type') }}</th>
                <th scope="col">{{ _GL('Visibility Type') }}</th>
                <th scope="col">{{ _GL('Data') }}</th>
                <th scope="col">
                    <div class="button_add">
                        <button  class="js_CA_click btn btn-secondary" data-toggleinfo="#messageAdmin" type="button">{{ _GL('Add') }}</button>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            
            @if ($order->order_message)
                @foreach ($order->order_message as $item)
                    <tr>
                        <td>
                            @if ($item->systemfileobj)
                                <a href="{{$item->systemfileobj->getUrl()}}" class="js_alhl" target="">
                                    <img src='{{$item->systemfileobj->getUrl(100)}}'  alt="{{ $item->name_show }}" class='rounded-1'>
                                </a>
                            @endif
                        </td>
                        <td>{{ $item->message }}</td>
                        <td>{{ $item->visibilitytype_text }}</td>
                        <td>{{ $item->messagetype_text }}</td>
                        <td>{{ $item->data_text }}</td>
                        <td></td>
                    </tr>
                @endforeach
            @endif
            
        </tbody>
    </table>
    <div style="display: none" id="messageAdmin">
        <h2>{{ _GL('Write a message') }}</h2>

        <table class="table table-light" >
            <td>
                <div >
                    <form method="post" action="{{ route('web.saveOrderMessagex') }}"   enctype="multipart/form-data" class="js_af"  data-targetid="order_message_web_details">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="idorder" value={{$order->id}} />

                        <label >Message :</label>
                        <input class="form-control" type="text" name="message" > <br>
                        <input type="file" id="fileX" name="fileX" accept="image/png, image/jpeg" > <br> <br>
                        <button  type="submit">{{ _GL('Submit') }}</button>
                    </form>      
                </div>
            </td>

        </table>
    </div>

</div>