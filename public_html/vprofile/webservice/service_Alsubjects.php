<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageAlsubjects.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageAlsubjects.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addAlsubjects',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ALSUBJECTSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addAlsubjects',                
    'rpc',                                
    'encoded',                            
    'add Alsubjects'            
);

$server->register('updateAlsubjects',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ALSUBJECTSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateAlsubjects',                
    'rpc',                                
    'encoded',                            
    'update Alsubjects'            
);

$server->register('getAlsubjectsList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getAlsubjectsList',                
    'rpc',                                
    'encoded',                            
    'add Alsubjects'            
);


$server->register('getAlsubjectsBySubjectId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getAlsubjectsBySubjectId',                
    'rpc',                                
    'encoded',                            
    'get Alsubjects By SubjectId'            
);


function addAlsubjects($sessionkey, $appcode, $Alsubjectsdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Alsubjects = new Alsubjects();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SUBJECTID":{$obj_Alsubjects->SubjectId =  $child;break;};
		case "SUBJECTNAME":{$obj_Alsubjects->SubjectName =  $child;break;};
		case "SUBJECTNUMBER":{$obj_Alsubjects->SubjectNumber =  $child;break;};

		}	
	}
	
    $obj_retResult_Alsubjects = DAL_manageAlsubjects::addAlsubjects($obj_Alsubjects);
    if ($obj_retResult_Alsubjects->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getAlsubjectsXml($obj_retResult_Alsubjects->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateAlsubjects($sessionkey, $appcode, $Alsubjectsdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Alsubjects = new Alsubjects();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SUBJECTID":{$obj_Alsubjects->SubjectId =  $child;break;};
		case "SUBJECTNAME":{$obj_Alsubjects->SubjectName =  $child;break;};
		case "SUBJECTNUMBER":{$obj_Alsubjects->SubjectNumber =  $child;break;};

		}	
	}
	
    $obj_retResult_Alsubjects = DAL_manageAlsubjects::updateAlsubjects($obj_Alsubjects);
    if ($obj_retResult_Alsubjects->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getAlsubjectsXml($obj_retResult_Alsubjects->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getAlsubjectsList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageAlsubjects::getAlsubjectsList();
	if($result->type ==1)
	{
	$arr_AlsubjectsList = $result->data;
		if(count($arr_AlsubjectsList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<ALSUBJECTSLIST>";
			 foreach($arr_AlsubjectsList as $obj_Alsubjects)
			 {		 
				$main_result .=getAlsubjectsXml($obj_Alsubjects);
			 }
			$main_result .= "</ALSUBJECTSLIST>";

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

function getAlsubjectsXml($obj_Alsubjects)
{
	$xml  = "<ALSUBJECTS>";	
		$xml .= "<SUBJECTID>".$obj_Alsubjects->SubjectId."</SUBJECTID>";
		$xml .= "<SUBJECTNAME>".$obj_Alsubjects->SubjectName."</SUBJECTNAME>";
		$xml .= "<SUBJECTNUMBER>".$obj_Alsubjects->SubjectNumber."</SUBJECTNUMBER>";

	$xml .= "</ALSUBJECTS>";
	
	return $xml;
}
	
function getAlsubjectsBySubjectId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageAlsubjects::getAlsubjectsListBySubjectId($id);
	if($result->type ==1)
	{
	$arr_AlsubjectsList = $result->data;
		if(count($arr_AlsubjectsList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_AlsubjectsList as $obj_Alsubjects)
			 {		 
				$main_result .=getAlsubjectsXml($obj_Alsubjects);
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
