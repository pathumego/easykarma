<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_talent.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_talent.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_talent',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_TALENTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_talent',                
    'rpc',                                
    'encoded',                            
    'add Person_talent'            
);

$server->register('updatePerson_talent',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_TALENTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_talent',                
    'rpc',                                
    'encoded',                            
    'update Person_talent'            
);

$server->register('getPerson_talentList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_talentList',                
    'rpc',                                
    'encoded',                            
    'add Person_talent'            
);


$server->register('getPerson_talentByTblId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_talentByTblId',                
    'rpc',                                
    'encoded',                            
    'get Person_talent By TblId'            
);


function addPerson_talent($sessionkey, $appcode, $Person_talentdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_talent = new Person_talent();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Person_talent->TblId =  $child;break;};
		case "PERSONID":{$obj_Person_talent->PersonId =  $child;break;};
		case "TALENTID":{$obj_Person_talent->TalentId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_talent = DAL_managePerson_talent::addPerson_talent($obj_Person_talent);
    if ($obj_retResult_Person_talent->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_talentXml($obj_retResult_Person_talent->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_talent($sessionkey, $appcode, $Person_talentdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_talent = new Person_talent();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Person_talent->TblId =  $child;break;};
		case "PERSONID":{$obj_Person_talent->PersonId =  $child;break;};
		case "TALENTID":{$obj_Person_talent->TalentId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_talent = DAL_managePerson_talent::updatePerson_talent($obj_Person_talent);
    if ($obj_retResult_Person_talent->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_talentXml($obj_retResult_Person_talent->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_talentList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_talent::getPerson_talentList();
	if($result->type ==1)
	{
	$arr_Person_talentList = $result->data;
		if(count($arr_Person_talentList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_TALENTLIST>";
			 foreach($arr_Person_talentList as $obj_Person_talent)
			 {		 
				$main_result .=getPerson_talentXml($obj_Person_talent);
			 }
			$main_result .= "</PERSON_TALENTLIST>";

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

function getPerson_talentXml($obj_Person_talent)
{
	$xml  = "<PERSON_TALENT>";	
		$xml .= "<TBLID>".$obj_Person_talent->TblId."</TBLID>";
		$xml .= "<PERSONID>".$obj_Person_talent->PersonId."</PERSONID>";
		$xml .= "<TALENTID>".$obj_Person_talent->TalentId."</TALENTID>";

	$xml .= "</PERSON_TALENT>";
	
	return $xml;
}
	
function getPerson_talentByTblId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_talent::getPerson_talentListByTblId($id);
	if($result->type ==1)
	{
	$arr_Person_talentList = $result->data;
		if(count($arr_Person_talentList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_talentList as $obj_Person_talent)
			 {		 
				$main_result .=getPerson_talentXml($obj_Person_talent);
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
