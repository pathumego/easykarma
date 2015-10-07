<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_enterance.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_enterance.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_enterance',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_ENTERANCEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_enterance',                
    'rpc',                                
    'encoded',                            
    'add Village_enterance'            
);

$server->register('updateVillage_enterance',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_ENTERANCEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_enterance',                
    'rpc',                                
    'encoded',                            
    'update Village_enterance'            
);

$server->register('getVillage_enteranceList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_enteranceList',                
    'rpc',                                
    'encoded',                            
    'add Village_enterance'            
);


$server->register('getVillage_enteranceByTblId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_enteranceByTblId',                
    'rpc',                                
    'encoded',                            
    'get Village_enterance By TblId'            
);


function addVillage_enterance($sessionkey, $appcode, $Village_enterancedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_enterance = new Village_enterance();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Village_enterance->TblId =  $child;break;};
		case "VILLAGEID":{$obj_Village_enterance->VillageId =  $child;break;};
		case "DIRECTION":{$obj_Village_enterance->Direction =  $child;break;};
		case "DESCRIPTION":{$obj_Village_enterance->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_enterance = DAL_manageVillage_enterance::addVillage_enterance($obj_Village_enterance);
    if ($obj_retResult_Village_enterance->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_enteranceXml($obj_retResult_Village_enterance->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_enterance($sessionkey, $appcode, $Village_enterancedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_enterance = new Village_enterance();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Village_enterance->TblId =  $child;break;};
		case "VILLAGEID":{$obj_Village_enterance->VillageId =  $child;break;};
		case "DIRECTION":{$obj_Village_enterance->Direction =  $child;break;};
		case "DESCRIPTION":{$obj_Village_enterance->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_enterance = DAL_manageVillage_enterance::updateVillage_enterance($obj_Village_enterance);
    if ($obj_retResult_Village_enterance->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_enteranceXml($obj_retResult_Village_enterance->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_enteranceList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_enterance::getVillage_enteranceList();
	if($result->type ==1)
	{
	$arr_Village_enteranceList = $result->data;
		if(count($arr_Village_enteranceList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_ENTERANCELIST>";
			 foreach($arr_Village_enteranceList as $obj_Village_enterance)
			 {		 
				$main_result .=getVillage_enteranceXml($obj_Village_enterance);
			 }
			$main_result .= "</VILLAGE_ENTERANCELIST>";

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

function getVillage_enteranceXml($obj_Village_enterance)
{
	$xml  = "<VILLAGE_ENTERANCE>";	
		$xml .= "<TBLID>".$obj_Village_enterance->TblId."</TBLID>";
		$xml .= "<VILLAGEID>".$obj_Village_enterance->VillageId."</VILLAGEID>";
		$xml .= "<DIRECTION>".$obj_Village_enterance->Direction."</DIRECTION>";
		$xml .= "<DESCRIPTION>".$obj_Village_enterance->Description."</DESCRIPTION>";

	$xml .= "</VILLAGE_ENTERANCE>";
	
	return $xml;
}
	
function getVillage_enteranceByTblId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_enterance::getVillage_enteranceListByTblId($id);
	if($result->type ==1)
	{
	$arr_Village_enteranceList = $result->data;
		if(count($arr_Village_enteranceList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_enteranceList as $obj_Village_enterance)
			 {		 
				$main_result .=getVillage_enteranceXml($obj_Village_enterance);
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
