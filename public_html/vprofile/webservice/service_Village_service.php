<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_service.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_service.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_service',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_SERVICEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_service',                
    'rpc',                                
    'encoded',                            
    'add Village_service'            
);

$server->register('updateVillage_service',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_SERVICEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_service',                
    'rpc',                                
    'encoded',                            
    'update Village_service'            
);

$server->register('getVillage_serviceList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_serviceList',                
    'rpc',                                
    'encoded',                            
    'add Village_service'            
);


$server->register('getVillage_serviceByBusinessId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_serviceByBusinessId',                
    'rpc',                                
    'encoded',                            
    'get Village_service By BusinessId'            
);


function addVillage_service($sessionkey, $appcode, $Village_servicedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_service = new Village_service();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SERVICEID":{$obj_Village_service->ServiceId =  $child;break;};
		case "VILLAGEID":{$obj_Village_service->VillageId =  $child;break;};
		case "BUSINESSID":{$obj_Village_service->BusinessId =  $child;break;};
		case "DESCRIPTION":{$obj_Village_service->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_service = DAL_manageVillage_service::addVillage_service($obj_Village_service);
    if ($obj_retResult_Village_service->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_serviceXml($obj_retResult_Village_service->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_service($sessionkey, $appcode, $Village_servicedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_service = new Village_service();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SERVICEID":{$obj_Village_service->ServiceId =  $child;break;};
		case "VILLAGEID":{$obj_Village_service->VillageId =  $child;break;};
		case "BUSINESSID":{$obj_Village_service->BusinessId =  $child;break;};
		case "DESCRIPTION":{$obj_Village_service->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_service = DAL_manageVillage_service::updateVillage_service($obj_Village_service);
    if ($obj_retResult_Village_service->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_serviceXml($obj_retResult_Village_service->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_serviceList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_service::getVillage_serviceList();
	if($result->type ==1)
	{
	$arr_Village_serviceList = $result->data;
		if(count($arr_Village_serviceList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_SERVICELIST>";
			 foreach($arr_Village_serviceList as $obj_Village_service)
			 {		 
				$main_result .=getVillage_serviceXml($obj_Village_service);
			 }
			$main_result .= "</VILLAGE_SERVICELIST>";

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

function getVillage_serviceXml($obj_Village_service)
{
	$xml  = "<VILLAGE_SERVICE>";	
		$xml .= "<SERVICEID>".$obj_Village_service->ServiceId."</SERVICEID>";
		$xml .= "<VILLAGEID>".$obj_Village_service->VillageId."</VILLAGEID>";
		$xml .= "<BUSINESSID>".$obj_Village_service->BusinessId."</BUSINESSID>";
		$xml .= "<DESCRIPTION>".$obj_Village_service->Description."</DESCRIPTION>";

	$xml .= "</VILLAGE_SERVICE>";
	
	return $xml;
}
	
function getVillage_serviceByBusinessId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_service::getVillage_serviceListByBusinessId($id);
	if($result->type ==1)
	{
	$arr_Village_serviceList = $result->data;
		if(count($arr_Village_serviceList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_serviceList as $obj_Village_service)
			 {		 
				$main_result .=getVillage_serviceXml($obj_Village_service);
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
