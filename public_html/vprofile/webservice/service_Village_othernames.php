<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_othernames.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_othernames.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_othernames',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_OTHERNAMESDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_othernames',                
    'rpc',                                
    'encoded',                            
    'add Village_othernames'            
);

$server->register('updateVillage_othernames',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_OTHERNAMESDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_othernames',                
    'rpc',                                
    'encoded',                            
    'update Village_othernames'            
);

$server->register('getVillage_othernamesList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_othernamesList',                
    'rpc',                                
    'encoded',                            
    'add Village_othernames'            
);


$server->register('getVillage_othernamesByVillageId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_othernamesByVillageId',                
    'rpc',                                
    'encoded',                            
    'get Village_othernames By VillageId'            
);


function addVillage_othernames($sessionkey, $appcode, $Village_othernamesdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_othernames = new Village_othernames();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "VILLAGEID":{$obj_Village_othernames->VillageId =  $child;break;};
		case "VILLAGENAMES":{$obj_Village_othernames->VillageNames =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_othernames = DAL_manageVillage_othernames::addVillage_othernames($obj_Village_othernames);
    if ($obj_retResult_Village_othernames->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_othernamesXml($obj_retResult_Village_othernames->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_othernames($sessionkey, $appcode, $Village_othernamesdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_othernames = new Village_othernames();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "VILLAGEID":{$obj_Village_othernames->VillageId =  $child;break;};
		case "VILLAGENAMES":{$obj_Village_othernames->VillageNames =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_othernames = DAL_manageVillage_othernames::updateVillage_othernames($obj_Village_othernames);
    if ($obj_retResult_Village_othernames->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_othernamesXml($obj_retResult_Village_othernames->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_othernamesList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_othernames::getVillage_othernamesList();
	if($result->type ==1)
	{
	$arr_Village_othernamesList = $result->data;
		if(count($arr_Village_othernamesList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_OTHERNAMESLIST>";
			 foreach($arr_Village_othernamesList as $obj_Village_othernames)
			 {		 
				$main_result .=getVillage_othernamesXml($obj_Village_othernames);
			 }
			$main_result .= "</VILLAGE_OTHERNAMESLIST>";

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

function getVillage_othernamesXml($obj_Village_othernames)
{
	$xml  = "<VILLAGE_OTHERNAMES>";	
		$xml .= "<VILLAGEID>".$obj_Village_othernames->VillageId."</VILLAGEID>";
		$xml .= "<VILLAGENAMES>".$obj_Village_othernames->VillageNames."</VILLAGENAMES>";

	$xml .= "</VILLAGE_OTHERNAMES>";
	
	return $xml;
}
	
function getVillage_othernamesByVillageId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_othernames::getVillage_othernamesListByVillageId($id);
	if($result->type ==1)
	{
	$arr_Village_othernamesList = $result->data;
		if(count($arr_Village_othernamesList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_othernamesList as $obj_Village_othernames)
			 {		 
				$main_result .=getVillage_othernamesXml($obj_Village_othernames);
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
