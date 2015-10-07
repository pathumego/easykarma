<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_geologicalvariation.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_geologicalvariation.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_geologicalvariation',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_GEOLOGICALVARIATIONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_geologicalvariation',                
    'rpc',                                
    'encoded',                            
    'add Village_geologicalvariation'            
);

$server->register('updateVillage_geologicalvariation',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_GEOLOGICALVARIATIONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_geologicalvariation',                
    'rpc',                                
    'encoded',                            
    'update Village_geologicalvariation'            
);

$server->register('getVillage_geologicalvariationList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_geologicalvariationList',                
    'rpc',                                
    'encoded',                            
    'add Village_geologicalvariation'            
);


$server->register('getVillage_geologicalvariationByTblId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_geologicalvariationByTblId',                
    'rpc',                                
    'encoded',                            
    'get Village_geologicalvariation By TblId'            
);


function addVillage_geologicalvariation($sessionkey, $appcode, $Village_geologicalvariationdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_geologicalvariation = new Village_geologicalvariation();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Village_geologicalvariation->TblId =  $child;break;};
		case "VILLAGEID":{$obj_Village_geologicalvariation->VillageId =  $child;break;};
		case "VARIATION":{$obj_Village_geologicalvariation->Variation =  $child;break;};
		case "DESCRIPTION":{$obj_Village_geologicalvariation->Description =  $child;break;};
		case "PRIMARYGEOLAYERTYPEID":{$obj_Village_geologicalvariation->PrimaryGeoLayerTypeId =  $child;break;};
		case "SOILTYPEID":{$obj_Village_geologicalvariation->SoilTypeId =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_geologicalvariation = DAL_manageVillage_geologicalvariation::addVillage_geologicalvariation($obj_Village_geologicalvariation);
    if ($obj_retResult_Village_geologicalvariation->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_geologicalvariationXml($obj_retResult_Village_geologicalvariation->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_geologicalvariation($sessionkey, $appcode, $Village_geologicalvariationdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_geologicalvariation = new Village_geologicalvariation();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Village_geologicalvariation->TblId =  $child;break;};
		case "VILLAGEID":{$obj_Village_geologicalvariation->VillageId =  $child;break;};
		case "VARIATION":{$obj_Village_geologicalvariation->Variation =  $child;break;};
		case "DESCRIPTION":{$obj_Village_geologicalvariation->Description =  $child;break;};
		case "PRIMARYGEOLAYERTYPEID":{$obj_Village_geologicalvariation->PrimaryGeoLayerTypeId =  $child;break;};
		case "SOILTYPEID":{$obj_Village_geologicalvariation->SoilTypeId =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_geologicalvariation = DAL_manageVillage_geologicalvariation::updateVillage_geologicalvariation($obj_Village_geologicalvariation);
    if ($obj_retResult_Village_geologicalvariation->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_geologicalvariationXml($obj_retResult_Village_geologicalvariation->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_geologicalvariationList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_geologicalvariation::getVillage_geologicalvariationList();
	if($result->type ==1)
	{
	$arr_Village_geologicalvariationList = $result->data;
		if(count($arr_Village_geologicalvariationList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_GEOLOGICALVARIATIONLIST>";
			 foreach($arr_Village_geologicalvariationList as $obj_Village_geologicalvariation)
			 {		 
				$main_result .=getVillage_geologicalvariationXml($obj_Village_geologicalvariation);
			 }
			$main_result .= "</VILLAGE_GEOLOGICALVARIATIONLIST>";

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

function getVillage_geologicalvariationXml($obj_Village_geologicalvariation)
{
	$xml  = "<VILLAGE_GEOLOGICALVARIATION>";	
		$xml .= "<TBLID>".$obj_Village_geologicalvariation->TblId."</TBLID>";
		$xml .= "<VILLAGEID>".$obj_Village_geologicalvariation->VillageId."</VILLAGEID>";
		$xml .= "<VARIATION>".$obj_Village_geologicalvariation->Variation."</VARIATION>";
		$xml .= "<DESCRIPTION>".$obj_Village_geologicalvariation->Description."</DESCRIPTION>";
		$xml .= "<PRIMARYGEOLAYERTYPEID>".$obj_Village_geologicalvariation->PrimaryGeoLayerTypeId."</PRIMARYGEOLAYERTYPEID>";
		$xml .= "<SOILTYPEID>".$obj_Village_geologicalvariation->SoilTypeId."</SOILTYPEID>";

	$xml .= "</VILLAGE_GEOLOGICALVARIATION>";
	
	return $xml;
}
	
function getVillage_geologicalvariationByTblId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_geologicalvariation::getVillage_geologicalvariationListByTblId($id);
	if($result->type ==1)
	{
	$arr_Village_geologicalvariationList = $result->data;
		if(count($arr_Village_geologicalvariationList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_geologicalvariationList as $obj_Village_geologicalvariation)
			 {		 
				$main_result .=getVillage_geologicalvariationXml($obj_Village_geologicalvariation);
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
