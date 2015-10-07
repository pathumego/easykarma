<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage',                
    'rpc',                                
    'encoded',                            
    'add Village'            
);

$server->register('updateVillage',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage',                
    'rpc',                                
    'encoded',                            
    'update Village'            
);

$server->register('getVillageList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillageList',                
    'rpc',                                
    'encoded',                            
    'add Village'            
);


$server->register('getVillageByVillageId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillageByVillageId',                
    'rpc',                                
    'encoded',                            
    'get Village By VillageId'            
);


function addVillage($sessionkey, $appcode, $Villagedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village = new Village();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "VILLAGEID":{$obj_Village->VillageId =  $child;break;};
		case "NAME":{$obj_Village->Name =  $child;break;};
		case "VILLAGENUMBER":{$obj_Village->VillageNumber =  $child;break;};
		case "AGADEVISION":{$obj_Village->AgaDevision =  $child;break;};
		case "DISTRICT":{$obj_Village->District =  $child;break;};
		case "PROVINCE":{$obj_Village->Province =  $child;break;};
		case "GEOGROPHYTYPEID":{$obj_Village->GeogrophyTypeId =  $child;break;};
		case "FORESTTYPEID":{$obj_Village->ForestTypeId =  $child;break;};
		case "FORESTDESCRIPTION":{$obj_Village->ForestDescription =  $child;break;};
		case "TRADITIONALKNOWLEDGE":{$obj_Village->TraditionalKnowledge =  $child;break;};

		}	
	}
	
    $obj_retResult_Village = DAL_manageVillage::addVillage($obj_Village);
    if ($obj_retResult_Village->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillageXml($obj_retResult_Village->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage($sessionkey, $appcode, $Villagedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village = new Village();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "VILLAGEID":{$obj_Village->VillageId =  $child;break;};
		case "NAME":{$obj_Village->Name =  $child;break;};
		case "VILLAGENUMBER":{$obj_Village->VillageNumber =  $child;break;};
		case "AGADEVISION":{$obj_Village->AgaDevision =  $child;break;};
		case "DISTRICT":{$obj_Village->District =  $child;break;};
		case "PROVINCE":{$obj_Village->Province =  $child;break;};
		case "GEOGROPHYTYPEID":{$obj_Village->GeogrophyTypeId =  $child;break;};
		case "FORESTTYPEID":{$obj_Village->ForestTypeId =  $child;break;};
		case "FORESTDESCRIPTION":{$obj_Village->ForestDescription =  $child;break;};
		case "TRADITIONALKNOWLEDGE":{$obj_Village->TraditionalKnowledge =  $child;break;};

		}	
	}
	
    $obj_retResult_Village = DAL_manageVillage::updateVillage($obj_Village);
    if ($obj_retResult_Village->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillageXml($obj_retResult_Village->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillageList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage::getVillageList();
	if($result->type ==1)
	{
	$arr_VillageList = $result->data;
		if(count($arr_VillageList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGELIST>";
			 foreach($arr_VillageList as $obj_Village)
			 {		 
				$main_result .=getVillageXml($obj_Village);
			 }
			$main_result .= "</VILLAGELIST>";

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

function getVillageXml($obj_Village)
{
	$xml  = "<VILLAGE>";	
		$xml .= "<VILLAGEID>".$obj_Village->VillageId."</VILLAGEID>";
		$xml .= "<NAME>".$obj_Village->Name."</NAME>";
		$xml .= "<VILLAGENUMBER>".$obj_Village->VillageNumber."</VILLAGENUMBER>";
		$xml .= "<AGADEVISION>".$obj_Village->AgaDevision."</AGADEVISION>";
		$xml .= "<DISTRICT>".$obj_Village->District."</DISTRICT>";
		$xml .= "<PROVINCE>".$obj_Village->Province."</PROVINCE>";
		$xml .= "<GEOGROPHYTYPEID>".$obj_Village->GeogrophyTypeId."</GEOGROPHYTYPEID>";
		$xml .= "<FORESTTYPEID>".$obj_Village->ForestTypeId."</FORESTTYPEID>";
		$xml .= "<FORESTDESCRIPTION>".$obj_Village->ForestDescription."</FORESTDESCRIPTION>";
		$xml .= "<TRADITIONALKNOWLEDGE>".$obj_Village->TraditionalKnowledge."</TRADITIONALKNOWLEDGE>";

	$xml .= "</VILLAGE>";
	
	return $xml;
}
	
function getVillageByVillageId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage::getVillageListByVillageId($id);
	if($result->type ==1)
	{
	$arr_VillageList = $result->data;
		if(count($arr_VillageList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_VillageList as $obj_Village)
			 {		 
				$main_result .=getVillageXml($obj_Village);
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
