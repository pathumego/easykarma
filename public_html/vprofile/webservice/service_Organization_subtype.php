<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageOrganization_subtype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageOrganization_subtype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addOrganization_subtype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ORGANIZATION_SUBTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addOrganization_subtype',                
    'rpc',                                
    'encoded',                            
    'add Organization_subtype'            
);

$server->register('updateOrganization_subtype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ORGANIZATION_SUBTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateOrganization_subtype',                
    'rpc',                                
    'encoded',                            
    'update Organization_subtype'            
);

$server->register('getOrganization_subtypeList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getOrganization_subtypeList',                
    'rpc',                                
    'encoded',                            
    'add Organization_subtype'            
);


$server->register('getOrganization_subtypeByOrganizationSubTypeId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getOrganization_subtypeByOrganizationSubTypeId',                
    'rpc',                                
    'encoded',                            
    'get Organization_subtype By OrganizationSubTypeId'            
);


function addOrganization_subtype($sessionkey, $appcode, $Organization_subtypedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Organization_subtype = new Organization_subtype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ORGANIZATIONSUBTYPEID":{$obj_Organization_subtype->OrganizationSubTypeId =  $child;break;};
		case "ORGANIZATIONSUBTYPENAME":{$obj_Organization_subtype->OrganizationSubTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Organization_subtype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Organization_subtype = DAL_manageOrganization_subtype::addOrganization_subtype($obj_Organization_subtype);
    if ($obj_retResult_Organization_subtype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getOrganization_subtypeXml($obj_retResult_Organization_subtype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateOrganization_subtype($sessionkey, $appcode, $Organization_subtypedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Organization_subtype = new Organization_subtype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ORGANIZATIONSUBTYPEID":{$obj_Organization_subtype->OrganizationSubTypeId =  $child;break;};
		case "ORGANIZATIONSUBTYPENAME":{$obj_Organization_subtype->OrganizationSubTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Organization_subtype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Organization_subtype = DAL_manageOrganization_subtype::updateOrganization_subtype($obj_Organization_subtype);
    if ($obj_retResult_Organization_subtype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getOrganization_subtypeXml($obj_retResult_Organization_subtype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getOrganization_subtypeList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageOrganization_subtype::getOrganization_subtypeList();
	if($result->type ==1)
	{
	$arr_Organization_subtypeList = $result->data;
		if(count($arr_Organization_subtypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<ORGANIZATION_SUBTYPELIST>";
			 foreach($arr_Organization_subtypeList as $obj_Organization_subtype)
			 {		 
				$main_result .=getOrganization_subtypeXml($obj_Organization_subtype);
			 }
			$main_result .= "</ORGANIZATION_SUBTYPELIST>";

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

function getOrganization_subtypeXml($obj_Organization_subtype)
{
	$xml  = "<ORGANIZATION_SUBTYPE>";	
		$xml .= "<ORGANIZATIONSUBTYPEID>".$obj_Organization_subtype->OrganizationSubTypeId."</ORGANIZATIONSUBTYPEID>";
		$xml .= "<ORGANIZATIONSUBTYPENAME>".$obj_Organization_subtype->OrganizationSubTypeName."</ORGANIZATIONSUBTYPENAME>";
		$xml .= "<DESCRIPTION>".$obj_Organization_subtype->Description."</DESCRIPTION>";

	$xml .= "</ORGANIZATION_SUBTYPE>";
	
	return $xml;
}
	
function getOrganization_subtypeByOrganizationSubTypeId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageOrganization_subtype::getOrganization_subtypeListByOrganizationSubTypeId($id);
	if($result->type ==1)
	{
	$arr_Organization_subtypeList = $result->data;
		if(count($arr_Organization_subtypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Organization_subtypeList as $obj_Organization_subtype)
			 {		 
				$main_result .=getOrganization_subtypeXml($obj_Organization_subtype);
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
