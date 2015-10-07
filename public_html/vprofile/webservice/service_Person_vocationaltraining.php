<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_vocationaltraining.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_vocationaltraining.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_vocationaltraining',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_VOCATIONALTRAININGDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_vocationaltraining',                
    'rpc',                                
    'encoded',                            
    'add Person_vocationaltraining'            
);

$server->register('updatePerson_vocationaltraining',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_VOCATIONALTRAININGDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_vocationaltraining',                
    'rpc',                                
    'encoded',                            
    'update Person_vocationaltraining'            
);

$server->register('getPerson_vocationaltrainingList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_vocationaltrainingList',                
    'rpc',                                
    'encoded',                            
    'add Person_vocationaltraining'            
);


$server->register('getPerson_vocationaltrainingByVocationalTrainId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_vocationaltrainingByVocationalTrainId',                
    'rpc',                                
    'encoded',                            
    'get Person_vocationaltraining By VocationalTrainId'            
);


function addPerson_vocationaltraining($sessionkey, $appcode, $Person_vocationaltrainingdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_vocationaltraining = new Person_vocationaltraining();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "VOCATIONALTRAINID":{$obj_Person_vocationaltraining->VocationalTrainId =  $child;break;};
		case "FIELDNAME":{$obj_Person_vocationaltraining->FieldName =  $child;break;};
		case "COURSENAME":{$obj_Person_vocationaltraining->CourseName =  $child;break;};
		case "INSTITUTEID":{$obj_Person_vocationaltraining->InstituteId =  $child;break;};
		case "STARTDATE":{$obj_Person_vocationaltraining->StartDate =  $child;break;};
		case "ENDDATE":{$obj_Person_vocationaltraining->EndDate =  $child;break;};
		case "CERTIFICATETYPE":{$obj_Person_vocationaltraining->CertificateType =  $child;break;};
		case "PERSONID":{$obj_Person_vocationaltraining->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_vocationaltraining = DAL_managePerson_vocationaltraining::addPerson_vocationaltraining($obj_Person_vocationaltraining);
    if ($obj_retResult_Person_vocationaltraining->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_vocationaltrainingXml($obj_retResult_Person_vocationaltraining->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_vocationaltraining($sessionkey, $appcode, $Person_vocationaltrainingdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_vocationaltraining = new Person_vocationaltraining();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "VOCATIONALTRAINID":{$obj_Person_vocationaltraining->VocationalTrainId =  $child;break;};
		case "FIELDNAME":{$obj_Person_vocationaltraining->FieldName =  $child;break;};
		case "COURSENAME":{$obj_Person_vocationaltraining->CourseName =  $child;break;};
		case "INSTITUTEID":{$obj_Person_vocationaltraining->InstituteId =  $child;break;};
		case "STARTDATE":{$obj_Person_vocationaltraining->StartDate =  $child;break;};
		case "ENDDATE":{$obj_Person_vocationaltraining->EndDate =  $child;break;};
		case "CERTIFICATETYPE":{$obj_Person_vocationaltraining->CertificateType =  $child;break;};
		case "PERSONID":{$obj_Person_vocationaltraining->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_vocationaltraining = DAL_managePerson_vocationaltraining::updatePerson_vocationaltraining($obj_Person_vocationaltraining);
    if ($obj_retResult_Person_vocationaltraining->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_vocationaltrainingXml($obj_retResult_Person_vocationaltraining->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_vocationaltrainingList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_vocationaltraining::getPerson_vocationaltrainingList();
	if($result->type ==1)
	{
	$arr_Person_vocationaltrainingList = $result->data;
		if(count($arr_Person_vocationaltrainingList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_VOCATIONALTRAININGLIST>";
			 foreach($arr_Person_vocationaltrainingList as $obj_Person_vocationaltraining)
			 {		 
				$main_result .=getPerson_vocationaltrainingXml($obj_Person_vocationaltraining);
			 }
			$main_result .= "</PERSON_VOCATIONALTRAININGLIST>";

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

function getPerson_vocationaltrainingXml($obj_Person_vocationaltraining)
{
	$xml  = "<PERSON_VOCATIONALTRAINING>";	
		$xml .= "<VOCATIONALTRAINID>".$obj_Person_vocationaltraining->VocationalTrainId."</VOCATIONALTRAINID>";
		$xml .= "<FIELDNAME>".$obj_Person_vocationaltraining->FieldName."</FIELDNAME>";
		$xml .= "<COURSENAME>".$obj_Person_vocationaltraining->CourseName."</COURSENAME>";
		$xml .= "<INSTITUTEID>".$obj_Person_vocationaltraining->InstituteId."</INSTITUTEID>";
		$xml .= "<STARTDATE>".$obj_Person_vocationaltraining->StartDate."</STARTDATE>";
		$xml .= "<ENDDATE>".$obj_Person_vocationaltraining->EndDate."</ENDDATE>";
		$xml .= "<CERTIFICATETYPE>".$obj_Person_vocationaltraining->CertificateType."</CERTIFICATETYPE>";
		$xml .= "<PERSONID>".$obj_Person_vocationaltraining->PersonId."</PERSONID>";

	$xml .= "</PERSON_VOCATIONALTRAINING>";
	
	return $xml;
}
	
function getPerson_vocationaltrainingByVocationalTrainId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_vocationaltraining::getPerson_vocationaltrainingListByVocationalTrainId($id);
	if($result->type ==1)
	{
	$arr_Person_vocationaltrainingList = $result->data;
		if(count($arr_Person_vocationaltrainingList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_vocationaltrainingList as $obj_Person_vocationaltraining)
			 {		 
				$main_result .=getPerson_vocationaltrainingXml($obj_Person_vocationaltraining);
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
