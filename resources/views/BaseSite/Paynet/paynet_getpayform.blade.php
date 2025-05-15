<?=$formprefix?>	
<button type="submit" style="<?=(request()->get('forapplication')) ? ' display: none; ' : ' ' ?>"><?=_GL('Plateste Acum')?></button>
</form>
<input type="hidden" class="js_CA_each" eachtimeout="<?=(request()->get('forapplication')) ? '5' : '2000' ?>" submitinfo="#paymentform">

<? if (request()->get('forapplication')) { ?>
    <p><?=_GL('asteptati. in curind ve-ti fi readresat pe pagina de plata')?></p>
<img src="/global/_appl/templates/loading.gif" width="50%"  >
<? } ?>