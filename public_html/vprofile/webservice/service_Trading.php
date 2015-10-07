<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTrading.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageTrading.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addTrading',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TRADINGDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addTrading',                
    'rpc',                                
    'encoded',                            
    'add Trading'            
);

$server->register('updateTrading',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TRADINGDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateTrading',                
    'rpc',                                
    'encoded',                            
    'update Trading'            
);

$server->register('getTradingList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTradingList',                
    'rpc',                                
    'encoded',                            
    'add Trading'            
);


$server->register('getTradingBytradingId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTradingBytradingId',                
    'rpc',                                
    'encoded',                            
    'get Trading By tradingId'            
);


function addTrading($sessionkey, $appcode, $Tradingdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Trading = new Trading();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TRADINGID":{$obj_Trading->tradingId =  $child;break;};
		case "TRADINGNAME":{$obj_Trading->tradingName =  $child;break;};
		case "TRADINGTYPE":{$obj_Trading->tradingType =  $child;break;};
		case "DESCRIPTION":{$obj_Trading->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Trading = DAL_manageTrading::addTrading($obj_Trading);
    if ($obj_retResult_Trading->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTradingXml($obj_retResult_Trading->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateTrading($sessionkey, $appcode, $Tradingdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Trading = new Trading();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TRADINGID":{$obj_Trading->tradingId =  $child;break;};
		case "TRADINGNAME":{$obj_Trading->tradingName =  $child;break;};
		case "TRADINGTYPE":{$obj_Trading->tradingType =  $child;break;};
		case "DESCRIPTION":{$obj_Trading->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Trading = DAL_manageTrading::updateTrading($obj_Trading);
    if ($obj_retResult_Trading->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTradingXml($obj_retResult_Trading->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getTradingList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageTrading::getTradingList();
	if($result->type ==1)
	{
	$arr_TradingList = $result->data;
		if(count($arr_TradingList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<TRADINGLIST>";
			 foreach($arr_TradingList as $obj_Trading)
			 {		 
				$main_result .=getTradingXml($obj_Trading);
			 }
			$main_result .= "</TRADINGLIST>";

		}
		else
		{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";
		}
	 }
	 else
	 {
	 $main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";
	 }
 }
 $main_result .= "</VPROFILERESULT>";
return $main_result;

}

function getTradingXml($obj_Trading)
{
	$xml  = "<TRADING>";	
		$xml .= "<TRADINGID>".$obj_Trading->tradingId."</TRADINGID>";
		$xml .= "<TRADINGNAME>".$obj_Trading->tradingName."</TRADINGNAME>";
		$xml .= "<TRADINGTYPE>".$obj_Trading->tradingType."</TRADINGTYPE>";
		$xml .= "<DESCRIPTION>".$obj_Trading->Description."</DESCRIPTION>";

	$xml .= "</TRADING>";
	
	return $xml;
}
	
function getTradingBytradingId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageTrading::getTradingListBytradingId($id);
	if($result->type ==1)
	{
	$arr_TradingList = $result->data;
		if(count($arr_TradingList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_TradingList as $obj_Trading)
			 {		 
				$main_result .=getTradingXml($obj_Trading);
			 }

		}
		else
		{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";
		}
	 }
	 else
	 {
	 $main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";
	 }
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}	
?>
