<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageBusiness.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageBusiness.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addBusiness',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','BUSINESSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addBusiness',                
    'rpc',                                
    'encoded',                            
    'add Business'            
);

$server->register('updateBusiness',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','BUSINESSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateBusiness',                
    'rpc',                                
    'encoded',                            
    'update Business'            
);

$server->register('getBusinessList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getBusinessList',                
    'rpc',                                
    'encoded',                            
    'add Business'            
);


$server->register('getBusinessByBusinessId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getBusinessByBusinessId',                
    'rpc',                                
    'encoded',                            
    'get Business By BusinessId'            
);


function addBusiness($sessionkey, $appcode, $Businessdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Business = new Business();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "BUSINESSID":{$obj_Business->BusinessId =  $child;break;};
		case "NAME":{$obj_Business->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Business->Description =  $child;break;};
		case "ADDRESS":{$obj_Business->Address =  $child;break;};
		case "TELEPHONE":{$obj_Business->telephone =  $child;break;};
		case "FAX":{$obj_Business->fax =  $child;break;};
		case "WEBSITE":{$obj_Business->website =  $child;break;};
		case "EMAIL":{$obj_Business->email =  $child;break;};
		case "BUSINESSTYPEID":{$obj_Business->BusinessTypeId =  $child;break;};
		case "BUSINESSSUBTYPEID":{$obj_Business->BusinessSubTypeId =  $child;break;};

		}	
	}
	
    $obj_retResult_Business = DAL_manageBusiness::addBusiness($obj_Business);
    if ($obj_retResult_Business->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getBusinessXml($obj_retResult_Business->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateBusiness($sessionkey, $appcode, $Businessdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Business = new Business();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "BUSINESSID":{$obj_Business->BusinessId =  $child;break;};
		case "NAME":{$obj_Business->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Business->Description =  $child;break;};
		case "ADDRESS":{$obj_Business->Address =  $child;break;};
		case "TELEPHONE":{$obj_Business->telephone =  $child;break;};
		case "FAX":{$obj_Business->fax =  $child;break;};
		case "WEBSITE":{$obj_Business->website =  $child;break;};
		case "EMAIL":{$obj_Business->email =  $child;break;};
		case "BUSINESSTYPEID":{$obj_Business->BusinessTypeId =  $child;break;};
		case "BUSINESSSUBTYPEID":{$obj_Business->BusinessSubTypeId =  $child;break;};

		}	
	}
	
    $obj_retResult_Business = DAL_manageBusiness::updateBusiness($obj_Business);
    if ($obj_retResult_Business->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getBusinessXml($obj_retResult_Business->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getBusinessList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageBusiness::getBusinessList();
	if($result->type ==1)
	{
	$arr_BusinessList = $result->data;
		if(count($arr_BusinessList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<BUSINESSLIST>";
			 foreach($arr_BusinessList as $obj_Business)
			 {		 
				$main_result .=getBusinessXml($obj_Business);
			 }
			$main_result .= "</BUSINESSLIST>";

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

function getBusinessXml($obj_Business)
{
	$xml  = "<BUSINESS>";	
		$xml .= "<BUSINESSID>".$obj_Business->BusinessId."</BUSINESSID>";
		$xml .= "<NAME>".$obj_Business->Name."</NAME>";
		$xml .= "<DESCRIPTION>".$obj_Business->Description."</DESCRIPTION>";
		$xml .= "<ADDRESS>".$obj_Business->Address."</ADDRESS>";
		$xml .= "<TELEPHONE>".$obj_Business->telephone."</TELEPHONE>";
		$xml .= "<FAX>".$obj_Business->fax."</FAX>";
		$xml .= "<WEBSITE>".$obj_Business->website."</WEBSITE>";
		$xml .= "<EMAIL>".$obj_Business->email."</EMAIL>";
		$xml .= "<BUSINESSTYPEID>".$obj_Business->BusinessTypeId."</BUSINESSTYPEID>";
		$xml .= "<BUSINESSSUBTYPEID>".$obj_Business->BusinessSubTypeId."</BUSINESSSUBTYPEID>";

	$xml .= "</BUSINESS>";
	
	return $xml;
}
	
function getBusinessByBusinessId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageBusiness::getBusinessListByBusinessId($id);
	if($result->type ==1)
	{
	$arr_BusinessList = $result->data;
		if(count($arr_BusinessList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_BusinessList as $obj_Business)
			 {		 
				$main_result .=getBusinessXml($obj_Business);
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
