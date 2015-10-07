<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_plant.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_plant.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_plant',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_PLANTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_plant',                
    'rpc',                                
    'encoded',                            
    'add Village_plant'            
);

$server->register('updateVillage_plant',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_PLANTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_plant',                
    'rpc',                                
    'encoded',                            
    'update Village_plant'            
);

$server->register('getVillage_plantList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_plantList',                
    'rpc',                                
    'encoded',                            
    'add Village_plant'            
);


$server->register('getVillage_plantByVillageId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_plantByVillageId',                
    'rpc',                                
    'encoded',                            
    'get Village_plant By VillageId'            
);


function addVillage_plant($sessionkey, $appcode, $Village_plantdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_plant = new Village_plant();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PLANTID":{$obj_Village_plant->PlantId =  $child;break;};
		case "VILLAGEID":{$obj_Village_plant->VillageId =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_plant = DAL_manageVillage_plant::addVillage_plant($obj_Village_plant);
    if ($obj_retResult_Village_plant->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_plantXml($obj_retResult_Village_plant->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_plant($sessionkey, $appcode, $Village_plantdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_plant = new Village_plant();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PLANTID":{$obj_Village_plant->PlantId =  $child;break;};
		case "VILLAGEID":{$obj_Village_plant->VillageId =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_plant = DAL_manageVillage_plant::updateVillage_plant($obj_Village_plant);
    if ($obj_retResult_Village_plant->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_plantXml($obj_retResult_Village_plant->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_plantList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_plant::getVillage_plantList();
	if($result->type ==1)
	{
	$arr_Village_plantList = $result->data;
		if(count($arr_Village_plantList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_PLANTLIST>";
			 foreach($arr_Village_plantList as $obj_Village_plant)
			 {		 
				$main_result .=getVillage_plantXml($obj_Village_plant);
			 }
			$main_result .= "</VILLAGE_PLANTLIST>";

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

function getVillage_plantXml($obj_Village_plant)
{
	$xml  = "<VILLAGE_PLANT>";	
		$xml .= "<PLANTID>".$obj_Village_plant->PlantId."</PLANTID>";
		$xml .= "<VILLAGEID>".$obj_Village_plant->VillageId."</VILLAGEID>";

	$xml .= "</VILLAGE_PLANT>";
	
	return $xml;
}
	
function getVillage_plantByVillageId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_plant::getVillage_plantListByVillageId($id);
	if($result->type ==1)
	{
	$arr_Village_plantList = $result->data;
		if(count($arr_Village_plantList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_plantList as $obj_Village_plant)
			 {		 
				$main_result .=getVillage_plantXml($obj_Village_plant);
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
