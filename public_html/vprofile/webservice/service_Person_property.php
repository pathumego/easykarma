<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_property.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_property.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_property',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_PROPERTYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_property',                
    'rpc',                                
    'encoded',                            
    'add Person_property'            
);

$server->register('updatePerson_property',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_PROPERTYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_property',                
    'rpc',                                
    'encoded',                            
    'update Person_property'            
);

$server->register('getPerson_propertyList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_propertyList',                
    'rpc',                                
    'encoded',                            
    'add Person_property'            
);


$server->register('getPerson_propertyByPropertyId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_propertyByPropertyId',                
    'rpc',                                
    'encoded',                            
    'get Person_property By PropertyId'            
);


function addPerson_property($sessionkey, $appcode, $Person_propertydata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_property = new Person_property();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PROPERTYID":{$obj_Person_property->PropertyId =  $child;break;};
		case "PROPERTYNAME":{$obj_Person_property->PropertyName =  $child;break;};
		case "PROPERTYTYPE":{$obj_Person_property->PropertyType =  $child;break;};
		case "ASSESSVALUE":{$obj_Person_property->AssessValue =  $child;break;};
		case "DESCRIPTION":{$obj_Person_property->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_property = DAL_managePerson_property::addPerson_property($obj_Person_property);
    if ($obj_retResult_Person_property->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_propertyXml($obj_retResult_Person_property->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_property($sessionkey, $appcode, $Person_propertydata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_property = new Person_property();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PROPERTYID":{$obj_Person_property->PropertyId =  $child;break;};
		case "PROPERTYNAME":{$obj_Person_property->PropertyName =  $child;break;};
		case "PROPERTYTYPE":{$obj_Person_property->PropertyType =  $child;break;};
		case "ASSESSVALUE":{$obj_Person_property->AssessValue =  $child;break;};
		case "DESCRIPTION":{$obj_Person_property->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_property = DAL_managePerson_property::updatePerson_property($obj_Person_property);
    if ($obj_retResult_Person_property->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_propertyXml($obj_retResult_Person_property->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_propertyList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_property::getPerson_propertyList();
	if($result->type ==1)
	{
	$arr_Person_propertyList = $result->data;
		if(count($arr_Person_propertyList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_PROPERTYLIST>";
			 foreach($arr_Person_propertyList as $obj_Person_property)
			 {		 
				$main_result .=getPerson_propertyXml($obj_Person_property);
			 }
			$main_result .= "</PERSON_PROPERTYLIST>";

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

function getPerson_propertyXml($obj_Person_property)
{
	$xml  = "<PERSON_PROPERTY>";	
		$xml .= "<PROPERTYID>".$obj_Person_property->PropertyId."</PROPERTYID>";
		$xml .= "<PROPERTYNAME>".$obj_Person_property->PropertyName."</PROPERTYNAME>";
		$xml .= "<PROPERTYTYPE>".$obj_Person_property->PropertyType."</PROPERTYTYPE>";
		$xml .= "<ASSESSVALUE>".$obj_Person_property->AssessValue."</ASSESSVALUE>";
		$xml .= "<DESCRIPTION>".$obj_Person_property->Description."</DESCRIPTION>";

	$xml .= "</PERSON_PROPERTY>";
	
	return $xml;
}
	
function getPerson_propertyByPropertyId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_property::getPerson_propertyListByPropertyId($id);
	if($result->type ==1)
	{
	$arr_Person_propertyList = $result->data;
		if(count($arr_Person_propertyList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_propertyList as $obj_Person_property)
			 {		 
				$main_result .=getPerson_propertyXml($obj_Person_property);
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
