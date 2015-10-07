<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageService.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageService.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addService',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','SERVICEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addService',                
    'rpc',                                
    'encoded',                            
    'add Service'            
);

$server->register('updateService',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','SERVICEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateService',                
    'rpc',                                
    'encoded',                            
    'update Service'            
);

$server->register('getServiceList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getServiceList',                
    'rpc',                                
    'encoded',                            
    'add Service'            
);


$server->register('getServiceByServiceId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getServiceByServiceId',                
    'rpc',                                
    'encoded',                            
    'get Service By ServiceId'            
);


function addService($sessionkey, $appcode, $Servicedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Service = new Service();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SERVICEID":{$obj_Service->ServiceId =  $child;break;};
		case "SERVICENAME":{$obj_Service->ServiceName =  $child;break;};
		case "DESCRIPTION":{$obj_Service->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Service = DAL_manageService::addService($obj_Service);
    if ($obj_retResult_Service->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getServiceXml($obj_retResult_Service->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateService($sessionkey, $appcode, $Servicedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Service = new Service();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SERVICEID":{$obj_Service->ServiceId =  $child;break;};
		case "SERVICENAME":{$obj_Service->ServiceName =  $child;break;};
		case "DESCRIPTION":{$obj_Service->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Service = DAL_manageService::updateService($obj_Service);
    if ($obj_retResult_Service->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getServiceXml($obj_retResult_Service->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getServiceList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageService::getServiceList();
	if($result->type ==1)
	{
	$arr_ServiceList = $result->data;
		if(count($arr_ServiceList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<SERVICELIST>";
			 foreach($arr_ServiceList as $obj_Service)
			 {		 
				$main_result .=getServiceXml($obj_Service);
			 }
			$main_result .= "</SERVICELIST>";

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

function getServiceXml($obj_Service)
{
	$xml  = "<SERVICE>";	
		$xml .= "<SERVICEID>".$obj_Service->ServiceId."</SERVICEID>";
		$xml .= "<SERVICENAME>".$obj_Service->ServiceName."</SERVICENAME>";
		$xml .= "<DESCRIPTION>".$obj_Service->Description."</DESCRIPTION>";

	$xml .= "</SERVICE>";
	
	return $xml;
}
	
function getServiceByServiceId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageService::getServiceListByServiceId($id);
	if($result->type ==1)
	{
	$arr_ServiceList = $result->data;
		if(count($arr_ServiceList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_ServiceList as $obj_Service)
			 {		 
				$main_result .=getServiceXml($obj_Service);
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
