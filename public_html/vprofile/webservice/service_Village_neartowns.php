<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_neartowns.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_neartowns.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_neartowns',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_NEARTOWNSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_neartowns',                
    'rpc',                                
    'encoded',                            
    'add Village_neartowns'            
);

$server->register('updateVillage_neartowns',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_NEARTOWNSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_neartowns',                
    'rpc',                                
    'encoded',                            
    'update Village_neartowns'            
);

$server->register('getVillage_neartownsList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_neartownsList',                
    'rpc',                                
    'encoded',                            
    'add Village_neartowns'            
);


$server->register('getVillage_neartownsByTownId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_neartownsByTownId',                
    'rpc',                                
    'encoded',                            
    'get Village_neartowns By TownId'            
);


function addVillage_neartowns($sessionkey, $appcode, $Village_neartownsdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_neartowns = new Village_neartowns();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "VILLAGEID":{$obj_Village_neartowns->VillageId =  $child;break;};
		case "TOWNID":{$obj_Village_neartowns->TownId =  $child;break;};
		case "DISTANCE":{$obj_Village_neartowns->Distance =  $child;break;};
		case "DESCRIPTION":{$obj_Village_neartowns->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_neartowns = DAL_manageVillage_neartowns::addVillage_neartowns($obj_Village_neartowns);
    if ($obj_retResult_Village_neartowns->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_neartownsXml($obj_retResult_Village_neartowns->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_neartowns($sessionkey, $appcode, $Village_neartownsdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_neartowns = new Village_neartowns();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "VILLAGEID":{$obj_Village_neartowns->VillageId =  $child;break;};
		case "TOWNID":{$obj_Village_neartowns->TownId =  $child;break;};
		case "DISTANCE":{$obj_Village_neartowns->Distance =  $child;break;};
		case "DESCRIPTION":{$obj_Village_neartowns->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_neartowns = DAL_manageVillage_neartowns::updateVillage_neartowns($obj_Village_neartowns);
    if ($obj_retResult_Village_neartowns->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_neartownsXml($obj_retResult_Village_neartowns->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_neartownsList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_neartowns::getVillage_neartownsList();
	if($result->type ==1)
	{
	$arr_Village_neartownsList = $result->data;
		if(count($arr_Village_neartownsList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_NEARTOWNSLIST>";
			 foreach($arr_Village_neartownsList as $obj_Village_neartowns)
			 {		 
				$main_result .=getVillage_neartownsXml($obj_Village_neartowns);
			 }
			$main_result .= "</VILLAGE_NEARTOWNSLIST>";

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

function getVillage_neartownsXml($obj_Village_neartowns)
{
	$xml  = "<VILLAGE_NEARTOWNS>";	
		$xml .= "<VILLAGEID>".$obj_Village_neartowns->VillageId."</VILLAGEID>";
		$xml .= "<TOWNID>".$obj_Village_neartowns->TownId."</TOWNID>";
		$xml .= "<DISTANCE>".$obj_Village_neartowns->Distance."</DISTANCE>";
		$xml .= "<DESCRIPTION>".$obj_Village_neartowns->Description."</DESCRIPTION>";

	$xml .= "</VILLAGE_NEARTOWNS>";
	
	return $xml;
}
	
function getVillage_neartownsByTownId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_neartowns::getVillage_neartownsListByTownId($id);
	if($result->type ==1)
	{
	$arr_Village_neartownsList = $result->data;
		if(count($arr_Village_neartownsList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_neartownsList as $obj_Village_neartowns)
			 {		 
				$main_result .=getVillage_neartownsXml($obj_Village_neartowns);
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
