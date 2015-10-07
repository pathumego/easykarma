<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_telephone.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_telephone.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_telephone',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_TELEPHONEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_telephone',                
    'rpc',                                
    'encoded',                            
    'add Person_telephone'            
);

$server->register('updatePerson_telephone',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_TELEPHONEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_telephone',                
    'rpc',                                
    'encoded',                            
    'update Person_telephone'            
);

$server->register('getPerson_telephoneList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_telephoneList',                
    'rpc',                                
    'encoded',                            
    'add Person_telephone'            
);


$server->register('getPerson_telephoneByPhoneId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_telephoneByPhoneId',                
    'rpc',                                
    'encoded',                            
    'get Person_telephone By PhoneId'            
);


function addPerson_telephone($sessionkey, $appcode, $Person_telephonedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_telephone = new Person_telephone();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PHONEID":{$obj_Person_telephone->PhoneId =  $child;break;};
		case "PHONENUMBER":{$obj_Person_telephone->PhoneNumber =  $child;break;};
		case "TYPE":{$obj_Person_telephone->Type =  $child;break;};
		case "PERSONID":{$obj_Person_telephone->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_telephone = DAL_managePerson_telephone::addPerson_telephone($obj_Person_telephone);
    if ($obj_retResult_Person_telephone->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_telephoneXml($obj_retResult_Person_telephone->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_telephone($sessionkey, $appcode, $Person_telephonedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_telephone = new Person_telephone();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PHONEID":{$obj_Person_telephone->PhoneId =  $child;break;};
		case "PHONENUMBER":{$obj_Person_telephone->PhoneNumber =  $child;break;};
		case "TYPE":{$obj_Person_telephone->Type =  $child;break;};
		case "PERSONID":{$obj_Person_telephone->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_telephone = DAL_managePerson_telephone::updatePerson_telephone($obj_Person_telephone);
    if ($obj_retResult_Person_telephone->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_telephoneXml($obj_retResult_Person_telephone->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_telephoneList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_telephone::getPerson_telephoneList();
	if($result->type ==1)
	{
	$arr_Person_telephoneList = $result->data;
		if(count($arr_Person_telephoneList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_TELEPHONELIST>";
			 foreach($arr_Person_telephoneList as $obj_Person_telephone)
			 {		 
				$main_result .=getPerson_telephoneXml($obj_Person_telephone);
			 }
			$main_result .= "</PERSON_TELEPHONELIST>";

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

function getPerson_telephoneXml($obj_Person_telephone)
{
	$xml  = "<PERSON_TELEPHONE>";	
		$xml .= "<PHONEID>".$obj_Person_telephone->PhoneId."</PHONEID>";
		$xml .= "<PHONENUMBER>".$obj_Person_telephone->PhoneNumber."</PHONENUMBER>";
		$xml .= "<TYPE>".$obj_Person_telephone->Type."</TYPE>";
		$xml .= "<PERSONID>".$obj_Person_telephone->PersonId."</PERSONID>";

	$xml .= "</PERSON_TELEPHONE>";
	
	return $xml;
}
	
function getPerson_telephoneByPhoneId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_telephone::getPerson_telephoneListByPhoneId($id);
	if($result->type ==1)
	{
	$arr_Person_telephoneList = $result->data;
		if(count($arr_Person_telephoneList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_telephoneList as $obj_Person_telephone)
			 {		 
				$main_result .=getPerson_telephoneXml($obj_Person_telephone);
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
