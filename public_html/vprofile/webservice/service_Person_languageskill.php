<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_languageskill.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_languageskill.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_languageskill',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_LANGUAGESKILLDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_languageskill',                
    'rpc',                                
    'encoded',                            
    'add Person_languageskill'            
);

$server->register('updatePerson_languageskill',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_LANGUAGESKILLDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_languageskill',                
    'rpc',                                
    'encoded',                            
    'update Person_languageskill'            
);

$server->register('getPerson_languageskillList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_languageskillList',                
    'rpc',                                
    'encoded',                            
    'add Person_languageskill'            
);


$server->register('getPerson_languageskillByLangSkillId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_languageskillByLangSkillId',                
    'rpc',                                
    'encoded',                            
    'get Person_languageskill By LangSkillId'            
);


function addPerson_languageskill($sessionkey, $appcode, $Person_languageskilldata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_languageskill = new Person_languageskill();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "LANGSKILLID":{$obj_Person_languageskill->LangSkillId =  $child;break;};
		case "PERSONID":{$obj_Person_languageskill->PersonId =  $child;break;};
		case "LANGUAGE":{$obj_Person_languageskill->Language =  $child;break;};
		case "SKILLTYPE":{$obj_Person_languageskill->SkillType =  $child;break;};
		case "GRADE":{$obj_Person_languageskill->Grade =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_languageskill = DAL_managePerson_languageskill::addPerson_languageskill($obj_Person_languageskill);
    if ($obj_retResult_Person_languageskill->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_languageskillXml($obj_retResult_Person_languageskill->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_languageskill($sessionkey, $appcode, $Person_languageskilldata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_languageskill = new Person_languageskill();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "LANGSKILLID":{$obj_Person_languageskill->LangSkillId =  $child;break;};
		case "PERSONID":{$obj_Person_languageskill->PersonId =  $child;break;};
		case "LANGUAGE":{$obj_Person_languageskill->Language =  $child;break;};
		case "SKILLTYPE":{$obj_Person_languageskill->SkillType =  $child;break;};
		case "GRADE":{$obj_Person_languageskill->Grade =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_languageskill = DAL_managePerson_languageskill::updatePerson_languageskill($obj_Person_languageskill);
    if ($obj_retResult_Person_languageskill->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_languageskillXml($obj_retResult_Person_languageskill->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_languageskillList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_languageskill::getPerson_languageskillList();
	if($result->type ==1)
	{
	$arr_Person_languageskillList = $result->data;
		if(count($arr_Person_languageskillList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_LANGUAGESKILLLIST>";
			 foreach($arr_Person_languageskillList as $obj_Person_languageskill)
			 {		 
				$main_result .=getPerson_languageskillXml($obj_Person_languageskill);
			 }
			$main_result .= "</PERSON_LANGUAGESKILLLIST>";

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

function getPerson_languageskillXml($obj_Person_languageskill)
{
	$xml  = "<PERSON_LANGUAGESKILL>";	
		$xml .= "<LANGSKILLID>".$obj_Person_languageskill->LangSkillId."</LANGSKILLID>";
		$xml .= "<PERSONID>".$obj_Person_languageskill->PersonId."</PERSONID>";
		$xml .= "<LANGUAGE>".$obj_Person_languageskill->Language."</LANGUAGE>";
		$xml .= "<SKILLTYPE>".$obj_Person_languageskill->SkillType."</SKILLTYPE>";
		$xml .= "<GRADE>".$obj_Person_languageskill->Grade."</GRADE>";

	$xml .= "</PERSON_LANGUAGESKILL>";
	
	return $xml;
}
	
function getPerson_languageskillByLangSkillId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_languageskill::getPerson_languageskillListByLangSkillId($id);
	if($result->type ==1)
	{
	$arr_Person_languageskillList = $result->data;
		if(count($arr_Person_languageskillList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_languageskillList as $obj_Person_languageskill)
			 {		 
				$main_result .=getPerson_languageskillXml($obj_Person_languageskill);
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
