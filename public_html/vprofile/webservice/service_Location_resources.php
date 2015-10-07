<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageLocation_resources.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageLocation_resources.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addLocation_resources',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','LOCATION_RESOURCESDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addLocation_resources',                
    'rpc',                                
    'encoded',                            
    'add Location_resources'            
);

$server->register('updateLocation_resources',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','LOCATION_RESOURCESDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateLocation_resources',                
    'rpc',                                
    'encoded',                            
    'update Location_resources'            
);

$server->register('getLocation_resourcesList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getLocation_resourcesList',                
    'rpc',                                
    'encoded',                            
    'add Location_resources'            
);


$server->register('getLocation_resourcesByResourceId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getLocation_resourcesByResourceId',                
    'rpc',                                
    'encoded',                            
    'get Location_resources By ResourceId'            
);


function addLocation_resources($sessionkey, $appcode, $Location_resourcesdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Location_resources = new Location_resources();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "RESOURCEID":{$obj_Location_resources->ResourceId =  $child;break;};
		case "LOCATIONID":{$obj_Location_resources->LocationId =  $child;break;};
		case "RESOURCETYPE":{$obj_Location_resources->ResourceType =  $child;break;};
		case "RESOURCEPATH":{$obj_Location_resources->ResourcePath =  $child;break;};

		}	
	}
	
    $obj_retResult_Location_resources = DAL_manageLocation_resources::addLocation_resources($obj_Location_resources);
    if ($obj_retResult_Location_resources->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getLocation_resourcesXml($obj_retResult_Location_resources->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateLocation_resources($sessionkey, $appcode, $Location_resourcesdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Location_resources = new Location_resources();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "RESOURCEID":{$obj_Location_resources->ResourceId =  $child;break;};
		case "LOCATIONID":{$obj_Location_resources->LocationId =  $child;break;};
		case "RESOURCETYPE":{$obj_Location_resources->ResourceType =  $child;break;};
		case "RESOURCEPATH":{$obj_Location_resources->ResourcePath =  $child;break;};

		}	
	}
	
    $obj_retResult_Location_resources = DAL_manageLocation_resources::updateLocation_resources($obj_Location_resources);
    if ($obj_retResult_Location_resources->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getLocation_resourcesXml($obj_retResult_Location_resources->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getLocation_resourcesList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageLocation_resources::getLocation_resourcesList();
	if($result->type ==1)
	{
	$arr_Location_resourcesList = $result->data;
		if(count($arr_Location_resourcesList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<LOCATION_RESOURCESLIST>";
			 foreach($arr_Location_resourcesList as $obj_Location_resources)
			 {		 
				$main_result .=getLocation_resourcesXml($obj_Location_resources);
			 }
			$main_result .= "</LOCATION_RESOURCESLIST>";

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

function getLocation_resourcesXml($obj_Location_resources)
{
	$xml  = "<LOCATION_RESOURCES>";	
		$xml .= "<RESOURCEID>".$obj_Location_resources->ResourceId."</RESOURCEID>";
		$xml .= "<LOCATIONID>".$obj_Location_resources->LocationId."</LOCATIONID>";
		$xml .= "<RESOURCETYPE>".$obj_Location_resources->ResourceType."</RESOURCETYPE>";
		$xml .= "<RESOURCEPATH>".$obj_Location_resources->ResourcePath."</RESOURCEPATH>";

	$xml .= "</LOCATION_RESOURCES>";
	
	return $xml;
}
	
function getLocation_resourcesByResourceId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageLocation_resources::getLocation_resourcesListByResourceId($id);
	if($result->type ==1)
	{
	$arr_Location_resourcesList = $result->data;
		if(count($arr_Location_resourcesList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Location_resourcesList as $obj_Location_resources)
			 {		 
				$main_result .=getLocation_resourcesXml($obj_Location_resources);
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
