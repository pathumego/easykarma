<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_educationlevel.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_educationlevel.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_educationlevel',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_EDUCATIONLEVELDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_educationlevel',                
    'rpc',                                
    'encoded',                            
    'add Person_educationlevel'            
);

$server->register('updatePerson_educationlevel',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_EDUCATIONLEVELDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_educationlevel',                
    'rpc',                                
    'encoded',                            
    'update Person_educationlevel'            
);

$server->register('getPerson_educationlevelList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_educationlevelList',                
    'rpc',                                
    'encoded',                            
    'add Person_educationlevel'            
);


$server->register('getPerson_educationlevelByEducationLevelId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_educationlevelByEducationLevelId',                
    'rpc',                                
    'encoded',                            
    'get Person_educationlevel By EducationLevelId'            
);


function addPerson_educationlevel($sessionkey, $appcode, $Person_educationleveldata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_educationlevel = new Person_educationlevel();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "EDUCATIONLEVELID":{$obj_Person_educationlevel->EducationLevelId =  $child;break;};
		case "SCHOOLID":{$obj_Person_educationlevel->SchoolId =  $child;break;};
		case "STARTYEAR":{$obj_Person_educationlevel->StartYear =  $child;break;};
		case "STARTCLASS":{$obj_Person_educationlevel->StartClass =  $child;break;};
		case "ENDYEAR":{$obj_Person_educationlevel->EndYear =  $child;break;};
		case "ENDCLASS":{$obj_Person_educationlevel->EndClass =  $child;break;};
		case "PERSONID":{$obj_Person_educationlevel->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_educationlevel = DAL_managePerson_educationlevel::addPerson_educationlevel($obj_Person_educationlevel);
    if ($obj_retResult_Person_educationlevel->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_educationlevelXml($obj_retResult_Person_educationlevel->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_educationlevel($sessionkey, $appcode, $Person_educationleveldata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_educationlevel = new Person_educationlevel();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "EDUCATIONLEVELID":{$obj_Person_educationlevel->EducationLevelId =  $child;break;};
		case "SCHOOLID":{$obj_Person_educationlevel->SchoolId =  $child;break;};
		case "STARTYEAR":{$obj_Person_educationlevel->StartYear =  $child;break;};
		case "STARTCLASS":{$obj_Person_educationlevel->StartClass =  $child;break;};
		case "ENDYEAR":{$obj_Person_educationlevel->EndYear =  $child;break;};
		case "ENDCLASS":{$obj_Person_educationlevel->EndClass =  $child;break;};
		case "PERSONID":{$obj_Person_educationlevel->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_educationlevel = DAL_managePerson_educationlevel::updatePerson_educationlevel($obj_Person_educationlevel);
    if ($obj_retResult_Person_educationlevel->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_educationlevelXml($obj_retResult_Person_educationlevel->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_educationlevelList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_educationlevel::getPerson_educationlevelList();
	if($result->type ==1)
	{
	$arr_Person_educationlevelList = $result->data;
		if(count($arr_Person_educationlevelList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_EDUCATIONLEVELLIST>";
			 foreach($arr_Person_educationlevelList as $obj_Person_educationlevel)
			 {		 
				$main_result .=getPerson_educationlevelXml($obj_Person_educationlevel);
			 }
			$main_result .= "</PERSON_EDUCATIONLEVELLIST>";

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

function getPerson_educationlevelXml($obj_Person_educationlevel)
{
	$xml  = "<PERSON_EDUCATIONLEVEL>";	
		$xml .= "<EDUCATIONLEVELID>".$obj_Person_educationlevel->EducationLevelId."</EDUCATIONLEVELID>";
		$xml .= "<SCHOOLID>".$obj_Person_educationlevel->SchoolId."</SCHOOLID>";
		$xml .= "<STARTYEAR>".$obj_Person_educationlevel->StartYear."</STARTYEAR>";
		$xml .= "<STARTCLASS>".$obj_Person_educationlevel->StartClass."</STARTCLASS>";
		$xml .= "<ENDYEAR>".$obj_Person_educationlevel->EndYear."</ENDYEAR>";
		$xml .= "<ENDCLASS>".$obj_Person_educationlevel->EndClass."</ENDCLASS>";
		$xml .= "<PERSONID>".$obj_Person_educationlevel->PersonId."</PERSONID>";

	$xml .= "</PERSON_EDUCATIONLEVEL>";
	
	return $xml;
}
	
function getPerson_educationlevelByEducationLevelId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_educationlevel::getPerson_educationlevelListByEducationLevelId($id);
	if($result->type ==1)
	{
	$arr_Person_educationlevelList = $result->data;
		if(count($arr_Person_educationlevelList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_educationlevelList as $obj_Person_educationlevel)
			 {		 
				$main_result .=getPerson_educationlevelXml($obj_Person_educationlevel);
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
