<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_workingexperiance.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson_workingexperiance.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson_workingexperiance',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_WORKINGEXPERIANCEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson_workingexperiance',                
    'rpc',                                
    'encoded',                            
    'add Person_workingexperiance'            
);

$server->register('updatePerson_workingexperiance',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSON_WORKINGEXPERIANCEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson_workingexperiance',                
    'rpc',                                
    'encoded',                            
    'update Person_workingexperiance'            
);

$server->register('getPerson_workingexperianceList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_workingexperianceList',                
    'rpc',                                
    'encoded',                            
    'add Person_workingexperiance'            
);


$server->register('getPerson_workingexperianceByWorkExpId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPerson_workingexperianceByWorkExpId',                
    'rpc',                                
    'encoded',                            
    'get Person_workingexperiance By WorkExpId'            
);


function addPerson_workingexperiance($sessionkey, $appcode, $Person_workingexperiancedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person_workingexperiance = new Person_workingexperiance();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "WORKEXPID":{$obj_Person_workingexperiance->WorkExpId =  $child;break;};
		case "COMPANYID":{$obj_Person_workingexperiance->CompanyId =  $child;break;};
		case "STARTDATE":{$obj_Person_workingexperiance->StartDate =  $child;break;};
		case "ENDDATE":{$obj_Person_workingexperiance->EndDate =  $child;break;};
		case "POSITION":{$obj_Person_workingexperiance->Position =  $child;break;};
		case "PERSONID":{$obj_Person_workingexperiance->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_workingexperiance = DAL_managePerson_workingexperiance::addPerson_workingexperiance($obj_Person_workingexperiance);
    if ($obj_retResult_Person_workingexperiance->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_workingexperianceXml($obj_retResult_Person_workingexperiance->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson_workingexperiance($sessionkey, $appcode, $Person_workingexperiancedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person_workingexperiance = new Person_workingexperiance();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "WORKEXPID":{$obj_Person_workingexperiance->WorkExpId =  $child;break;};
		case "COMPANYID":{$obj_Person_workingexperiance->CompanyId =  $child;break;};
		case "STARTDATE":{$obj_Person_workingexperiance->StartDate =  $child;break;};
		case "ENDDATE":{$obj_Person_workingexperiance->EndDate =  $child;break;};
		case "POSITION":{$obj_Person_workingexperiance->Position =  $child;break;};
		case "PERSONID":{$obj_Person_workingexperiance->PersonId =  $child;break;};

		}	
	}
	
    $obj_retResult_Person_workingexperiance = DAL_managePerson_workingexperiance::updatePerson_workingexperiance($obj_Person_workingexperiance);
    if ($obj_retResult_Person_workingexperiance->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPerson_workingexperianceXml($obj_retResult_Person_workingexperiance->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPerson_workingexperianceList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson_workingexperiance::getPerson_workingexperianceList();
	if($result->type ==1)
	{
	$arr_Person_workingexperianceList = $result->data;
		if(count($arr_Person_workingexperianceList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSON_WORKINGEXPERIANCELIST>";
			 foreach($arr_Person_workingexperianceList as $obj_Person_workingexperiance)
			 {		 
				$main_result .=getPerson_workingexperianceXml($obj_Person_workingexperiance);
			 }
			$main_result .= "</PERSON_WORKINGEXPERIANCELIST>";

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

function getPerson_workingexperianceXml($obj_Person_workingexperiance)
{
	$xml  = "<PERSON_WORKINGEXPERIANCE>";	
		$xml .= "<WORKEXPID>".$obj_Person_workingexperiance->WorkExpId."</WORKEXPID>";
		$xml .= "<COMPANYID>".$obj_Person_workingexperiance->CompanyId."</COMPANYID>";
		$xml .= "<STARTDATE>".$obj_Person_workingexperiance->StartDate."</STARTDATE>";
		$xml .= "<ENDDATE>".$obj_Person_workingexperiance->EndDate."</ENDDATE>";
		$xml .= "<POSITION>".$obj_Person_workingexperiance->Position."</POSITION>";
		$xml .= "<PERSONID>".$obj_Person_workingexperiance->PersonId."</PERSONID>";

	$xml .= "</PERSON_WORKINGEXPERIANCE>";
	
	return $xml;
}
	
function getPerson_workingexperianceByWorkExpId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson_workingexperiance::getPerson_workingexperianceListByWorkExpId($id);
	if($result->type ==1)
	{
	$arr_Person_workingexperianceList = $result->data;
		if(count($arr_Person_workingexperianceList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Person_workingexperianceList as $obj_Person_workingexperiance)
			 {		 
				$main_result .=getPerson_workingexperianceXml($obj_Person_workingexperiance);
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
