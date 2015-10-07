<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_industrial.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_industrial.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_industrial',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_INDUSTRIALDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_industrial',                
    'rpc',                                
    'encoded',                            
    'add Village_industrial'            
);

$server->register('updateVillage_industrial',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_INDUSTRIALDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_industrial',                
    'rpc',                                
    'encoded',                            
    'update Village_industrial'            
);

$server->register('getVillage_industrialList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_industrialList',                
    'rpc',                                
    'encoded',                            
    'add Village_industrial'            
);


$server->register('getVillage_industrialByBusinessId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_industrialByBusinessId',                
    'rpc',                                
    'encoded',                            
    'get Village_industrial By BusinessId'            
);


function addVillage_industrial($sessionkey, $appcode, $Village_industrialdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_industrial = new Village_industrial();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "INDUSTRIALID":{$obj_Village_industrial->IndustrialId =  $child;break;};
		case "VILLAGEID":{$obj_Village_industrial->VillageId =  $child;break;};
		case "BUSINESSID":{$obj_Village_industrial->BusinessId =  $child;break;};
		case "DESCRIPTION":{$obj_Village_industrial->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_industrial = DAL_manageVillage_industrial::addVillage_industrial($obj_Village_industrial);
    if ($obj_retResult_Village_industrial->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_industrialXml($obj_retResult_Village_industrial->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_industrial($sessionkey, $appcode, $Village_industrialdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_industrial = new Village_industrial();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "INDUSTRIALID":{$obj_Village_industrial->IndustrialId =  $child;break;};
		case "VILLAGEID":{$obj_Village_industrial->VillageId =  $child;break;};
		case "BUSINESSID":{$obj_Village_industrial->BusinessId =  $child;break;};
		case "DESCRIPTION":{$obj_Village_industrial->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_industrial = DAL_manageVillage_industrial::updateVillage_industrial($obj_Village_industrial);
    if ($obj_retResult_Village_industrial->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_industrialXml($obj_retResult_Village_industrial->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_industrialList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_industrial::getVillage_industrialList();
	if($result->type ==1)
	{
	$arr_Village_industrialList = $result->data;
		if(count($arr_Village_industrialList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_INDUSTRIALLIST>";
			 foreach($arr_Village_industrialList as $obj_Village_industrial)
			 {		 
				$main_result .=getVillage_industrialXml($obj_Village_industrial);
			 }
			$main_result .= "</VILLAGE_INDUSTRIALLIST>";

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

function getVillage_industrialXml($obj_Village_industrial)
{
	$xml  = "<VILLAGE_INDUSTRIAL>";	
		$xml .= "<INDUSTRIALID>".$obj_Village_industrial->IndustrialId."</INDUSTRIALID>";
		$xml .= "<VILLAGEID>".$obj_Village_industrial->VillageId."</VILLAGEID>";
		$xml .= "<BUSINESSID>".$obj_Village_industrial->BusinessId."</BUSINESSID>";
		$xml .= "<DESCRIPTION>".$obj_Village_industrial->Description."</DESCRIPTION>";

	$xml .= "</VILLAGE_INDUSTRIAL>";
	
	return $xml;
}
	
function getVillage_industrialByBusinessId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_industrial::getVillage_industrialListByBusinessId($id);
	if($result->type ==1)
	{
	$arr_Village_industrialList = $result->data;
		if(count($arr_Village_industrialList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_industrialList as $obj_Village_industrial)
			 {		 
				$main_result .=getVillage_industrialXml($obj_Village_industrial);
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
