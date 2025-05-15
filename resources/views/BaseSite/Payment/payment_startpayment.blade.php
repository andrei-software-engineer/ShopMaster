<div class="container page">
	<div class="auto data">
	<form action="<?=$Value['url']?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="idpaymentorder" value="<?=$Value['paymentorder']->id?>">
		<input type="hidden" name="internsignature" value="<?=$Value['internsignature']?>">
		
        <div class="auto data-check general">
            <div class="auto">
                <span class="left"><?=L::GL('payment client')?>:</span> <span class="right"><?=$Value['paymentclient']->nume?></span>
            </div>        
            <div class="auto">
                <span class="left"><?=L::GL('payment order')?>:</span> <span class="right"><?=$Value['paymentorder']->orderidentifier?></span>
            </div>
            <div class="auto">
                <span class="left"><?=L::GL('payment amounttotal')?>:</span> <span class="right"><?=$Value['paymentorder']->amountclient_text?> <?=$Value['paymentorder']->currencyclient_text?></span>
            </div>
		</div>
		
        
        
        </form>
        
    </div>
	
    <div class="auto for-button" align="center" id="execform_result">
	</div>
    
</div>