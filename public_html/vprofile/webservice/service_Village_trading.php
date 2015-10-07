<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_trading.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_trading.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_trading',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_TRADINGDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_trading',                
    'rpc',                                
    'encoded',                            
    'add Village_trading'            
);

$server->register('updateVillage_trading',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_TRADINGDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_trading',                
    'rpc',                                
    'encoded',                            
    'update Village_trading'            
);

$server->register('getVillage_tradingList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_tradingList',                
    'rpc',                                
    'encoded',                            
    'add Village_trading'            
);


$server->register('getVillage_tradingByBusinessId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_tradingByBusinessId',                
    'rpc',                                
    'encoded',                            
    'get Village_trading By BusinessId'            
);


function addVillage_trading($sessionkey, $appcode, $Village_tradingdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_trading = new Village_trading();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TRADINGID":{$obj_Village_trading->TradingId =  $child;break;};
		case "VILLAGEID":{$obj_Village_trading->VillageId =  $child;break;};
		case "BUSINESSID":{$obj_Village_trading->BusinessId =  $child;break;};
		case "DESCRIPTION":{$obj_Village_trading->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_trading = DAL_manageVillage_trading::addVillage_trading($obj_Village_trading);
    if ($obj_retResult_Village_trading->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_tradingXml($obj_retResult_Village_trading->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_trading($sessionkey, $appcode, $Village_tradingdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_trading = new Village_trading();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TRADINGID":{$obj_Village_trading->TradingId =  $child;break;};
		case "VILLAGEID":{$obj_Village_trading->VillageId =  $child;break;};
		case "BUSINESSID":{$obj_Village_trading->BusinessId =  $child;break;};
		case "DESCRIPTION":{$obj_Village_trading->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_trading = DAL_manageVillage_trading::updateVillage_trading($obj_Village_trading);
    if ($obj_retResult_Village_trading->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_tradingXml($obj_retResult_Village_trading->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_tradingList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_trading::getVillage_tradingList();
	if($result->type ==1)
	{
	$arr_Village_tradingList = $result->data;
		if(count($arr_Village_tradingList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_TRADINGLIST>";
			 foreach($arr_Village_tradingList as $obj_Village_trading)
			 {		 
				$main_result .=getVillage_tradingXml($obj_Village_trading);
			 }
			$main_result .= "</VILLAGE_TRADINGLIST>";

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

function getVillage_tradingXml($obj_Village_trading)
{
	$xml  = "<VILLAGE_TRADING>";	
		$xml .= "<TRADINGID>".$obj_Village_trading->TradingId."</TRADINGID>";
		$xml .= "<VILLAGEID>".$obj_Village_trading->VillageId."</VILLAGEID>";
		$xml .= "<BUSINESSID>".$obj_Village_trading->BusinessId."</BUSINESSID>";
		$xml .= "<DESCRIPTION>".$obj_Village_trading->Description."</DESCRIPTION>";

	$xml .= "</VILLAGE_TRADING>";
	
	return $xml;
}
	
function getVillage_tradingByBusinessId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_trading::getVillage_tradingListByBusinessId($id);
	if($result->type ==1)
	{
	$arr_Village_tradingList = $result->data;
		if(count($arr_Village_tradingList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_tradingList as $obj_Village_trading)
			 {		 
				$main_result .=getVillage_tradingXml($obj_Village_trading);
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
