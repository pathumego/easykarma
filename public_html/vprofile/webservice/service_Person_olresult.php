<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_olresult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_olresult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_olresult',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_OLRESULTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_olresult',                
    'rpc',                                
    'encoded',                            
    'add Person_olresult'            
);

$server->register('updatePerson_olresult',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_OLRESULTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_olresult',                
    'rpc',                                
    'encoded',                            
    'update Person_olresult'            
);

$server->register('getPerson_olresultList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_olresultList',                
    'rpc',                                
    'encoded',                            
    'add Person_olresult'            
);


$server->register('getPerson_olresultByOLResultId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_olresultByOLResultId',                
    'rpc',                                
    'encoded',                            
    'get Person_olresult By OLResultId'            
);


function addPerson_olresult($sessionkey, $appcode, $Person_olresultdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_olresult = new Person_olresult();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "OLRESULTID":{$obj_Person_olresult->OLResultId =  $child;break;};
		case "SUBJECTID":{$obj_Person_olresult->SubjectId =  $child;break;};
		case "SCHOOLID":{$obj_Person_olresult->SchoolId =  $child;break;};
		case "GRADE":{$obj_Person_olresult->Grade =  $child;break;};
		case "LANGUAGE":{$obj_Person_olresult->Language =  $child;break;};
		case "DATETIME":{$obj_Person_olresult->DateTime =  $child;break;};
		case "PERSONID":{$obj_Person_olresult->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_olresult = DAL_managePerson_olresult::addPerson_olresult($obj_Person_olresult);
    if ($obj_retResult_Person_olresult->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_olresultXml($obj_retResult_Person_olresult->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_olresult($sessionkey, $appcode, $Person_olresultdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_olresult = new Person_olresult();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "OLRESULTID":{$obj_Person_olresult->OLResultId =  $child;break;};
		case "SUBJECTID":{$obj_Person_olresult->SubjectId =  $child;break;};
		case "SCHOOLID":{$obj_Person_olresult->SchoolId =  $child;break;};
		case "GRADE":{$obj_Person_olresult->Grade =  $child;break;};
		case "LANGUAGE":{$obj_Person_olresult->Language =  $child;break;};
		case "DATETIME":{$obj_Person_olresult->DateTime =  $child;break;};
		case "PERSONID":{$obj_Person_olresult->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_olresult = DAL_managePerson_olresult::updatePerson_olresult($obj_Person_olresult);
    if ($obj_retResult_Person_olresult->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_olresultXml($obj_retResult_Person_olresult->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_olresultList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_olresult::getPerson_olresultList();
	if($result->type ==1)
	{
	$arr_Person_olresultList = $result->data;
		if(count($arr_Person_olresultList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_OLRESULTLIST>";
			 foreach($arr_Person_olresultList as $obj_Person_olresult)
			 {		 
				$main_result .=getPerson_olresultXml($obj_Person_olresult);
			 }
			$main_result .= "</PERSON_OLRESULTLIST>";

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

function getPerson_olresultXml($obj_Person_olresult)
{
	$xml  = "<PERSON_OLRESULT>";	
		$xml .= "<OLRESULTID>".$obj_Person_olresult->OLResultId."</OLRESULTID>";
		$xml .= "<SUBJECTID>".$obj_Person_olresult->SubjectId."</SUBJECTID>";
		$xml .= "<SCHOOLID>".$obj_Person_olresult->SchoolId."</SCHOOLID>";
		$xml .= "<GRADE>".$obj_Person_olresult->Grade."</GRADE>";
		$xml .= "<LANGUAGE>".$obj_Person_olresult->Language."</LANGUAGE>";
		$xml .= "<DATETIME>".$obj_Person_olresult->DateTime."</DATETIME>";
		$xml .= "<PERSONID>".$obj_Person_olresult->PersonId."</PERSONID>";

	$xml .= "</PERSON_OLRESULT>";
	
	return $xml;
}
	
function getPerson_olresultByOLResultId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_olresult::getPerson_olresultListByOLResultId($id);
	if($result->type ==1)
	{
	$arr_Person_olresultList = $result->data;
		if(count($arr_Person_olresultList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_olresultList as $obj_Person_olresult)
			 {		 
				$main_result .=getPerson_olresultXml($obj_Person_olresult);
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
