<?php

namespace App\Models\Paynet;

class PaynetModuleGlobal 
{

	// ============================================================================
	protected function GL_paynettransaction($obj, &$err, &$messcodes, $arr = false)
	{
		if ($arr === false) $arr = request::$POST;
		$arr = (array)$arr;

		$manager_name = get_class($obj).'Manager';
		$manager = $this->$manager_name;

		if (isset($arr['parentclass'])) $obj->parentclass = trim($arr['parentclass']);
		if (isset($arr['idparentclass'])) $obj->idparentclass = (int)$arr['idparentclass'];

		if (isset($arr['idpaynetwallet'])) $obj->idpaynetwallet = (int)$arr['idpaynetwallet'];

		if (isset($arr['status'])) $obj->status = (int)$arr['status'];
		if (isset($arr['tr_amount'])) $obj->tr_amount = (float)$arr['tr_amount'];
		if (isset($arr['site_amount'])) $obj->site_amount = (float)$arr['site_amount'];
		if (isset($arr['data'])) $obj->data = (int)$arr['data'];
        
		if (isset($arr['EventType'])) $obj->EventType = trim($arr['EventType']);
		if (isset($arr['PaymentSaleAreaCode'])) $obj->PaymentSaleAreaCode = trim($arr['PaymentSaleAreaCode']);
		if (isset($arr['PaymentCustomer'])) $obj->PaymentCustomer = trim($arr['PaymentCustomer']);
		if (isset($arr['PaymentStatusDate'])) $obj->PaymentStatusDate = trim($arr['PaymentStatusDate']);
		if (isset($arr['PaymentAmount'])) $obj->PaymentAmount = (int)$arr['PaymentAmount'];
		if (isset($arr['PaymentMerchant'])) $obj->PaymentMerchant = trim($arr['PaymentMerchant']);
		
		$attr = array_merge($obj->get_word(), $obj->get_text());
		foreach ($attr as $v)
		{
			if (isset($arr[$v])) $obj->$v = trim($arr[$v]);
		}
		
		$obj = $manager->save($obj, $rcode);
		
		$err = messages::iserrid($rcode, $messcodes);
		
		if ($err) return $obj;
		
		$obj = $manager->getfull($obj);
		
		return $obj;
	}
	
	// ============================================================================
	protected function GL_paynettransaction_add($obj, &$err, &$messcodes, $arr = false)
	{	
		return $this->GL_paynettransaction($obj, $err, $messcodes, $arr);
	}
	
	// ============================================================================	
	protected function GL_paynettransaction_mod($obj, &$err, &$messcodes, $arr = false)
	{	
		return $this->GL_paynettransaction($obj, $err, $messcodes, $arr);
	}	
	
	// ============================================================================
	
	
	
	
	
	
	
	// ============================================================================
	protected function GL_paynettransactionjurnal($obj, &$err, &$messcodes, $arr = false)
	{	
		if ($arr === false) $arr = request();
		$arr = (array)$arr;
		
		$manager_name = get_class($obj).'Manager';
		$manager = $this->$manager_name;
        
		if (isset($arr['idpaynettransaction'])) $obj->idpaynettransaction = (int)$arr['idpaynettransaction'];
		if (isset($arr['data'])) $obj->data = (int)$arr['data'];
		if (isset($arr['transactionjurnaltype'])) $obj->transactionjurnaltype = (int)$arr['transactionjurnaltype'];
		if (isset($arr['idrole'])) $obj->idrole = (int)$arr['idrole'];
		if (isset($arr['iduser'])) $obj->iduser = (int)$arr['iduser'];
		if (isset($arr['status'])) $obj->status = (int)$arr['status'];
		if (isset($arr['payment_status'])) $obj->payment_status = trim($arr['payment_status']);
		if (isset($arr['note'])) $obj->note = trim($arr['note']);
		
		$attr = array_merge($obj->get_word(), $obj->get_text());
		foreach ($attr as $v)
		{
			if (isset($arr[$v])) $obj->$v = trim($arr[$v]);
		}
		
		$obj = $manager->save($obj, $rcode);
		
		$err = messages::iserrid($rcode, $messcodes);
		
		return $obj;
	}
	
	// ============================================================================
	protected function GL_paynettransactionjurnal_add($obj, &$err, &$messcodes, $arr = false)
	{	
		return $this->GL_paynettransactionjurnal($obj, $err, $messcodes, $arr);
	}
	
	// ============================================================================	
	protected function GL_paynettransactionjurnal_mod($obj, &$err, &$messcodes, $arr = false)
	{	
		return $this->GL_paynettransactionjurnal($obj, $err, $messcodes, $arr);
	}	
	
	// ============================================================================
	
	
	
	
	
	
	
	
	
	
	// ============================================================================
	protected function GL_paynetwallet($obj, &$err, &$messcodes, $arr = false)
	{	
		if ($arr === false) $arr = request::$POST;
		$arr = (array)$arr;
		
		$manager_name = get_class($obj).'Manager';
		$manager = $this->$manager_name;
		
		if (isset($arr['order'])) $obj->order = (int)$arr['order'];
		if (isset($arr['status'])) $obj->status = (int)$arr['status'];
		if (isset($arr['isdefault'])) $obj->isdefault = (int)$arr['isdefault'];
		
		if (isset($arr['merchant_code'])) $obj->merchant_code = trim($arr['merchant_code']);
		if (isset($arr['merchant_secretkey'])) $obj->merchant_secretkey = trim($arr['merchant_secretkey']);
		if (isset($arr['merchant_user'])) $obj->merchant_user = trim($arr['merchant_user']);
		if (isset($arr['merchant_userpass'])) $obj->merchant_userpass = trim($arr['merchant_userpass']);
		if (isset($arr['notification_secretkey'])) $obj->notification_secretkey = trim($arr['notification_secretkey']);
		
		$attr = array_merge($obj->get_word(), $obj->get_text());
		foreach ($attr as $v)
		{
			if (isset($arr[$v])) $obj->$v = trim($arr[$v]);
		}
		
		$obj = $manager->save($obj, $rcode);
		
		$err = messages::iserrid($rcode, $messcodes);
		
		return $obj;
	}
	
	// ============================================================================
	protected function GL_paynetwallet_add($obj, &$err, &$messcodes, $arr = false)
	{	
		return $this->GL_paynetwallet($obj, $err, $messcodes, $arr);
	}
	
	// ============================================================================	
	protected function GL_paynetwallet_mod($obj, &$err, &$messcodes, $arr = false)
	{	
		return $this->GL_paynetwallet($obj, $err, $messcodes, $arr);
	}	
	
	// ============================================================================
	
	
	// ============================================================================
	protected function get_paynetwallet($paymethodtype)
	{	
		$all = $this->paynetwalletManager->getall(array('_full' => '1', 'status' => status::ACTIVE, 'isdefault' => '1', 'limit' => '1'));
		
		if (!count((array)$all))
		{
			$all = $this->paynetwalletManager->getall(array('_full' => '1', 'status' => status::ACTIVE, 'limit' => '1'));
		}
		
		if (!count((array)$all)) return false;
		
		$obj = reset($all);
		return $obj;
	}
	
	// ============================================================================
	
    
    
	// ============================================================================
	protected function gettransaction($paynettransaction, $api = false)
	{
        if (!$api)
        {
            $paynetwallet = new paynetwallet;
            $paynetwallet->id = $paynettransaction->idpaynetwallet;
            $paynetwallet = $this->paynetwalletManager->getfull($paynetwallet);
            
            $api = new PaynetEcomAPI(
                $paynetwallet->merchant_code
                , $paynetwallet->merchant_secretkey
                , $paynetwallet->merchant_user
                , $paynetwallet->merchant_userpass
                , $paynetwallet->notification_secretkey
            );
        }
        
        // ---------------------------------
        
        
        $rez = $api->PaymentGet($paynettransaction->id);
        
        if (!$rez) return false;
        if (!$rez->Data) return false;
        if (!is_array($rez->Data)) return false;
        if (!count($rez->Data)) return false;

        
        foreach ($rez->Data as $v)
        {
            if ($v['LinkUrlSuccess'] != GC::basesiteadr.$this->moduleName.'/successpayment/'.$paynettransaction->id) continue;
            
            return $v;
        }
        
        return false;
	}	
    
	// ============================================================================
	protected function checktransaction($paynettransaction, $api = false)
	{
        $tr = $this->gettransaction($paynettransaction, $api);
        
        if ($tr === false) return false;
        
        if ($tr['Status'] == 4)
        {
            if ($tr['Confirmed'] && $tr['Processed'])
            {
                return 'paid';
            }
            return 'unpaid';
        }
        
        if (strtotime($tr['ExpiryDate']) < time())
        {
            return 'expired';
        }
        
        return 'unpaid';
	}	
	
	// ============================================================================
	
    
    
	
	
	
	// ============================    GLOBAL END  ========================================
	
	
	
	
	
	// ============================================================================
	protected function cron_close_old_transaction()
	{	
		// ----------------------------------------------------------------
		$filter = array();
		$filter['_full'] = '0';
		$filter['limit'] = '10';
		$filter['status'] = status::_GAS('paynettransaction_neverificat');
		$filter['abs_moddate_less'] = time() - 864000;
		
		$all = $this->paynettransactionManager->getall($filter, array('`abs_moddate`'), true);
		
		foreach ($all as $v)
		{
            $t = $this->checktransaction($v);
            
            if ($t != 'expired' && $t !== false) continue;
            
			$arr = array();
			$arr['status'] = status::PAYNET_TRANSACTION_CANCEL;
			
			$v = $this->GL_paynettransaction_mod($v, $e, $m, $arr);
		
			if (!$e)
			{
				$arr_paynettransactionjurnal = array();
				$arr_paynettransactionjurnal['idpaynettransaction'] = $v->id;
				$arr_paynettransactionjurnal['data'] = time();
				$arr_paynettransactionjurnal['transactionjurnaltype'] = jurnaltype::TRANSACTION_CANCEL;
				$arr_paynettransactionjurnal['idrole'] = ($_SESSION['user']['id']) ? roles::USER : roles::GUEST;
				$arr_paynettransactionjurnal['iduser'] = $_SESSION['user']['id'];
				$arr_paynettransactionjurnal['status'] = $v->status;
				$arr_paynettransactionjurnal['action'] = $v->action;
				
				$paynettransactionjurnal = new paynettransactionjurnal;
				$paynettransactionjurnal = $this->GL_paynettransactionjurnal_add($paynettransactionjurnal, $e, $m, $arr_paynettransactionjurnal);
			}
		}
		// ----------------------------------------------------------------
	}
		
	// ============================================================================
	
}