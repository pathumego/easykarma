<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageOlsubjects.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageOlsubjects.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addOlsubjects',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','OLSUBJECTSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addOlsubjects',                
    'rpc',                                
    'encoded',                            
    'add Olsubjects'            
);

$server->register('updateOlsubjects',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','OLSUBJECTSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateOlsubjects',                
    'rpc',                                
    'encoded',                            
    'update Olsubjects'            
);

$server->register('getOlsubjectsList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getOlsubjectsList',                
    'rpc',                                
    'encoded',                            
    'add Olsubjects'            
);


$server->register('getOlsubjectsBySubjectId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getOlsubjectsBySubjectId',                
    'rpc',                                
    'encoded',                            
    'get Olsubjects By SubjectId'            
);


function addOlsubjects($sessionkey, $appcode, $Olsubjectsdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Olsubjects = new Olsubjects();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SUBJECTID":{$obj_Olsubjects->SubjectId =  $child;break;};
		case "SUBJECTNAME":{$obj_Olsubjects->SubjectName =  $child;break;};
		case "SUBJECTNUMBER":{$obj_Olsubjects->SubjectNumber =  $child;break;};

		}	
	}
	
    $obj_retResult_Olsubjects = DAL_manageOlsubjects::addOlsubjects($obj_Olsubjects);
    if ($obj_retResult_Olsubjects->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getOlsubjectsXml($obj_retResult_Olsubjects->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateOlsubjects($sessionkey, $appcode, $Olsubjectsdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Olsubjects = new Olsubjects();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SUBJECTID":{$obj_Olsubjects->SubjectId =  $child;break;};
		case "SUBJECTNAME":{$obj_Olsubjects->SubjectName =  $child;break;};
		case "SUBJECTNUMBER":{$obj_Olsubjects->SubjectNumber =  $child;break;};

		}	
	}
	
    $obj_retResult_Olsubjects = DAL_manageOlsubjects::updateOlsubjects($obj_Olsubjects);
    if ($obj_retResult_Olsubjects->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getOlsubjectsXml($obj_retResult_Olsubjects->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getOlsubjectsList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageOlsubjects::getOlsubjectsList();
	if($result->type ==1)
	{
	$arr_OlsubjectsList = $result->data;
		if(count($arr_OlsubjectsList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<OLSUBJECTSLIST>";
			 foreach($arr_OlsubjectsList as $obj_Olsubjects)
			 {		 
				$main_result .=getOlsubjectsXml($obj_Olsubjects);
			 }
			$main_result .= "</OLSUBJECTSLIST>";

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

function getOlsubjectsXml($obj_Olsubjects)
{
	$xml  = "<OLSUBJECTS>";	
		$xml .= "<SUBJECTID>".$obj_Olsubjects->SubjectId."</SUBJECTID>";
		$xml .= "<SUBJECTNAME>".$obj_Olsubjects->SubjectName."</SUBJECTNAME>";
		$xml .= "<SUBJECTNUMBER>".$obj_Olsubjects->SubjectNumber."</SUBJECTNUMBER>";

	$xml .= "</OLSUBJECTS>";
	
	return $xml;
}
	
function getOlsubjectsBySubjectId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageOlsubjects::getOlsubjectsListBySubjectId($id);
	if($result->type ==1)
	{
	$arr_OlsubjectsList = $result->data;
		if(count($arr_OlsubjectsList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_OlsubjectsList as $obj_Olsubjects)
			 {		 
				$main_result .=getOlsubjectsXml($obj_Olsubjects);
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
