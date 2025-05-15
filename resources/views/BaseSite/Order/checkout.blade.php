<div class="content form-section">
    <h2>{{ _GL('Checkout') }}</h2>
    <hr>
    <form method="POST" action="{{ route('web.execCheckout') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="col-sm-6">
            <div class="my-2">
                <label>{{ _GL('Destinatar nume') }} </label>
                <input type="text" id="destinatar_name" name="destinatar_name" value={{ $user->name }}>
            </div>
            <div class="my-2">
                <label>{{ _GL('Destinatar numar') }} </label>
                <input type="text" id="destinatar_phone" name="destinatar_phone" value={{ $infoUser->phone }}>
            </div>
            <div class="my-2">
                <label>{{ _GL('Destinatar email') }} </label>
                <input type="email" id="destinatar_email" name="destinatar_email" value={{ $user->email }}>
            </div>
            <div class="my-2">
                <label>{{ _GL('Destinatar Company') }} </label>
                <input type="text" id="destinatar_company" name="destinatar_company">
            </div>
            <div class="my-2">
                <?= $livrare?>
            </div>
            <div class="my-2">
                <label>{{ _GL('Destinatar address') }} </label>
                <input type="text" id="destinatar_address" name="destinatar_address">
            </div>
            <div class="my-2">
                <label>{{ _GL('Destinatar Numar adresa') }} </label>
                <input type="text" id="destinatar_delivery_number" name="destinatar_delivery_number">
            </div>
            <div class="my-2">
                <label>{{ _GL('Mod de Livrare') }} </label>
                @if ($mod_livrare)
                    
                        @foreach ($mod_livrare as $key => $value)
                        <div class=" w-100 d-block">
                            <input class="form-check-input" id="idlivrare_{{$key}}" type="radio" name="idlivrare" value={{ $key }}>
                            <label class="form-check-label" for="idlivrare_{{$key}}">{{ $value }}</label>
                        </div>   
                        @endforeach
                    
                @endif
            </div>
            <div class="my-2">
             <label>{{ _GL('Mod de achitare') }} </label>
                @if ($mod_livrare)
                    
                        @foreach ($mod_achitare as $key => $value)
                        <div class=" w-100 d-block">
                            <input class="form-check-input" id="idpaymenthod_{{$key}}" type="radio" name="idpaymenthod" value={{ $key }}>
                            <label class="form-check-label" for="idpaymenthod_{{$key}}">{{ $value }}</label> 
                            </div>
                        @endforeach
                    
                @endif
            </div>
            <div class="my-2">
                <label class="mb-2">{{ _GL('Comments') }}</label>        
                <textarea  id="comments" name="comments" rows="4" cols="20"></textarea>
                    <label for="comments"></label>
                
            </div>
            <div class="my-2">
                <button type="submit" >{{ _GL('Create') }}</button>
            </div>
        </div>
   
    </form>

    <div class="row p-0 m-0">
        @if ($products)
            @if (count($products))
                @foreach ($products as $v)
                    <div class="col-sm-3 p-1" id="idproductlistitem_{{$v['product']->id}}" >@include('BaseSite.Order.productItem', ['item' => $v])</div>
                @endforeach
            @endif
        @endif
    </div>

    <?= $paginate ?>
</div>
