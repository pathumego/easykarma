<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_group.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_group.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_group',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_GROUPDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_group',                
    'rpc',                                
    'encoded',                            
    'add Village_group'            
);

$server->register('updateVillage_group',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_GROUPDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_group',                
    'rpc',                                
    'encoded',                            
    'update Village_group'            
);

$server->register('getVillage_groupList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_groupList',                
    'rpc',                                
    'encoded',                            
    'add Village_group'            
);


$server->register('getVillage_groupByVillageId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_groupByVillageId',                
    'rpc',                                
    'encoded',                            
    'get Village_group By VillageId'            
);


function addVillage_group($sessionkey, $appcode, $Village_groupdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_group = new Village_group();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "GROUPID":{$obj_Village_group->GroupId =  $child;break;};
		case "VILLAGEID":{$obj_Village_group->VillageId =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_group = DAL_manageVillage_group::addVillage_group($obj_Village_group);
    if ($obj_retResult_Village_group->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_groupXml($obj_retResult_Village_group->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_group($sessionkey, $appcode, $Village_groupdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_group = new Village_group();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "GROUPID":{$obj_Village_group->GroupId =  $child;break;};
		case "VILLAGEID":{$obj_Village_group->VillageId =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_group = DAL_manageVillage_group::updateVillage_group($obj_Village_group);
    if ($obj_retResult_Village_group->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_groupXml($obj_retResult_Village_group->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_groupList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_group::getVillage_groupList();
	if($result->type ==1)
	{
	$arr_Village_groupList = $result->data;
		if(count($arr_Village_groupList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_GROUPLIST>";
			 foreach($arr_Village_groupList as $obj_Village_group)
			 {		 
				$main_result .=getVillage_groupXml($obj_Village_group);
			 }
			$main_result .= "</VILLAGE_GROUPLIST>";

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

function getVillage_groupXml($obj_Village_group)
{
	$xml  = "<VILLAGE_GROUP>";	
		$xml .= "<GROUPID>".$obj_Village_group->GroupId."</GROUPID>";
		$xml .= "<VILLAGEID>".$obj_Village_group->VillageId."</VILLAGEID>";

	$xml .= "</VILLAGE_GROUP>";
	
	return $xml;
}
	
function getVillage_groupByVillageId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_group::getVillage_groupListByVillageId($id);
	if($result->type ==1)
	{
	$arr_Village_groupList = $result->data;
		if(count($arr_Village_groupList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_groupList as $obj_Village_group)
			 {		 
				$main_result .=getVillage_groupXml($obj_Village_group);
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
