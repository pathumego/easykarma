<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTmt_degrees.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageTmt_degrees.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addTmt_degrees',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TMT_DEGREESDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addTmt_degrees',                
    'rpc',                                
    'encoded',                            
    'add Tmt_degrees'            
);

$server->register('updateTmt_degrees',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TMT_DEGREESDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateTmt_degrees',                
    'rpc',                                
    'encoded',                            
    'update Tmt_degrees'            
);

$server->register('getTmt_degreesList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTmt_degreesList',                
    'rpc',                                
    'encoded',                            
    'add Tmt_degrees'            
);


$server->register('getTmt_degreesBy',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTmt_degreesBy',                
    'rpc',                                
    'encoded',                            
    'get Tmt_degrees By '            
);


function addTmt_degrees($sessionkey, $appcode, $Tmt_degreesdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Tmt_degrees = new Tmt_degrees();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "COL1":{$obj_Tmt_degrees->col1 =  $child;break;};
		case "COL2":{$obj_Tmt_degrees->col2 =  $child;break;};

		}	
	}
	
    $obj_retResult_Tmt_degrees = DAL_manageTmt_degrees::addTmt_degrees($obj_Tmt_degrees);
    if ($obj_retResult_Tmt_degrees->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTmt_degreesXml($obj_retResult_Tmt_degrees->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateTmt_degrees($sessionkey, $appcode, $Tmt_degreesdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Tmt_degrees = new Tmt_degrees();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "COL1":{$obj_Tmt_degrees->col1 =  $child;break;};
		case "COL2":{$obj_Tmt_degrees->col2 =  $child;break;};

		}	
	}
	
    $obj_retResult_Tmt_degrees = DAL_manageTmt_degrees::updateTmt_degrees($obj_Tmt_degrees);
    if ($obj_retResult_Tmt_degrees->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTmt_degreesXml($obj_retResult_Tmt_degrees->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getTmt_degreesList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageTmt_degrees::getTmt_degreesList();
	if($result->type ==1)
	{
	$arr_Tmt_degreesList = $result->data;
		if(count($arr_Tmt_degreesList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<TMT_DEGREESLIST>";
			 foreach($arr_Tmt_degreesList as $obj_Tmt_degrees)
			 {		 
				$main_result .=getTmt_degreesXml($obj_Tmt_degrees);
			 }
			$main_result .= "</TMT_DEGREESLIST>";

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

function getTmt_degreesXml($obj_Tmt_degrees)
{
	$xml  = "<TMT_DEGREES>";	
		$xml .= "<COL1>".$obj_Tmt_degrees->col1."</COL1>";
		$xml .= "<COL2>".$obj_Tmt_degrees->col2."</COL2>";

	$xml .= "</TMT_DEGREES>";
	
	return $xml;
}
	
function getTmt_degreesBy($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageTmt_degrees::getTmt_degreesListBy($id);
	if($result->type ==1)
	{
	$arr_Tmt_degreesList = $result->data;
		if(count($arr_Tmt_degreesList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Tmt_degreesList as $obj_Tmt_degrees)
			 {		 
				$main_result .=getTmt_degreesXml($obj_Tmt_degrees);
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
