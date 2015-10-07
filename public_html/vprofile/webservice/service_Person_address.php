<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_address.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_address.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_address',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_ADDRESSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_address',                
    'rpc',                                
    'encoded',                            
    'add Person_address'            
);

$server->register('updatePerson_address',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_ADDRESSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_address',                
    'rpc',                                
    'encoded',                            
    'update Person_address'            
);

$server->register('getPerson_addressList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_addressList',                
    'rpc',                                
    'encoded',                            
    'add Person_address'            
);


$server->register('getPerson_addressByAddressId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_addressByAddressId',                
    'rpc',                                
    'encoded',                            
    'get Person_address By AddressId'            
);


function addPerson_address($sessionkey, $appcode, $Person_addressdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_address = new Person_address();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ADDRESSID":{$obj_Person_address->AddressId =  $child;break;};
		case "ADDRESS":{$obj_Person_address->Address =  $child;break;};
		case "ADDRESSTYPE":{$obj_Person_address->AddressType =  $child;break;};
		case "VILLAGEID":{$obj_Person_address->VillageId =  $child;break;};
		case "PERSONID":{$obj_Person_address->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_address = DAL_managePerson_address::addPerson_address($obj_Person_address);
    if ($obj_retResult_Person_address->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_addressXml($obj_retResult_Person_address->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_address($sessionkey, $appcode, $Person_addressdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_address = new Person_address();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ADDRESSID":{$obj_Person_address->AddressId =  $child;break;};
		case "ADDRESS":{$obj_Person_address->Address =  $child;break;};
		case "ADDRESSTYPE":{$obj_Person_address->AddressType =  $child;break;};
		case "VILLAGEID":{$obj_Person_address->VillageId =  $child;break;};
		case "PERSONID":{$obj_Person_address->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_address = DAL_managePerson_address::updatePerson_address($obj_Person_address);
    if ($obj_retResult_Person_address->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_addressXml($obj_retResult_Person_address->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_addressList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_address::getPerson_addressList();
	if($result->type ==1)
	{
	$arr_Person_addressList = $result->data;
		if(count($arr_Person_addressList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_ADDRESSLIST>";
			 foreach($arr_Person_addressList as $obj_Person_address)
			 {		 
				$main_result .=getPerson_addressXml($obj_Person_address);
			 }
			$main_result .= "</PERSON_ADDRESSLIST>";

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

function getPerson_addressXml($obj_Person_address)
{
	$xml  = "<PERSON_ADDRESS>";	
		$xml .= "<ADDRESSID>".$obj_Person_address->AddressId."</ADDRESSID>";
		$xml .= "<ADDRESS>".$obj_Person_address->Address."</ADDRESS>";
		$xml .= "<ADDRESSTYPE>".$obj_Person_address->AddressType."</ADDRESSTYPE>";
		$xml .= "<VILLAGEID>".$obj_Person_address->VillageId."</VILLAGEID>";
		$xml .= "<PERSONID>".$obj_Person_address->PersonId."</PERSONID>";

	$xml .= "</PERSON_ADDRESS>";
	
	return $xml;
}
	
function getPerson_addressByAddressId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_address::getPerson_addressListByAddressId($id);
	if($result->type ==1)
	{
	$arr_Person_addressList = $result->data;
		if(count($arr_Person_addressList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_addressList as $obj_Person_address)
			 {		 
				$main_result .=getPerson_addressXml($obj_Person_address);
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
