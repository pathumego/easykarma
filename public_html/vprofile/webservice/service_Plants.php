<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePlants.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePlants.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPlants',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PLANTSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPlants',                
    'rpc',                                
    'encoded',                            
    'add Plants'            
);

$server->register('updatePlants',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PLANTSDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePlants',                
    'rpc',                                
    'encoded',                            
    'update Plants'            
);

$server->register('getPlantsList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPlantsList',                
    'rpc',                                
    'encoded',                            
    'add Plants'            
);


$server->register('getPlantsByPlantId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPlantsByPlantId',                
    'rpc',                                
    'encoded',                            
    'get Plants By PlantId'            
);


function addPlants($sessionkey, $appcode, $Plantsdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Plants = new Plants();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PLANTID":{$obj_Plants->PlantId =  $child;break;};
		case "NAME":{$obj_Plants->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Plants->Description =  $child;break;};
		case "BIONAME":{$obj_Plants->BioName =  $child;break;};

		}	
	}
	
    $obj_retResult_Plants = DAL_managePlants::addPlants($obj_Plants);
    if ($obj_retResult_Plants->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPlantsXml($obj_retResult_Plants->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePlants($sessionkey, $appcode, $Plantsdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Plants = new Plants();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PLANTID":{$obj_Plants->PlantId =  $child;break;};
		case "NAME":{$obj_Plants->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Plants->Description =  $child;break;};
		case "BIONAME":{$obj_Plants->BioName =  $child;break;};

		}	
	}
	
    $obj_retResult_Plants = DAL_managePlants::updatePlants($obj_Plants);
    if ($obj_retResult_Plants->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPlantsXml($obj_retResult_Plants->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPlantsList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePlants::getPlantsList();
	if($result->type ==1)
	{
	$arr_PlantsList = $result->data;
		if(count($arr_PlantsList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PLANTSLIST>";
			 foreach($arr_PlantsList as $obj_Plants)
			 {		 
				$main_result .=getPlantsXml($obj_Plants);
			 }
			$main_result .= "</PLANTSLIST>";

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

function getPlantsXml($obj_Plants)
{
	$xml  = "<PLANTS>";	
		$xml .= "<PLANTID>".$obj_Plants->PlantId."</PLANTID>";
		$xml .= "<NAME>".$obj_Plants->Name."</NAME>";
		$xml .= "<DESCRIPTION>".$obj_Plants->Description."</DESCRIPTION>";
		$xml .= "<BIONAME>".$obj_Plants->BioName."</BIONAME>";

	$xml .= "</PLANTS>";
	
	return $xml;
}
	
function getPlantsByPlantId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePlants::getPlantsListByPlantId($id);
	if($result->type ==1)
	{
	$arr_PlantsList = $result->data;
		if(count($arr_PlantsList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_PlantsList as $obj_Plants)
			 {		 
				$main_result .=getPlantsXml($obj_Plants);
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
