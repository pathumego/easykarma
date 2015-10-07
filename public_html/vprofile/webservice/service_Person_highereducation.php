<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_highereducation.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_highereducation.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_highereducation',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_HIGHEREDUCATIONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_highereducation',                
    'rpc',                                
    'encoded',                            
    'add Person_highereducation'            
);

$server->register('updatePerson_highereducation',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_HIGHEREDUCATIONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_highereducation',                
    'rpc',                                
    'encoded',                            
    'update Person_highereducation'            
);

$server->register('getPerson_highereducationList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_highereducationList',                
    'rpc',                                
    'encoded',                            
    'add Person_highereducation'            
);


$server->register('getPerson_highereducationByResultId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_highereducationByResultId',                
    'rpc',                                
    'encoded',                            
    'get Person_highereducation By ResultId'            
);


function addPerson_highereducation($sessionkey, $appcode, $Person_highereducationdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_highereducation = new Person_highereducation();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "RESULTID":{$obj_Person_highereducation->ResultId =  $child;break;};
		case "SUBJECTID":{$obj_Person_highereducation->SubjectId =  $child;break;};
		case "INSTITUTEID":{$obj_Person_highereducation->InstituteId =  $child;break;};
		case "GRADE":{$obj_Person_highereducation->Grade =  $child;break;};
		case "LANGUAGE":{$obj_Person_highereducation->Language =  $child;break;};
		case "DATETIME":{$obj_Person_highereducation->DateTime =  $child;break;};
		case "PERSONID":{$obj_Person_highereducation->PersonId =  $child;break;};
		case "LEVEL":{$obj_Person_highereducation->Level =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_highereducation = DAL_managePerson_highereducation::addPerson_highereducation($obj_Person_highereducation);
    if ($obj_retResult_Person_highereducation->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_highereducationXml($obj_retResult_Person_highereducation->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_highereducation($sessionkey, $appcode, $Person_highereducationdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_highereducation = new Person_highereducation();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "RESULTID":{$obj_Person_highereducation->ResultId =  $child;break;};
		case "SUBJECTID":{$obj_Person_highereducation->SubjectId =  $child;break;};
		case "INSTITUTEID":{$obj_Person_highereducation->InstituteId =  $child;break;};
		case "GRADE":{$obj_Person_highereducation->Grade =  $child;break;};
		case "LANGUAGE":{$obj_Person_highereducation->Language =  $child;break;};
		case "DATETIME":{$obj_Person_highereducation->DateTime =  $child;break;};
		case "PERSONID":{$obj_Person_highereducation->PersonId =  $child;break;};
		case "LEVEL":{$obj_Person_highereducation->Level =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_highereducation = DAL_managePerson_highereducation::updatePerson_highereducation($obj_Person_highereducation);
    if ($obj_retResult_Person_highereducation->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_highereducationXml($obj_retResult_Person_highereducation->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_highereducationList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_highereducation::getPerson_highereducationList();
	if($result->type ==1)
	{
	$arr_Person_highereducationList = $result->data;
		if(count($arr_Person_highereducationList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_HIGHEREDUCATIONLIST>";
			 foreach($arr_Person_highereducationList as $obj_Person_highereducation)
			 {		 
				$main_result .=getPerson_highereducationXml($obj_Person_highereducation);
			 }
			$main_result .= "</PERSON_HIGHEREDUCATIONLIST>";

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

function getPerson_highereducationXml($obj_Person_highereducation)
{
	$xml  = "<PERSON_HIGHEREDUCATION>";	
		$xml .= "<RESULTID>".$obj_Person_highereducation->ResultId."</RESULTID>";
		$xml .= "<SUBJECTID>".$obj_Person_highereducation->SubjectId."</SUBJECTID>";
		$xml .= "<INSTITUTEID>".$obj_Person_highereducation->InstituteId."</INSTITUTEID>";
		$xml .= "<GRADE>".$obj_Person_highereducation->Grade."</GRADE>";
		$xml .= "<LANGUAGE>".$obj_Person_highereducation->Language."</LANGUAGE>";
		$xml .= "<DATETIME>".$obj_Person_highereducation->DateTime."</DATETIME>";
		$xml .= "<PERSONID>".$obj_Person_highereducation->PersonId."</PERSONID>";
		$xml .= "<LEVEL>".$obj_Person_highereducation->Level."</LEVEL>";

	$xml .= "</PERSON_HIGHEREDUCATION>";
	
	return $xml;
}
	
function getPerson_highereducationByResultId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_highereducation::getPerson_highereducationListByResultId($id);
	if($result->type ==1)
	{
	$arr_Person_highereducationList = $result->data;
		if(count($arr_Person_highereducationList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_highereducationList as $obj_Person_highereducation)
			 {		 
				$main_result .=getPerson_highereducationXml($obj_Person_highereducation);
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
