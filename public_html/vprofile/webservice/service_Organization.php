<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageOrganization.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageOrganization.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addOrganization',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ORGANIZATIONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addOrganization',                
    'rpc',                                
    'encoded',                            
    'add Organization'            
);

$server->register('updateOrganization',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ORGANIZATIONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateOrganization',                
    'rpc',                                
    'encoded',                            
    'update Organization'            
);

$server->register('getOrganizationList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getOrganizationList',                
    'rpc',                                
    'encoded',                            
    'add Organization'            
);


$server->register('getOrganizationByOrganizationId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getOrganizationByOrganizationId',                
    'rpc',                                
    'encoded',                            
    'get Organization By OrganizationId'            
);


function addOrganization($sessionkey, $appcode, $Organizationdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Organization = new Organization();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ORGANIZATIONID":{$obj_Organization->OrganizationId =  $child;break;};
		case "NAME":{$obj_Organization->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Organization->Description =  $child;break;};
		case "ADDRESS":{$obj_Organization->Address =  $child;break;};
		case "TELEPHONE":{$obj_Organization->telephone =  $child;break;};
		case "FAX":{$obj_Organization->fax =  $child;break;};
		case "WEBSITE":{$obj_Organization->website =  $child;break;};
		case "EMAIL":{$obj_Organization->email =  $child;break;};
		case "ORGANIZATIONTYPEID":{$obj_Organization->OrganizationTypeId =  $child;break;};
		case "ORGANIZATIONSUBTYPEID":{$obj_Organization->OrganizationSubTypeId =  $child;break;};

		}	
	}
	
    $obj_retResult_Organization = DAL_manageOrganization::addOrganization($obj_Organization);
    if ($obj_retResult_Organization->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getOrganizationXml($obj_retResult_Organization->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateOrganization($sessionkey, $appcode, $Organizationdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Organization = new Organization();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ORGANIZATIONID":{$obj_Organization->OrganizationId =  $child;break;};
		case "NAME":{$obj_Organization->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Organization->Description =  $child;break;};
		case "ADDRESS":{$obj_Organization->Address =  $child;break;};
		case "TELEPHONE":{$obj_Organization->telephone =  $child;break;};
		case "FAX":{$obj_Organization->fax =  $child;break;};
		case "WEBSITE":{$obj_Organization->website =  $child;break;};
		case "EMAIL":{$obj_Organization->email =  $child;break;};
		case "ORGANIZATIONTYPEID":{$obj_Organization->OrganizationTypeId =  $child;break;};
		case "ORGANIZATIONSUBTYPEID":{$obj_Organization->OrganizationSubTypeId =  $child;break;};

		}	
	}
	
    $obj_retResult_Organization = DAL_manageOrganization::updateOrganization($obj_Organization);
    if ($obj_retResult_Organization->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getOrganizationXml($obj_retResult_Organization->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getOrganizationList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageOrganization::getOrganizationList();
	if($result->type ==1)
	{
	$arr_OrganizationList = $result->data;
		if(count($arr_OrganizationList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<ORGANIZATIONLIST>";
			 foreach($arr_OrganizationList as $obj_Organization)
			 {		 
				$main_result .=getOrganizationXml($obj_Organization);
			 }
			$main_result .= "</ORGANIZATIONLIST>";

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

function getOrganizationXml($obj_Organization)
{
	$xml  = "<ORGANIZATION>";	
		$xml .= "<ORGANIZATIONID>".$obj_Organization->OrganizationId."</ORGANIZATIONID>";
		$xml .= "<NAME>".$obj_Organization->Name."</NAME>";
		$xml .= "<DESCRIPTION>".$obj_Organization->Description."</DESCRIPTION>";
		$xml .= "<ADDRESS>".$obj_Organization->Address."</ADDRESS>";
		$xml .= "<TELEPHONE>".$obj_Organization->telephone."</TELEPHONE>";
		$xml .= "<FAX>".$obj_Organization->fax."</FAX>";
		$xml .= "<WEBSITE>".$obj_Organization->website."</WEBSITE>";
		$xml .= "<EMAIL>".$obj_Organization->email."</EMAIL>";
		$xml .= "<ORGANIZATIONTYPEID>".$obj_Organization->OrganizationTypeId."</ORGANIZATIONTYPEID>";
		$xml .= "<ORGANIZATIONSUBTYPEID>".$obj_Organization->OrganizationSubTypeId."</ORGANIZATIONSUBTYPEID>";

	$xml .= "</ORGANIZATION>";
	
	return $xml;
}
	
function getOrganizationByOrganizationId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageOrganization::getOrganizationListByOrganizationId($id);
	if($result->type ==1)
	{
	$arr_OrganizationList = $result->data;
		if(count($arr_OrganizationList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_OrganizationList as $obj_Organization)
			 {		 
				$main_result .=getOrganizationXml($obj_Organization);
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
