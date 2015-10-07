<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTemp_alsubject.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageTemp_alsubject.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addTemp_alsubject',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TEMP_ALSUBJECTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addTemp_alsubject',                
    'rpc',                                
    'encoded',                            
    'add Temp_alsubject'            
);

$server->register('updateTemp_alsubject',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TEMP_ALSUBJECTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateTemp_alsubject',                
    'rpc',                                
    'encoded',                            
    'update Temp_alsubject'            
);

$server->register('getTemp_alsubjectList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTemp_alsubjectList',                
    'rpc',                                
    'encoded',                            
    'add Temp_alsubject'            
);


$server->register('getTemp_alsubjectBy',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTemp_alsubjectBy',                
    'rpc',                                
    'encoded',                            
    'get Temp_alsubject By '            
);


function addTemp_alsubject($sessionkey, $appcode, $Temp_alsubjectdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Temp_alsubject = new Temp_alsubject();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "COL1":{$obj_Temp_alsubject->col1 =  $child;break;};
		case "COL2":{$obj_Temp_alsubject->col2 =  $child;break;};

		}	
	}
	
    $obj_retResult_Temp_alsubject = DAL_manageTemp_alsubject::addTemp_alsubject($obj_Temp_alsubject);
    if ($obj_retResult_Temp_alsubject->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTemp_alsubjectXml($obj_retResult_Temp_alsubject->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateTemp_alsubject($sessionkey, $appcode, $Temp_alsubjectdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Temp_alsubject = new Temp_alsubject();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "COL1":{$obj_Temp_alsubject->col1 =  $child;break;};
		case "COL2":{$obj_Temp_alsubject->col2 =  $child;break;};

		}	
	}
	
    $obj_retResult_Temp_alsubject = DAL_manageTemp_alsubject::updateTemp_alsubject($obj_Temp_alsubject);
    if ($obj_retResult_Temp_alsubject->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTemp_alsubjectXml($obj_retResult_Temp_alsubject->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getTemp_alsubjectList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageTemp_alsubject::getTemp_alsubjectList();
	if($result->type ==1)
	{
	$arr_Temp_alsubjectList = $result->data;
		if(count($arr_Temp_alsubjectList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<TEMP_ALSUBJECTLIST>";
			 foreach($arr_Temp_alsubjectList as $obj_Temp_alsubject)
			 {		 
				$main_result .=getTemp_alsubjectXml($obj_Temp_alsubject);
			 }
			$main_result .= "</TEMP_ALSUBJECTLIST>";

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

function getTemp_alsubjectXml($obj_Temp_alsubject)
{
	$xml  = "<TEMP_ALSUBJECT>";	
		$xml .= "<COL1>".$obj_Temp_alsubject->col1."</COL1>";
		$xml .= "<COL2>".$obj_Temp_alsubject->col2."</COL2>";

	$xml .= "</TEMP_ALSUBJECT>";
	
	return $xml;
}
	
function getTemp_alsubjectBy($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageTemp_alsubject::getTemp_alsubjectListBy($id);
	if($result->type ==1)
	{
	$arr_Temp_alsubjectList = $result->data;
		if(count($arr_Temp_alsubjectList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Temp_alsubjectList as $obj_Temp_alsubject)
			 {		 
				$main_result .=getTemp_alsubjectXml($obj_Temp_alsubject);
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
