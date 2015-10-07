<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageForesttype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageForesttype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addForesttype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','FORESTTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addForesttype',                
    'rpc',                                
    'encoded',                            
    'add Foresttype'            
);

$server->register('updateForesttype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','FORESTTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateForesttype',                
    'rpc',                                
    'encoded',                            
    'update Foresttype'            
);

$server->register('getForesttypeList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getForesttypeList',                
    'rpc',                                
    'encoded',                            
    'add Foresttype'            
);


$server->register('getForesttypeByForestTypeId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getForesttypeByForestTypeId',                
    'rpc',                                
    'encoded',                            
    'get Foresttype By ForestTypeId'            
);


function addForesttype($sessionkey, $appcode, $Foresttypedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Foresttype = new Foresttype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "FORESTTYPEID":{$obj_Foresttype->ForestTypeId =  $child;break;};
		case "NAME":{$obj_Foresttype->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Foresttype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Foresttype = DAL_manageForesttype::addForesttype($obj_Foresttype);
    if ($obj_retResult_Foresttype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getForesttypeXml($obj_retResult_Foresttype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateForesttype($sessionkey, $appcode, $Foresttypedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Foresttype = new Foresttype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "FORESTTYPEID":{$obj_Foresttype->ForestTypeId =  $child;break;};
		case "NAME":{$obj_Foresttype->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Foresttype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Foresttype = DAL_manageForesttype::updateForesttype($obj_Foresttype);
    if ($obj_retResult_Foresttype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getForesttypeXml($obj_retResult_Foresttype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getForesttypeList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageForesttype::getForesttypeList();
	if($result->type ==1)
	{
	$arr_ForesttypeList = $result->data;
		if(count($arr_ForesttypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<FORESTTYPELIST>";
			 foreach($arr_ForesttypeList as $obj_Foresttype)
			 {		 
				$main_result .=getForesttypeXml($obj_Foresttype);
			 }
			$main_result .= "</FORESTTYPELIST>";

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

function getForesttypeXml($obj_Foresttype)
{
	$xml  = "<FORESTTYPE>";	
		$xml .= "<FORESTTYPEID>".$obj_Foresttype->ForestTypeId."</FORESTTYPEID>";
		$xml .= "<NAME>".$obj_Foresttype->Name."</NAME>";
		$xml .= "<DESCRIPTION>".$obj_Foresttype->Description."</DESCRIPTION>";

	$xml .= "</FORESTTYPE>";
	
	return $xml;
}
	
function getForesttypeByForestTypeId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageForesttype::getForesttypeListByForestTypeId($id);
	if($result->type ==1)
	{
	$arr_ForesttypeList = $result->data;
		if(count($arr_ForesttypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_ForesttypeList as $obj_Foresttype)
			 {		 
				$main_result .=getForesttypeXml($obj_Foresttype);
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
