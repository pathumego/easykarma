<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_organization.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_organization.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_organization',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_ORGANIZATIONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_organization',                
    'rpc',                                
    'encoded',                            
    'add Village_organization'            
);

$server->register('updateVillage_organization',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_ORGANIZATIONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_organization',                
    'rpc',                                
    'encoded',                            
    'update Village_organization'            
);

$server->register('getVillage_organizationList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_organizationList',                
    'rpc',                                
    'encoded',                            
    'add Village_organization'            
);


$server->register('getVillage_organizationByVillageId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_organizationByVillageId',                
    'rpc',                                
    'encoded',                            
    'get Village_organization By VillageId'            
);


function addVillage_organization($sessionkey, $appcode, $Village_organizationdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_organization = new Village_organization();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ORGANIZATIONID":{$obj_Village_organization->OrganizationId =  $child;break;};
		case "VILLAGEID":{$obj_Village_organization->VillageId =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_organization = DAL_manageVillage_organization::addVillage_organization($obj_Village_organization);
    if ($obj_retResult_Village_organization->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_organizationXml($obj_retResult_Village_organization->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_organization($sessionkey, $appcode, $Village_organizationdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_organization = new Village_organization();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ORGANIZATIONID":{$obj_Village_organization->OrganizationId =  $child;break;};
		case "VILLAGEID":{$obj_Village_organization->VillageId =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_organization = DAL_manageVillage_organization::updateVillage_organization($obj_Village_organization);
    if ($obj_retResult_Village_organization->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_organizationXml($obj_retResult_Village_organization->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_organizationList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_organization::getVillage_organizationList();
	if($result->type ==1)
	{
	$arr_Village_organizationList = $result->data;
		if(count($arr_Village_organizationList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_ORGANIZATIONLIST>";
			 foreach($arr_Village_organizationList as $obj_Village_organization)
			 {		 
				$main_result .=getVillage_organizationXml($obj_Village_organization);
			 }
			$main_result .= "</VILLAGE_ORGANIZATIONLIST>";

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

function getVillage_organizationXml($obj_Village_organization)
{
	$xml  = "<VILLAGE_ORGANIZATION>";	
		$xml .= "<ORGANIZATIONID>".$obj_Village_organization->OrganizationId."</ORGANIZATIONID>";
		$xml .= "<VILLAGEID>".$obj_Village_organization->VillageId."</VILLAGEID>";

	$xml .= "</VILLAGE_ORGANIZATION>";
	
	return $xml;
}
	
function getVillage_organizationByVillageId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_organization::getVillage_organizationListByVillageId($id);
	if($result->type ==1)
	{
	$arr_Village_organizationList = $result->data;
		if(count($arr_Village_organizationList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_organizationList as $obj_Village_organization)
			 {		 
				$main_result .=getVillage_organizationXml($obj_Village_organization);
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
