<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTalent.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageTalent.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addTalent',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TALENTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addTalent',                
    'rpc',                                
    'encoded',                            
    'add Talent'            
);

$server->register('updateTalent',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TALENTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateTalent',                
    'rpc',                                
    'encoded',                            
    'update Talent'            
);

$server->register('getTalentList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTalentList',                
    'rpc',                                
    'encoded',                            
    'add Talent'            
);


$server->register('getTalentByTalentId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTalentByTalentId',                
    'rpc',                                
    'encoded',                            
    'get Talent By TalentId'            
);


function addTalent($sessionkey, $appcode, $Talentdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Talent = new Talent();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TALENTID":{$obj_Talent->TalentId =  $child;break;};
		case "TALENTTYPE":{$obj_Talent->TalentType =  $child;break;};
		case "TALENTFIELD":{$obj_Talent->TalentField =  $child;break;};
		case "DESCRIPTION":{$obj_Talent->Description =  $child;break;};
		case "TALENTNAME":{$obj_Talent->TalentName =  $child;break;};

		}	
	}
	
    $obj_retResult_Talent = DAL_manageTalent::addTalent($obj_Talent);
    if ($obj_retResult_Talent->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTalentXml($obj_retResult_Talent->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateTalent($sessionkey, $appcode, $Talentdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Talent = new Talent();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TALENTID":{$obj_Talent->TalentId =  $child;break;};
		case "TALENTTYPE":{$obj_Talent->TalentType =  $child;break;};
		case "TALENTFIELD":{$obj_Talent->TalentField =  $child;break;};
		case "DESCRIPTION":{$obj_Talent->Description =  $child;break;};
		case "TALENTNAME":{$obj_Talent->TalentName =  $child;break;};

		}	
	}
	
    $obj_retResult_Talent = DAL_manageTalent::updateTalent($obj_Talent);
    if ($obj_retResult_Talent->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTalentXml($obj_retResult_Talent->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getTalentList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageTalent::getTalentList();
	if($result->type ==1)
	{
	$arr_TalentList = $result->data;
		if(count($arr_TalentList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<TALENTLIST>";
			 foreach($arr_TalentList as $obj_Talent)
			 {		 
				$main_result .=getTalentXml($obj_Talent);
			 }
			$main_result .= "</TALENTLIST>";

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

function getTalentXml($obj_Talent)
{
	$xml  = "<TALENT>";	
		$xml .= "<TALENTID>".$obj_Talent->TalentId."</TALENTID>";
		$xml .= "<TALENTTYPE>".$obj_Talent->TalentType."</TALENTTYPE>";
		$xml .= "<TALENTFIELD>".$obj_Talent->TalentField."</TALENTFIELD>";
		$xml .= "<DESCRIPTION>".$obj_Talent->Description."</DESCRIPTION>";
		$xml .= "<TALENTNAME>".$obj_Talent->TalentName."</TALENTNAME>";

	$xml .= "</TALENT>";
	
	return $xml;
}
	
function getTalentByTalentId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageTalent::getTalentListByTalentId($id);
	if($result->type ==1)
	{
	$arr_TalentList = $result->data;
		if(count($arr_TalentList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_TalentList as $obj_Talent)
			 {		 
				$main_result .=getTalentXml($obj_Talent);
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
