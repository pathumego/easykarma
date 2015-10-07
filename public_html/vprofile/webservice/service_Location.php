<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageLocation.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageLocation.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addLocation',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','LOCATIONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addLocation',                
    'rpc',                                
    'encoded',                            
    'add Location'            
);

$server->register('updateLocation',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','LOCATIONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateLocation',                
    'rpc',                                
    'encoded',                            
    'update Location'            
);

$server->register('getLocationList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getLocationList',                
    'rpc',                                
    'encoded',                            
    'add Location'            
);


$server->register('getLocationByLocationId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getLocationByLocationId',                
    'rpc',                                
    'encoded',                            
    'get Location By LocationId'            
);


function addLocation($sessionkey, $appcode, $Locationdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Location = new Location();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "LOCATIONID":{$obj_Location->LocationId =  $child;break;};
		case "NAME":{$obj_Location->Name =  $child;break;};
		case "LOCATIONTYPE":{$obj_Location->LocationType =  $child;break;};
		case "DESCRIPTION":{$obj_Location->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Location = DAL_manageLocation::addLocation($obj_Location);
    if ($obj_retResult_Location->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getLocationXml($obj_retResult_Location->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateLocation($sessionkey, $appcode, $Locationdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Location = new Location();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "LOCATIONID":{$obj_Location->LocationId =  $child;break;};
		case "NAME":{$obj_Location->Name =  $child;break;};
		case "LOCATIONTYPE":{$obj_Location->LocationType =  $child;break;};
		case "DESCRIPTION":{$obj_Location->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Location = DAL_manageLocation::updateLocation($obj_Location);
    if ($obj_retResult_Location->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getLocationXml($obj_retResult_Location->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getLocationList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageLocation::getLocationList();
	if($result->type ==1)
	{
	$arr_LocationList = $result->data;
		if(count($arr_LocationList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<LOCATIONLIST>";
			 foreach($arr_LocationList as $obj_Location)
			 {		 
				$main_result .=getLocationXml($obj_Location);
			 }
			$main_result .= "</LOCATIONLIST>";

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

function getLocationXml($obj_Location)
{
	$xml  = "<LOCATION>";	
		$xml .= "<LOCATIONID>".$obj_Location->LocationId."</LOCATIONID>";
		$xml .= "<NAME>".$obj_Location->Name."</NAME>";
		$xml .= "<LOCATIONTYPE>".$obj_Location->LocationType."</LOCATIONTYPE>";
		$xml .= "<DESCRIPTION>".$obj_Location->Description."</DESCRIPTION>";

	$xml .= "</LOCATION>";
	
	return $xml;
}
	
function getLocationByLocationId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageLocation::getLocationListByLocationId($id);
	if($result->type ==1)
	{
	$arr_LocationList = $result->data;
		if(count($arr_LocationList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_LocationList as $obj_Location)
			 {		 
				$main_result .=getLocationXml($obj_Location);
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
