<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_society.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_society.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_society',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_SOCIETYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_society',                
    'rpc',                                
    'encoded',                            
    'add Village_society'            
);

$server->register('updateVillage_society',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_SOCIETYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_society',                
    'rpc',                                
    'encoded',                            
    'update Village_society'            
);

$server->register('getVillage_societyList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_societyList',                
    'rpc',                                
    'encoded',                            
    'add Village_society'            
);


$server->register('getVillage_societyByVillageSocietyId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_societyByVillageSocietyId',                
    'rpc',                                
    'encoded',                            
    'get Village_society By VillageSocietyId'            
);


function addVillage_society($sessionkey, $appcode, $Village_societydata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_society = new Village_society();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SOCIETYID":{$obj_Village_society->SocietyId =  $child;break;};
		case "VILLAGEID":{$obj_Village_society->VillageId =  $child;break;};
		case "VILLAGESOCIETYID":{$obj_Village_society->VillageSocietyId =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_society = DAL_manageVillage_society::addVillage_society($obj_Village_society);
    if ($obj_retResult_Village_society->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_societyXml($obj_retResult_Village_society->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_society($sessionkey, $appcode, $Village_societydata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_society = new Village_society();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SOCIETYID":{$obj_Village_society->SocietyId =  $child;break;};
		case "VILLAGEID":{$obj_Village_society->VillageId =  $child;break;};
		case "VILLAGESOCIETYID":{$obj_Village_society->VillageSocietyId =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_society = DAL_manageVillage_society::updateVillage_society($obj_Village_society);
    if ($obj_retResult_Village_society->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_societyXml($obj_retResult_Village_society->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_societyList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_society::getVillage_societyList();
	if($result->type ==1)
	{
	$arr_Village_societyList = $result->data;
		if(count($arr_Village_societyList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_SOCIETYLIST>";
			 foreach($arr_Village_societyList as $obj_Village_society)
			 {		 
				$main_result .=getVillage_societyXml($obj_Village_society);
			 }
			$main_result .= "</VILLAGE_SOCIETYLIST>";

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

function getVillage_societyXml($obj_Village_society)
{
	$xml  = "<VILLAGE_SOCIETY>";	
		$xml .= "<SOCIETYID>".$obj_Village_society->SocietyId."</SOCIETYID>";
		$xml .= "<VILLAGEID>".$obj_Village_society->VillageId."</VILLAGEID>";
		$xml .= "<VILLAGESOCIETYID>".$obj_Village_society->VillageSocietyId."</VILLAGESOCIETYID>";

	$xml .= "</VILLAGE_SOCIETY>";
	
	return $xml;
}
	
function getVillage_societyByVillageSocietyId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_society::getVillage_societyListByVillageSocietyId($id);
	if($result->type ==1)
	{
	$arr_Village_societyList = $result->data;
		if(count($arr_Village_societyList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_societyList as $obj_Village_society)
			 {		 
				$main_result .=getVillage_societyXml($obj_Village_society);
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
