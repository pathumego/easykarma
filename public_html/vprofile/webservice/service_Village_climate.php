<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_climate.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_climate.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_climate',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_CLIMATEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_climate',                
    'rpc',                                
    'encoded',                            
    'add Village_climate'            
);

$server->register('updateVillage_climate',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_CLIMATEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_climate',                
    'rpc',                                
    'encoded',                            
    'update Village_climate'            
);

$server->register('getVillage_climateList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_climateList',                
    'rpc',                                
    'encoded',                            
    'add Village_climate'            
);


$server->register('getVillage_climateByClimateId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_climateByClimateId',                
    'rpc',                                
    'encoded',                            
    'get Village_climate By ClimateId'            
);


function addVillage_climate($sessionkey, $appcode, $Village_climatedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_climate = new Village_climate();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "CLIMATEID":{$obj_Village_climate->ClimateId =  $child;break;};
		case "VILLAGEID":{$obj_Village_climate->VillageId =  $child;break;};
		case "CLIMATEREAGION":{$obj_Village_climate->ClimateReagion =  $child;break;};
		case "RAINFALL":{$obj_Village_climate->RainFall =  $child;break;};
		case "TEMPARATURE":{$obj_Village_climate->Temparature =  $child;break;};
		case "HUMIDITY":{$obj_Village_climate->Humidity =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_climate = DAL_manageVillage_climate::addVillage_climate($obj_Village_climate);
    if ($obj_retResult_Village_climate->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_climateXml($obj_retResult_Village_climate->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_climate($sessionkey, $appcode, $Village_climatedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_climate = new Village_climate();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "CLIMATEID":{$obj_Village_climate->ClimateId =  $child;break;};
		case "VILLAGEID":{$obj_Village_climate->VillageId =  $child;break;};
		case "CLIMATEREAGION":{$obj_Village_climate->ClimateReagion =  $child;break;};
		case "RAINFALL":{$obj_Village_climate->RainFall =  $child;break;};
		case "TEMPARATURE":{$obj_Village_climate->Temparature =  $child;break;};
		case "HUMIDITY":{$obj_Village_climate->Humidity =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_climate = DAL_manageVillage_climate::updateVillage_climate($obj_Village_climate);
    if ($obj_retResult_Village_climate->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_climateXml($obj_retResult_Village_climate->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_climateList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_climate::getVillage_climateList();
	if($result->type ==1)
	{
	$arr_Village_climateList = $result->data;
		if(count($arr_Village_climateList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_CLIMATELIST>";
			 foreach($arr_Village_climateList as $obj_Village_climate)
			 {		 
				$main_result .=getVillage_climateXml($obj_Village_climate);
			 }
			$main_result .= "</VILLAGE_CLIMATELIST>";

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

function getVillage_climateXml($obj_Village_climate)
{
	$xml  = "<VILLAGE_CLIMATE>";	
		$xml .= "<CLIMATEID>".$obj_Village_climate->ClimateId."</CLIMATEID>";
		$xml .= "<VILLAGEID>".$obj_Village_climate->VillageId."</VILLAGEID>";
		$xml .= "<CLIMATEREAGION>".$obj_Village_climate->ClimateReagion."</CLIMATEREAGION>";
		$xml .= "<RAINFALL>".$obj_Village_climate->RainFall."</RAINFALL>";
		$xml .= "<TEMPARATURE>".$obj_Village_climate->Temparature."</TEMPARATURE>";
		$xml .= "<HUMIDITY>".$obj_Village_climate->Humidity."</HUMIDITY>";

	$xml .= "</VILLAGE_CLIMATE>";
	
	return $xml;
}
	
function getVillage_climateByClimateId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_climate::getVillage_climateListByClimateId($id);
	if($result->type ==1)
	{
	$arr_Village_climateList = $result->data;
		if(count($arr_Village_climateList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_climateList as $obj_Village_climate)
			 {		 
				$main_result .=getVillage_climateXml($obj_Village_climate);
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
