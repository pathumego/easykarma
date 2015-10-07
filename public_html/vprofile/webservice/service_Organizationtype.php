<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageOrganizationtype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageOrganizationtype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addOrganizationtype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ORGANIZATIONTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addOrganizationtype',                
    'rpc',                                
    'encoded',                            
    'add Organizationtype'            
);

$server->register('updateOrganizationtype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ORGANIZATIONTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateOrganizationtype',                
    'rpc',                                
    'encoded',                            
    'update Organizationtype'            
);

$server->register('getOrganizationtypeList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getOrganizationtypeList',                
    'rpc',                                
    'encoded',                            
    'add Organizationtype'            
);


$server->register('getOrganizationtypeByOrganizationTypeId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getOrganizationtypeByOrganizationTypeId',                
    'rpc',                                
    'encoded',                            
    'get Organizationtype By OrganizationTypeId'            
);


function addOrganizationtype($sessionkey, $appcode, $Organizationtypedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Organizationtype = new Organizationtype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ORGANIZATIONTYPEID":{$obj_Organizationtype->OrganizationTypeId =  $child;break;};
		case "ORGANIZATIONTYPENAME":{$obj_Organizationtype->OrganizationTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Organizationtype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Organizationtype = DAL_manageOrganizationtype::addOrganizationtype($obj_Organizationtype);
    if ($obj_retResult_Organizationtype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getOrganizationtypeXml($obj_retResult_Organizationtype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateOrganizationtype($sessionkey, $appcode, $Organizationtypedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Organizationtype = new Organizationtype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ORGANIZATIONTYPEID":{$obj_Organizationtype->OrganizationTypeId =  $child;break;};
		case "ORGANIZATIONTYPENAME":{$obj_Organizationtype->OrganizationTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Organizationtype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Organizationtype = DAL_manageOrganizationtype::updateOrganizationtype($obj_Organizationtype);
    if ($obj_retResult_Organizationtype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getOrganizationtypeXml($obj_retResult_Organizationtype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getOrganizationtypeList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageOrganizationtype::getOrganizationtypeList();
	if($result->type ==1)
	{
	$arr_OrganizationtypeList = $result->data;
		if(count($arr_OrganizationtypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<ORGANIZATIONTYPELIST>";
			 foreach($arr_OrganizationtypeList as $obj_Organizationtype)
			 {		 
				$main_result .=getOrganizationtypeXml($obj_Organizationtype);
			 }
			$main_result .= "</ORGANIZATIONTYPELIST>";

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

function getOrganizationtypeXml($obj_Organizationtype)
{
	$xml  = "<ORGANIZATIONTYPE>";	
		$xml .= "<ORGANIZATIONTYPEID>".$obj_Organizationtype->OrganizationTypeId."</ORGANIZATIONTYPEID>";
		$xml .= "<ORGANIZATIONTYPENAME>".$obj_Organizationtype->OrganizationTypeName."</ORGANIZATIONTYPENAME>";
		$xml .= "<DESCRIPTION>".$obj_Organizationtype->Description."</DESCRIPTION>";

	$xml .= "</ORGANIZATIONTYPE>";
	
	return $xml;
}
	
function getOrganizationtypeByOrganizationTypeId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageOrganizationtype::getOrganizationtypeListByOrganizationTypeId($id);
	if($result->type ==1)
	{
	$arr_OrganizationtypeList = $result->data;
		if(count($arr_OrganizationtypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_OrganizationtypeList as $obj_Organizationtype)
			 {		 
				$main_result .=getOrganizationtypeXml($obj_Organizationtype);
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
