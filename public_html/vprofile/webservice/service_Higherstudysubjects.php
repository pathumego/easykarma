<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageHigherstudysubjects.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageHigherstudysubjects.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addHigherstudysubjects',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','HIGHERSTUDYSUBJECTSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addHigherstudysubjects',                
    'rpc',                                
    'encoded',                            
    'add Higherstudysubjects'            
);

$server->register('updateHigherstudysubjects',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','HIGHERSTUDYSUBJECTSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateHigherstudysubjects',                
    'rpc',                                
    'encoded',                            
    'update Higherstudysubjects'            
);

$server->register('getHigherstudysubjectsList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getHigherstudysubjectsList',                
    'rpc',                                
    'encoded',                            
    'add Higherstudysubjects'            
);


$server->register('getHigherstudysubjectsBySubjectId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getHigherstudysubjectsBySubjectId',                
    'rpc',                                
    'encoded',                            
    'get Higherstudysubjects By SubjectId'            
);


function addHigherstudysubjects($sessionkey, $appcode, $Higherstudysubjectsdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Higherstudysubjects = new Higherstudysubjects();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SUBJECTID":{$obj_Higherstudysubjects->SubjectId =  $child;break;};
		case "SUBJECTNAME":{$obj_Higherstudysubjects->SubjectName =  $child;break;};
		case "SUBJECTNUMBER":{$obj_Higherstudysubjects->SubjectNumber =  $child;break;};
		case "SUBJECTFIELD":{$obj_Higherstudysubjects->SubjectField =  $child;break;};
		case "LEVEL":{$obj_Higherstudysubjects->Level =  $child;break;};

		}	
	}
	
    $obj_retResult_Higherstudysubjects = DAL_manageHigherstudysubjects::addHigherstudysubjects($obj_Higherstudysubjects);
    if ($obj_retResult_Higherstudysubjects->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getHigherstudysubjectsXml($obj_retResult_Higherstudysubjects->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateHigherstudysubjects($sessionkey, $appcode, $Higherstudysubjectsdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Higherstudysubjects = new Higherstudysubjects();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SUBJECTID":{$obj_Higherstudysubjects->SubjectId =  $child;break;};
		case "SUBJECTNAME":{$obj_Higherstudysubjects->SubjectName =  $child;break;};
		case "SUBJECTNUMBER":{$obj_Higherstudysubjects->SubjectNumber =  $child;break;};
		case "SUBJECTFIELD":{$obj_Higherstudysubjects->SubjectField =  $child;break;};
		case "LEVEL":{$obj_Higherstudysubjects->Level =  $child;break;};

		}	
	}
	
    $obj_retResult_Higherstudysubjects = DAL_manageHigherstudysubjects::updateHigherstudysubjects($obj_Higherstudysubjects);
    if ($obj_retResult_Higherstudysubjects->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getHigherstudysubjectsXml($obj_retResult_Higherstudysubjects->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getHigherstudysubjectsList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageHigherstudysubjects::getHigherstudysubjectsList();
	if($result->type ==1)
	{
	$arr_HigherstudysubjectsList = $result->data;
		if(count($arr_HigherstudysubjectsList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<HIGHERSTUDYSUBJECTSLIST>";
			 foreach($arr_HigherstudysubjectsList as $obj_Higherstudysubjects)
			 {		 
				$main_result .=getHigherstudysubjectsXml($obj_Higherstudysubjects);
			 }
			$main_result .= "</HIGHERSTUDYSUBJECTSLIST>";

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

function getHigherstudysubjectsXml($obj_Higherstudysubjects)
{
	$xml  = "<HIGHERSTUDYSUBJECTS>";	
		$xml .= "<SUBJECTID>".$obj_Higherstudysubjects->SubjectId."</SUBJECTID>";
		$xml .= "<SUBJECTNAME>".$obj_Higherstudysubjects->SubjectName."</SUBJECTNAME>";
		$xml .= "<SUBJECTNUMBER>".$obj_Higherstudysubjects->SubjectNumber."</SUBJECTNUMBER>";
		$xml .= "<SUBJECTFIELD>".$obj_Higherstudysubjects->SubjectField."</SUBJECTFIELD>";
		$xml .= "<LEVEL>".$obj_Higherstudysubjects->Level."</LEVEL>";

	$xml .= "</HIGHERSTUDYSUBJECTS>";
	
	return $xml;
}
	
function getHigherstudysubjectsBySubjectId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageHigherstudysubjects::getHigherstudysubjectsListBySubjectId($id);
	if($result->type ==1)
	{
	$arr_HigherstudysubjectsList = $result->data;
		if(count($arr_HigherstudysubjectsList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_HigherstudysubjectsList as $obj_Higherstudysubjects)
			 {		 
				$main_result .=getHigherstudysubjectsXml($obj_Higherstudysubjects);
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
