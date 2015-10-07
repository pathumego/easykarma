<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_traditionalknowledge.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_traditionalknowledge.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_traditionalknowledge',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_TRADITIONALKNOWLEDGEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_traditionalknowledge',                
    'rpc',                                
    'encoded',                            
    'add Village_traditionalknowledge'            
);

$server->register('updateVillage_traditionalknowledge',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_TRADITIONALKNOWLEDGEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_traditionalknowledge',                
    'rpc',                                
    'encoded',                            
    'update Village_traditionalknowledge'            
);

$server->register('getVillage_traditionalknowledgeList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_traditionalknowledgeList',                
    'rpc',                                
    'encoded',                            
    'add Village_traditionalknowledge'            
);


$server->register('getVillage_traditionalknowledgeByTblId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_traditionalknowledgeByTblId',                
    'rpc',                                
    'encoded',                            
    'get Village_traditionalknowledge By TblId'            
);


function addVillage_traditionalknowledge($sessionkey, $appcode, $Village_traditionalknowledgedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_traditionalknowledge = new Village_traditionalknowledge();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Village_traditionalknowledge->TblId =  $child;break;};
		case "VILLAGEID":{$obj_Village_traditionalknowledge->VillageId =  $child;break;};
		case "TRADITIONALKNOWLEDGECATEGORYID":{$obj_Village_traditionalknowledge->TraditionalKnowledgeCategoryID =  $child;break;};
		case "DISCRIPTION":{$obj_Village_traditionalknowledge->Discription =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_traditionalknowledge = DAL_manageVillage_traditionalknowledge::addVillage_traditionalknowledge($obj_Village_traditionalknowledge);
    if ($obj_retResult_Village_traditionalknowledge->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_traditionalknowledgeXml($obj_retResult_Village_traditionalknowledge->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_traditionalknowledge($sessionkey, $appcode, $Village_traditionalknowledgedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_traditionalknowledge = new Village_traditionalknowledge();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Village_traditionalknowledge->TblId =  $child;break;};
		case "VILLAGEID":{$obj_Village_traditionalknowledge->VillageId =  $child;break;};
		case "TRADITIONALKNOWLEDGECATEGORYID":{$obj_Village_traditionalknowledge->TraditionalKnowledgeCategoryID =  $child;break;};
		case "DISCRIPTION":{$obj_Village_traditionalknowledge->Discription =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_traditionalknowledge = DAL_manageVillage_traditionalknowledge::updateVillage_traditionalknowledge($obj_Village_traditionalknowledge);
    if ($obj_retResult_Village_traditionalknowledge->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_traditionalknowledgeXml($obj_retResult_Village_traditionalknowledge->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_traditionalknowledgeList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_traditionalknowledge::getVillage_traditionalknowledgeList();
	if($result->type ==1)
	{
	$arr_Village_traditionalknowledgeList = $result->data;
		if(count($arr_Village_traditionalknowledgeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_TRADITIONALKNOWLEDGELIST>";
			 foreach($arr_Village_traditionalknowledgeList as $obj_Village_traditionalknowledge)
			 {		 
				$main_result .=getVillage_traditionalknowledgeXml($obj_Village_traditionalknowledge);
			 }
			$main_result .= "</VILLAGE_TRADITIONALKNOWLEDGELIST>";

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

function getVillage_traditionalknowledgeXml($obj_Village_traditionalknowledge)
{
	$xml  = "<VILLAGE_TRADITIONALKNOWLEDGE>";	
		$xml .= "<TBLID>".$obj_Village_traditionalknowledge->TblId."</TBLID>";
		$xml .= "<VILLAGEID>".$obj_Village_traditionalknowledge->VillageId."</VILLAGEID>";
		$xml .= "<TRADITIONALKNOWLEDGECATEGORYID>".$obj_Village_traditionalknowledge->TraditionalKnowledgeCategoryID."</TRADITIONALKNOWLEDGECATEGORYID>";
		$xml .= "<DISCRIPTION>".$obj_Village_traditionalknowledge->Discription."</DISCRIPTION>";

	$xml .= "</VILLAGE_TRADITIONALKNOWLEDGE>";
	
	return $xml;
}
	
function getVillage_traditionalknowledgeByTblId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_traditionalknowledge::getVillage_traditionalknowledgeListByTblId($id);
	if($result->type ==1)
	{
	$arr_Village_traditionalknowledgeList = $result->data;
		if(count($arr_Village_traditionalknowledgeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_traditionalknowledgeList as $obj_Village_traditionalknowledge)
			 {		 
				$main_result .=getVillage_traditionalknowledgeXml($obj_Village_traditionalknowledge);
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
