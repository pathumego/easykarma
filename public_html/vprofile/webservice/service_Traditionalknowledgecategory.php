<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTraditionalknowledgecategory.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageTraditionalknowledgecategory.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addTraditionalknowledgecategory',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TRADITIONALKNOWLEDGECATEGORYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addTraditionalknowledgecategory',                
    'rpc',                                
    'encoded',                            
    'add Traditionalknowledgecategory'            
);

$server->register('updateTraditionalknowledgecategory',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TRADITIONALKNOWLEDGECATEGORYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateTraditionalknowledgecategory',                
    'rpc',                                
    'encoded',                            
    'update Traditionalknowledgecategory'            
);

$server->register('getTraditionalknowledgecategoryList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTraditionalknowledgecategoryList',                
    'rpc',                                
    'encoded',                            
    'add Traditionalknowledgecategory'            
);


$server->register('getTraditionalknowledgecategoryByCategoryId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTraditionalknowledgecategoryByCategoryId',                
    'rpc',                                
    'encoded',                            
    'get Traditionalknowledgecategory By CategoryId'            
);


function addTraditionalknowledgecategory($sessionkey, $appcode, $Traditionalknowledgecategorydata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "CATEGORYID":{$obj_Traditionalknowledgecategory->CategoryId =  $child;break;};
		case "CATEGORYNAME":{$obj_Traditionalknowledgecategory->CategoryName =  $child;break;};
		case "DESCRIPTION":{$obj_Traditionalknowledgecategory->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Traditionalknowledgecategory = DAL_manageTraditionalknowledgecategory::addTraditionalknowledgecategory($obj_Traditionalknowledgecategory);
    if ($obj_retResult_Traditionalknowledgecategory->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTraditionalknowledgecategoryXml($obj_retResult_Traditionalknowledgecategory->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateTraditionalknowledgecategory($sessionkey, $appcode, $Traditionalknowledgecategorydata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "CATEGORYID":{$obj_Traditionalknowledgecategory->CategoryId =  $child;break;};
		case "CATEGORYNAME":{$obj_Traditionalknowledgecategory->CategoryName =  $child;break;};
		case "DESCRIPTION":{$obj_Traditionalknowledgecategory->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Traditionalknowledgecategory = DAL_manageTraditionalknowledgecategory::updateTraditionalknowledgecategory($obj_Traditionalknowledgecategory);
    if ($obj_retResult_Traditionalknowledgecategory->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTraditionalknowledgecategoryXml($obj_retResult_Traditionalknowledgecategory->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getTraditionalknowledgecategoryList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageTraditionalknowledgecategory::getTraditionalknowledgecategoryList();
	if($result->type ==1)
	{
	$arr_TraditionalknowledgecategoryList = $result->data;
		if(count($arr_TraditionalknowledgecategoryList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<TRADITIONALKNOWLEDGECATEGORYLIST>";
			 foreach($arr_TraditionalknowledgecategoryList as $obj_Traditionalknowledgecategory)
			 {		 
				$main_result .=getTraditionalknowledgecategoryXml($obj_Traditionalknowledgecategory);
			 }
			$main_result .= "</TRADITIONALKNOWLEDGECATEGORYLIST>";

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

function getTraditionalknowledgecategoryXml($obj_Traditionalknowledgecategory)
{
	$xml  = "<TRADITIONALKNOWLEDGECATEGORY>";	
		$xml .= "<CATEGORYID>".$obj_Traditionalknowledgecategory->CategoryId."</CATEGORYID>";
		$xml .= "<CATEGORYNAME>".$obj_Traditionalknowledgecategory->CategoryName."</CATEGORYNAME>";
		$xml .= "<DESCRIPTION>".$obj_Traditionalknowledgecategory->Description."</DESCRIPTION>";

	$xml .= "</TRADITIONALKNOWLEDGECATEGORY>";
	
	return $xml;
}
	
function getTraditionalknowledgecategoryByCategoryId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageTraditionalknowledgecategory::getTraditionalknowledgecategoryListByCategoryId($id);
	if($result->type ==1)
	{
	$arr_TraditionalknowledgecategoryList = $result->data;
		if(count($arr_TraditionalknowledgecategoryList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_TraditionalknowledgecategoryList as $obj_Traditionalknowledgecategory)
			 {		 
				$main_result .=getTraditionalknowledgecategoryXml($obj_Traditionalknowledgecategory);
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
