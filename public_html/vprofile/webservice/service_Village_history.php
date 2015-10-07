<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_history.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_history.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_history',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_HISTORYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_history',                
    'rpc',                                
    'encoded',                            
    'add Village_history'            
);

$server->register('updateVillage_history',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_HISTORYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_history',                
    'rpc',                                
    'encoded',                            
    'update Village_history'            
);

$server->register('getVillage_historyList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_historyList',                
    'rpc',                                
    'encoded',                            
    'add Village_history'            
);


$server->register('getVillage_historyByTblId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_historyByTblId',                
    'rpc',                                
    'encoded',                            
    'get Village_history By TblId'            
);


function addVillage_history($sessionkey, $appcode, $Village_historydata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_history = new Village_history();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Village_history->TblId =  $child;break;};
		case "VILLAGEID":{$obj_Village_history->VillageId =  $child;break;};
		case "DESCRIPTIONTYPE":{$obj_Village_history->DescriptionType =  $child;break;};
		case "DESCRIPTION":{$obj_Village_history->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_history = DAL_manageVillage_history::addVillage_history($obj_Village_history);
    if ($obj_retResult_Village_history->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_historyXml($obj_retResult_Village_history->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_history($sessionkey, $appcode, $Village_historydata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_history = new Village_history();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Village_history->TblId =  $child;break;};
		case "VILLAGEID":{$obj_Village_history->VillageId =  $child;break;};
		case "DESCRIPTIONTYPE":{$obj_Village_history->DescriptionType =  $child;break;};
		case "DESCRIPTION":{$obj_Village_history->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_history = DAL_manageVillage_history::updateVillage_history($obj_Village_history);
    if ($obj_retResult_Village_history->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_historyXml($obj_retResult_Village_history->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_historyList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_history::getVillage_historyList();
	if($result->type ==1)
	{
	$arr_Village_historyList = $result->data;
		if(count($arr_Village_historyList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_HISTORYLIST>";
			 foreach($arr_Village_historyList as $obj_Village_history)
			 {		 
				$main_result .=getVillage_historyXml($obj_Village_history);
			 }
			$main_result .= "</VILLAGE_HISTORYLIST>";

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

function getVillage_historyXml($obj_Village_history)
{
	$xml  = "<VILLAGE_HISTORY>";	
		$xml .= "<TBLID>".$obj_Village_history->TblId."</TBLID>";
		$xml .= "<VILLAGEID>".$obj_Village_history->VillageId."</VILLAGEID>";
		$xml .= "<DESCRIPTIONTYPE>".$obj_Village_history->DescriptionType."</DESCRIPTIONTYPE>";
		$xml .= "<DESCRIPTION>".$obj_Village_history->Description."</DESCRIPTION>";

	$xml .= "</VILLAGE_HISTORY>";
	
	return $xml;
}
	
function getVillage_historyByTblId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_history::getVillage_historyListByTblId($id);
	if($result->type ==1)
	{
	$arr_Village_historyList = $result->data;
		if(count($arr_Village_historyList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_historyList as $obj_Village_history)
			 {		 
				$main_result .=getVillage_historyXml($obj_Village_history);
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
