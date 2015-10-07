<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTown.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageTown.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addTown',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TOWNDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addTown',                
    'rpc',                                
    'encoded',                            
    'add Town'            
);

$server->register('updateTown',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','TOWNDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateTown',                
    'rpc',                                
    'encoded',                            
    'update Town'            
);

$server->register('getTownList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTownList',                
    'rpc',                                
    'encoded',                            
    'add Town'            
);


$server->register('getTownByTownId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getTownByTownId',                
    'rpc',                                
    'encoded',                            
    'get Town By TownId'            
);


function addTown($sessionkey, $appcode, $Towndata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Town = new Town();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TOWNID":{$obj_Town->TownId =  $child;break;};
		case "TOWNNAME":{$obj_Town->TownName =  $child;break;};
		case "DESCRIPTION":{$obj_Town->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Town = DAL_manageTown::addTown($obj_Town);
    if ($obj_retResult_Town->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTownXml($obj_retResult_Town->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateTown($sessionkey, $appcode, $Towndata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Town = new Town();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TOWNID":{$obj_Town->TownId =  $child;break;};
		case "TOWNNAME":{$obj_Town->TownName =  $child;break;};
		case "DESCRIPTION":{$obj_Town->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Town = DAL_manageTown::updateTown($obj_Town);
    if ($obj_retResult_Town->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getTownXml($obj_retResult_Town->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getTownList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageTown::getTownList();
	if($result->type ==1)
	{
	$arr_TownList = $result->data;
		if(count($arr_TownList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<TOWNLIST>";
			 foreach($arr_TownList as $obj_Town)
			 {		 
				$main_result .=getTownXml($obj_Town);
			 }
			$main_result .= "</TOWNLIST>";

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

function getTownXml($obj_Town)
{
	$xml  = "<TOWN>";	
		$xml .= "<TOWNID>".$obj_Town->TownId."</TOWNID>";
		$xml .= "<TOWNNAME>".$obj_Town->TownName."</TOWNNAME>";
		$xml .= "<DESCRIPTION>".$obj_Town->Description."</DESCRIPTION>";

	$xml .= "</TOWN>";
	
	return $xml;
}
	
function getTownByTownId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageTown::getTownListByTownId($id);
	if($result->type ==1)
	{
	$arr_TownList = $result->data;
		if(count($arr_TownList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_TownList as $obj_Town)
			 {		 
				$main_result .=getTownXml($obj_Town);
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
