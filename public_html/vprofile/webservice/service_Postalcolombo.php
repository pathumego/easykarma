<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePostalcolombo.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePostalcolombo.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPostalcolombo',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','POSTALCOLOMBODATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPostalcolombo',                
    'rpc',                                
    'encoded',                            
    'add Postalcolombo'            
);

$server->register('updatePostalcolombo',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','POSTALCOLOMBODATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePostalcolombo',                
    'rpc',                                
    'encoded',                            
    'update Postalcolombo'            
);

$server->register('getPostalcolomboList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPostalcolomboList',                
    'rpc',                                
    'encoded',                            
    'add Postalcolombo'            
);


$server->register('getPostalcolomboBy',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPostalcolomboBy',                
    'rpc',                                
    'encoded',                            
    'get Postalcolombo By '            
);


function addPostalcolombo($sessionkey, $appcode, $Postalcolombodata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Postalcolombo = new Postalcolombo();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "COL1":{$obj_Postalcolombo->col1 =  $child;break;};
		case "COL2":{$obj_Postalcolombo->col2 =  $child;break;};
		case "COL3":{$obj_Postalcolombo->col3 =  $child;break;};

		}	
	}
	
    $obj_retResult_Postalcolombo = DAL_managePostalcolombo::addPostalcolombo($obj_Postalcolombo);
    if ($obj_retResult_Postalcolombo->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPostalcolomboXml($obj_retResult_Postalcolombo->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePostalcolombo($sessionkey, $appcode, $Postalcolombodata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Postalcolombo = new Postalcolombo();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "COL1":{$obj_Postalcolombo->col1 =  $child;break;};
		case "COL2":{$obj_Postalcolombo->col2 =  $child;break;};
		case "COL3":{$obj_Postalcolombo->col3 =  $child;break;};

		}	
	}
	
    $obj_retResult_Postalcolombo = DAL_managePostalcolombo::updatePostalcolombo($obj_Postalcolombo);
    if ($obj_retResult_Postalcolombo->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPostalcolomboXml($obj_retResult_Postalcolombo->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPostalcolomboList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePostalcolombo::getPostalcolomboList();
	if($result->type ==1)
	{
	$arr_PostalcolomboList = $result->data;
		if(count($arr_PostalcolomboList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<POSTALCOLOMBOLIST>";
			 foreach($arr_PostalcolomboList as $obj_Postalcolombo)
			 {		 
				$main_result .=getPostalcolomboXml($obj_Postalcolombo);
			 }
			$main_result .= "</POSTALCOLOMBOLIST>";

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

function getPostalcolomboXml($obj_Postalcolombo)
{
	$xml  = "<POSTALCOLOMBO>";	
		$xml .= "<COL1>".$obj_Postalcolombo->col1."</COL1>";
		$xml .= "<COL2>".$obj_Postalcolombo->col2."</COL2>";
		$xml .= "<COL3>".$obj_Postalcolombo->col3."</COL3>";

	$xml .= "</POSTALCOLOMBO>";
	
	return $xml;
}
	
function getPostalcolomboBy($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePostalcolombo::getPostalcolomboListBy($id);
	if($result->type ==1)
	{
	$arr_PostalcolomboList = $result->data;
		if(count($arr_PostalcolomboList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_PostalcolomboList as $obj_Postalcolombo)
			 {		 
				$main_result .=getPostalcolomboXml($obj_Postalcolombo);
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
