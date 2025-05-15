<div class="message">
    <h2>{{ _GL('Mesaje') }}</h2>

    <table class="table table-light">
        <thead>
            <tr>
                <th scope="col">{{ _GL('Image') }}</th>
                <th scope="col">{{ _GL('Messaje') }}</th>
                <th scope="col">{{ _GL('Message Type') }}</th>
                <th scope="col">{{ _GL('Visibility Type') }}</th>
                <th scope="col">{{ _GL('Data') }}</th>

            </tr>
        </thead>
        <tbody>
            
            @if ($data['order']->order_message)
                @foreach ($data['order']->order_message as $item)
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
   
</div>