<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_transport.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_transport.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_transport',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_TRANSPORTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_transport',                
    'rpc',                                
    'encoded',                            
    'add Village_transport'            
);

$server->register('updateVillage_transport',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_TRANSPORTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_transport',                
    'rpc',                                
    'encoded',                            
    'update Village_transport'            
);

$server->register('getVillage_transportList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_transportList',                
    'rpc',                                
    'encoded',                            
    'add Village_transport'            
);


$server->register('getVillage_transportByVillageId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_transportByVillageId',                
    'rpc',                                
    'encoded',                            
    'get Village_transport By VillageId'            
);


function addVillage_transport($sessionkey, $appcode, $Village_transportdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_transport = new Village_transport();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TRANSPORTID":{$obj_Village_transport->TransportId =  $child;break;};
		case "VILLAGEID":{$obj_Village_transport->VillageId =  $child;break;};
		case "DESCRIPTION":{$obj_Village_transport->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_transport = DAL_manageVillage_transport::addVillage_transport($obj_Village_transport);
    if ($obj_retResult_Village_transport->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_transportXml($obj_retResult_Village_transport->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_transport($sessionkey, $appcode, $Village_transportdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_transport = new Village_transport();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TRANSPORTID":{$obj_Village_transport->TransportId =  $child;break;};
		case "VILLAGEID":{$obj_Village_transport->VillageId =  $child;break;};
		case "DESCRIPTION":{$obj_Village_transport->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_transport = DAL_manageVillage_transport::updateVillage_transport($obj_Village_transport);
    if ($obj_retResult_Village_transport->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_transportXml($obj_retResult_Village_transport->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_transportList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_transport::getVillage_transportList();
	if($result->type ==1)
	{
	$arr_Village_transportList = $result->data;
		if(count($arr_Village_transportList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_TRANSPORTLIST>";
			 foreach($arr_Village_transportList as $obj_Village_transport)
			 {		 
				$main_result .=getVillage_transportXml($obj_Village_transport);
			 }
			$main_result .= "</VILLAGE_TRANSPORTLIST>";

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

function getVillage_transportXml($obj_Village_transport)
{
	$xml  = "<VILLAGE_TRANSPORT>";	
		$xml .= "<TRANSPORTID>".$obj_Village_transport->TransportId."</TRANSPORTID>";
		$xml .= "<VILLAGEID>".$obj_Village_transport->VillageId."</VILLAGEID>";
		$xml .= "<DESCRIPTION>".$obj_Village_transport->Description."</DESCRIPTION>";

	$xml .= "</VILLAGE_TRANSPORT>";
	
	return $xml;
}
	
function getVillage_transportByVillageId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_transport::getVillage_transportListByVillageId($id);
	if($result->type ==1)
	{
	$arr_Village_transportList = $result->data;
		if(count($arr_Village_transportList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_transportList as $obj_Village_transport)
			 {		 
				$main_result .=getVillage_transportXml($obj_Village_transport);
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
