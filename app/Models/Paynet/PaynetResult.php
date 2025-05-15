<?php

namespace App\Models\Paynet;

class PaynetResult 
{

	public $Code ; 
	public $Message ; 
	public $Data ; 
	public $DataTruncated ; 
    
	public function IsOk()
	{
		return $this->Code === PaynetCode::SUCCESS;
	}
    
	public function SetData($buttonname = '', $buttonclass = '')
	{
        $buttonname = ($buttonname) ? $buttonname : 'GO to a payment gateway of paynet';
		return $this->Data = $this->DataTruncated.'<input type="submit" class="'.$buttonclass.'" value="'.$buttonname.'" /></form>';
	}
    
	public function GetDataCustom($buttonname = '', $buttonclass = '')
	{
        $buttonname = ($buttonname) ? $buttonname : 'GO to a payment gateway of paynet';
		$rez = $this->DataTruncated.'<input type="submit" class="'.$buttonclass.'" value="'.$buttonname.'" /></form>';
        return $rez;
	}
}
