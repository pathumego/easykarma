<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTransport.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageTransport.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addTransport',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TRANSPORTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addTransport',                
    'rpc',                                
    'encoded',                            
    'add Transport'            
);

$server->register('updateTransport',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TRANSPORTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateTransport',                
    'rpc',                                
    'encoded',                            
    'update Transport'            
);

$server->register('getTransportList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTransportList',                
    'rpc',                                
    'encoded',                            
    'add Transport'            
);


$server->register('getTransportByTransportId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTransportByTransportId',                
    'rpc',                                
    'encoded',                            
    'get Transport By TransportId'            
);


function addTransport($sessionkey, $appcode, $Transportdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Transport = new Transport();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TRANSPORTID":{$obj_Transport->TransportId =  $child;break;};
		case "TRANSPORTNAME":{$obj_Transport->TransportName =  $child;break;};
		case "TRANSPORTTYPE":{$obj_Transport->TransportType =  $child;break;};
		case "DESCRIPTION":{$obj_Transport->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Transport = DAL_manageTransport::addTransport($obj_Transport);
    if ($obj_retResult_Transport->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTransportXml($obj_retResult_Transport->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateTransport($sessionkey, $appcode, $Transportdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Transport = new Transport();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TRANSPORTID":{$obj_Transport->TransportId =  $child;break;};
		case "TRANSPORTNAME":{$obj_Transport->TransportName =  $child;break;};
		case "TRANSPORTTYPE":{$obj_Transport->TransportType =  $child;break;};
		case "DESCRIPTION":{$obj_Transport->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Transport = DAL_manageTransport::updateTransport($obj_Transport);
    if ($obj_retResult_Transport->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTransportXml($obj_retResult_Transport->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getTransportList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageTransport::getTransportList();
	if($result->type ==1)
	{
	$arr_TransportList = $result->data;
		if(count($arr_TransportList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<TRANSPORTLIST>";
			 foreach($arr_TransportList as $obj_Transport)
			 {		 
				$main_result .=getTransportXml($obj_Transport);
			 }
			$main_result .= "</TRANSPORTLIST>";

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

function getTransportXml($obj_Transport)
{
	$xml  = "<TRANSPORT>";	
		$xml .= "<TRANSPORTID>".$obj_Transport->TransportId."</TRANSPORTID>";
		$xml .= "<TRANSPORTNAME>".$obj_Transport->TransportName."</TRANSPORTNAME>";
		$xml .= "<TRANSPORTTYPE>".$obj_Transport->TransportType."</TRANSPORTTYPE>";
		$xml .= "<DESCRIPTION>".$obj_Transport->Description."</DESCRIPTION>";

	$xml .= "</TRANSPORT>";
	
	return $xml;
}
	
function getTransportByTransportId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageTransport::getTransportListByTransportId($id);
	if($result->type ==1)
	{
	$arr_TransportList = $result->data;
		if(count($arr_TransportList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_TransportList as $obj_Transport)
			 {		 
				$main_result .=getTransportXml($obj_Transport);
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
