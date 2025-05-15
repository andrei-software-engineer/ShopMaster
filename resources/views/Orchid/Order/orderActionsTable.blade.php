<div class="action_list layout">
    <h5>{{ _GL('Actiuni') }}</h5>
    <hr>
    <b>{{_GL('Set status')}}</b>

    @if($data['order']->can_new)
        <span class="d-block">
            <a href="{{ route('platform.setNew', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');"><x-orchid-icon path="plus-alt" class="me-2"/>{{ _GL('Set new') }}</button>
            </a>
        </span>
    @endif
    @if($data['order']->can_pending)
        <span class="d-block">
            <a href="{{ route('platform.setPending', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');"><x-orchid-icon path="reload" class="me-2"/>{{ _GL('Set pending') }}</button>
            </a>
        </span>
    @endif
    @if($data['order']->can_verified)
        <span class="d-block">
            <a href="{{ route('platform.setVerified', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}"><button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');"><x-orchid-icon path="check" class="me-2"/>{{ _GL('Set verified') }}</button>
            </a>
        </span>
    @endif
    @if($data['order']->can_inprocess)
        <span class="d-block">
            <a href="{{ route('platform.setInProcess', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                <x-orchid-icon path="loading" class="me-2"/>{{ _GL('Set in process') }}
                </button>
            </a>
        </span>        
    @endif
    @if($data['order']->can_processed)
        <span class="d-block">
            <a href="{{ route('platform.setProcessed', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
            <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
            <x-orchid-icon path="backet-loaded" class="me-2"/>{{ _GL('Set processed') }}
                </button>
            </a>
        </span>          
    @endif
    @if($data['order']->can_ontransit)
        <span class="d-block">
            <a href="{{ route('platform.setOnTransit', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                <x-orchid-icon path="direction" class="me-2"/>{{ _GL('Set on transit') }}
                </button>
            </a>
        </span>                    
    @endif
    @if($data['order']->can_ondelivery)
        <span class="d-block">
            <a href="{{ route('platform.setOnDelivery', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                <x-orchid-icon path="plane" class="me-2"/>{{ _GL('Set on delivery') }}
                </button>
            </a>
        </span>           
    @endif
    @if($data['order']->can_delivered)
        <span class="d-block">
            <a href="{{ route('platform.setDelivered', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                <x-orchid-icon path="target" class="me-2"/>{{ _GL('Set delivered') }}
                </button>
            </a>
        </span>
    @endif
    @if($data['order']->can_confirmed)  
        <span class="d-block">
            <a href="{{ route('platform.setConfirmed', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                <x-orchid-icon path="user-following" class="me-2"/>{{ _GL('Set confirmed') }}
                </button>
            </a>
        </span>
     @endif
     @if($data['order']->can_canceled)
        <span class="d-block">
            <a href="{{ route('platform.setCanceled', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                <x-orchid-icon path="ban" class="me-2"/>{{ _GL('Set canceled') }}
                </button>
            </a>
        </span>
    @endif
    @if($data['order']->can_arhived)
    <span class="d-block">
        <a href="{{ route('platform.setArhived', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}"><button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');"><x-orchid-icon path="server" class="me-2"/>{{ _GL('Set arhived') }}</button>
        </a>    
    </span>    
    @endif
    <span class="d-block">
        <a href="{{ route('web.printOrderDetailsPDF', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}"><button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to print ?');"><x-orchid-icon path="printer" class="me-2"/>{{ _GL('Print') }}</button></a>
    </span>
                
</div>
<div class="layout">
    <h5>{{ _GL('Set payment status' ) }}</h5>
    <hr>
    
                @if($data['order']->can_unpayed)
                    <span class="d-block">  
                            <a href="{{ route('platform.setUnpaid', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                                <x-orchid-icon path="wallet" class="me-2"/>{{ _GL('Unpaid') }}
                                </button>
                            </a>
                        </span> 
                @endif

                @if($data['order']->can_pay)
                    <span class="d-block">   
                            <a href="{{ route('platform.setPaid', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                                <x-orchid-icon path="euro" class="me-2"/>{{ _GL('Paid') }}
                                </button>
                            </a>
                        </span> 
                @endif

                @if($data['order']->can_needreturn)
                    <span class="d-block">  
                            <a href="{{ route('platform.setNeedReturn', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                                <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                                <x-orchid-icon path="left" class="me-2"/>{{ _GL('Need return') }}
                                </button>
                            </a>
                        </span> 
                    @endif

                @if($data['order']->can_return)
                    <span class="d-block"> 
                        <a href="{{ route('platform.setReturned', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                            <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                            <x-orchid-icon path="reload" class="me-2"/>{{ _GL('Returned') }}
                            </button>
                        </a>
                    </span> 
                @endif

                @if($data['order']->can_cancel_payment)
                    <span class="d-block">    
                        <a href="{{ route('platform.setPaymentCanceled', ['idorder' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                            <button class="btn btn-default m-1" type="submit" onclick="return confirm('Are you sure you want to change the status ?');">
                            <x-orchid-icon path="ban " class="me-2"/>{{ _GL('Canceled') }}
                            </button>
                        </a>
                    </span> 
                @endif

</div>