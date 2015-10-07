<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_alresult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_alresult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_alresult',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_ALRESULTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_alresult',                
    'rpc',                                
    'encoded',                            
    'add Person_alresult'            
);

$server->register('updatePerson_alresult',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_ALRESULTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_alresult',                
    'rpc',                                
    'encoded',                            
    'update Person_alresult'            
);

$server->register('getPerson_alresultList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_alresultList',                
    'rpc',                                
    'encoded',                            
    'add Person_alresult'            
);


$server->register('getPerson_alresultByALResultId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_alresultByALResultId',                
    'rpc',                                
    'encoded',                            
    'get Person_alresult By ALResultId'            
);


function addPerson_alresult($sessionkey, $appcode, $Person_alresultdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_alresult = new Person_alresult();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ALRESULTID":{$obj_Person_alresult->ALResultId =  $child;break;};
		case "SUBJECTID":{$obj_Person_alresult->SubjectId =  $child;break;};
		case "SCHOOLID":{$obj_Person_alresult->SchoolId =  $child;break;};
		case "GRADE":{$obj_Person_alresult->Grade =  $child;break;};
		case "LANGUAGE":{$obj_Person_alresult->Language =  $child;break;};
		case "DATETIME":{$obj_Person_alresult->DateTime =  $child;break;};
		case "PERSONID":{$obj_Person_alresult->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_alresult = DAL_managePerson_alresult::addPerson_alresult($obj_Person_alresult);
    if ($obj_retResult_Person_alresult->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_alresultXml($obj_retResult_Person_alresult->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_alresult($sessionkey, $appcode, $Person_alresultdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_alresult = new Person_alresult();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "ALRESULTID":{$obj_Person_alresult->ALResultId =  $child;break;};
		case "SUBJECTID":{$obj_Person_alresult->SubjectId =  $child;break;};
		case "SCHOOLID":{$obj_Person_alresult->SchoolId =  $child;break;};
		case "GRADE":{$obj_Person_alresult->Grade =  $child;break;};
		case "LANGUAGE":{$obj_Person_alresult->Language =  $child;break;};
		case "DATETIME":{$obj_Person_alresult->DateTime =  $child;break;};
		case "PERSONID":{$obj_Person_alresult->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_alresult = DAL_managePerson_alresult::updatePerson_alresult($obj_Person_alresult);
    if ($obj_retResult_Person_alresult->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_alresultXml($obj_retResult_Person_alresult->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_alresultList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_alresult::getPerson_alresultList();
	if($result->type ==1)
	{
	$arr_Person_alresultList = $result->data;
		if(count($arr_Person_alresultList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_ALRESULTLIST>";
			 foreach($arr_Person_alresultList as $obj_Person_alresult)
			 {		 
				$main_result .=getPerson_alresultXml($obj_Person_alresult);
			 }
			$main_result .= "</PERSON_ALRESULTLIST>";

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

function getPerson_alresultXml($obj_Person_alresult)
{
	$xml  = "<PERSON_ALRESULT>";	
		$xml .= "<ALRESULTID>".$obj_Person_alresult->ALResultId."</ALRESULTID>";
		$xml .= "<SUBJECTID>".$obj_Person_alresult->SubjectId."</SUBJECTID>";
		$xml .= "<SCHOOLID>".$obj_Person_alresult->SchoolId."</SCHOOLID>";
		$xml .= "<GRADE>".$obj_Person_alresult->Grade."</GRADE>";
		$xml .= "<LANGUAGE>".$obj_Person_alresult->Language."</LANGUAGE>";
		$xml .= "<DATETIME>".$obj_Person_alresult->DateTime."</DATETIME>";
		$xml .= "<PERSONID>".$obj_Person_alresult->PersonId."</PERSONID>";

	$xml .= "</PERSON_ALRESULT>";
	
	return $xml;
}
	
function getPerson_alresultByALResultId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_alresult::getPerson_alresultListByALResultId($id);
	if($result->type ==1)
	{
	$arr_Person_alresultList = $result->data;
		if(count($arr_Person_alresultList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_alresultList as $obj_Person_alresult)
			 {		 
				$main_result .=getPerson_alresultXml($obj_Person_alresult);
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
