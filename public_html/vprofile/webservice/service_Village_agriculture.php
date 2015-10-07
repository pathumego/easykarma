<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_agriculture.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_agriculture.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_agriculture',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_AGRICULTUREDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_agriculture',                
    'rpc',                                
    'encoded',                            
    'add Village_agriculture'            
);

$server->register('updateVillage_agriculture',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_AGRICULTUREDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_agriculture',                
    'rpc',                                
    'encoded',                            
    'update Village_agriculture'            
);

$server->register('getVillage_agricultureList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_agricultureList',                
    'rpc',                                
    'encoded',                            
    'add Village_agriculture'            
);


$server->register('getVillage_agricultureByBusinessId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_agricultureByBusinessId',                
    'rpc',                                
    'encoded',                            
    'get Village_agriculture By BusinessId'            
);


function addVillage_agriculture($sessionkey, $appcode, $Village_agriculturedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_agriculture = new Village_agriculture();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "AGRICULTUREID":{$obj_Village_agriculture->AgricultureId =  $child;break;};
		case "VILLAGEID":{$obj_Village_agriculture->VillageId =  $child;break;};
		case "BUSINESSID":{$obj_Village_agriculture->BusinessId =  $child;break;};
		case "DESCRIPTION":{$obj_Village_agriculture->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_agriculture = DAL_manageVillage_agriculture::addVillage_agriculture($obj_Village_agriculture);
    if ($obj_retResult_Village_agriculture->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_agricultureXml($obj_retResult_Village_agriculture->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_agriculture($sessionkey, $appcode, $Village_agriculturedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_agriculture = new Village_agriculture();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "AGRICULTUREID":{$obj_Village_agriculture->AgricultureId =  $child;break;};
		case "VILLAGEID":{$obj_Village_agriculture->VillageId =  $child;break;};
		case "BUSINESSID":{$obj_Village_agriculture->BusinessId =  $child;break;};
		case "DESCRIPTION":{$obj_Village_agriculture->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_agriculture = DAL_manageVillage_agriculture::updateVillage_agriculture($obj_Village_agriculture);
    if ($obj_retResult_Village_agriculture->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_agricultureXml($obj_retResult_Village_agriculture->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_agricultureList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_agriculture::getVillage_agricultureList();
	if($result->type ==1)
	{
	$arr_Village_agricultureList = $result->data;
		if(count($arr_Village_agricultureList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_AGRICULTURELIST>";
			 foreach($arr_Village_agricultureList as $obj_Village_agriculture)
			 {		 
				$main_result .=getVillage_agricultureXml($obj_Village_agriculture);
			 }
			$main_result .= "</VILLAGE_AGRICULTURELIST>";

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

function getVillage_agricultureXml($obj_Village_agriculture)
{
	$xml  = "<VILLAGE_AGRICULTURE>";	
		$xml .= "<AGRICULTUREID>".$obj_Village_agriculture->AgricultureId."</AGRICULTUREID>";
		$xml .= "<VILLAGEID>".$obj_Village_agriculture->VillageId."</VILLAGEID>";
		$xml .= "<BUSINESSID>".$obj_Village_agriculture->BusinessId."</BUSINESSID>";
		$xml .= "<DESCRIPTION>".$obj_Village_agriculture->Description."</DESCRIPTION>";

	$xml .= "</VILLAGE_AGRICULTURE>";
	
	return $xml;
}
	
function getVillage_agricultureByBusinessId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_agriculture::getVillage_agricultureListByBusinessId($id);
	if($result->type ==1)
	{
	$arr_Village_agricultureList = $result->data;
		if(count($arr_Village_agricultureList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_agricultureList as $obj_Village_agriculture)
			 {		 
				$main_result .=getVillage_agricultureXml($obj_Village_agriculture);
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
