<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageSociety.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageSociety.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addSociety',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','SOCIETYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addSociety',                
    'rpc',                                
    'encoded',                            
    'add Society'            
);

$server->register('updateSociety',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','SOCIETYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateSociety',                
    'rpc',                                
    'encoded',                            
    'update Society'            
);

$server->register('getSocietyList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getSocietyList',                
    'rpc',                                
    'encoded',                            
    'add Society'            
);


$server->register('getSocietyBySocietyId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getSocietyBySocietyId',                
    'rpc',                                
    'encoded',                            
    'get Society By SocietyId'            
);


function addSociety($sessionkey, $appcode, $Societydata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Society = new Society();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SOCIETYID":{$obj_Society->SocietyId =  $child;break;};
		case "NAME":{$obj_Society->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Society->Description =  $child;break;};
		case "MISSION":{$obj_Society->Mission =  $child;break;};
		case "SOCIETYTYPEID":{$obj_Society->SocietyTypeId =  $child;break;};
		case "SOCIETYADDRESS":{$obj_Society->SocietyAddress =  $child;break;};

		}	
	}
	
    $obj_retResult_Society = DAL_manageSociety::addSociety($obj_Society);
    if ($obj_retResult_Society->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getSocietyXml($obj_retResult_Society->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateSociety($sessionkey, $appcode, $Societydata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Society = new Society();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SOCIETYID":{$obj_Society->SocietyId =  $child;break;};
		case "NAME":{$obj_Society->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Society->Description =  $child;break;};
		case "MISSION":{$obj_Society->Mission =  $child;break;};
		case "SOCIETYTYPEID":{$obj_Society->SocietyTypeId =  $child;break;};
		case "SOCIETYADDRESS":{$obj_Society->SocietyAddress =  $child;break;};

		}	
	}
	
    $obj_retResult_Society = DAL_manageSociety::updateSociety($obj_Society);
    if ($obj_retResult_Society->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getSocietyXml($obj_retResult_Society->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getSocietyList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageSociety::getSocietyList();
	if($result->type ==1)
	{
	$arr_SocietyList = $result->data;
		if(count($arr_SocietyList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<SOCIETYLIST>";
			 foreach($arr_SocietyList as $obj_Society)
			 {		 
				$main_result .=getSocietyXml($obj_Society);
			 }
			$main_result .= "</SOCIETYLIST>";

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

function getSocietyXml($obj_Society)
{
	$xml  = "<SOCIETY>";	
		$xml .= "<SOCIETYID>".$obj_Society->SocietyId."</SOCIETYID>";
		$xml .= "<NAME>".$obj_Society->Name."</NAME>";
		$xml .= "<DESCRIPTION>".$obj_Society->Description."</DESCRIPTION>";
		$xml .= "<MISSION>".$obj_Society->Mission."</MISSION>";
		$xml .= "<SOCIETYTYPEID>".$obj_Society->SocietyTypeId."</SOCIETYTYPEID>";
		$xml .= "<SOCIETYADDRESS>".$obj_Society->SocietyAddress."</SOCIETYADDRESS>";

	$xml .= "</SOCIETY>";
	
	return $xml;
}
	
function getSocietyBySocietyId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageSociety::getSocietyListBySocietyId($id);
	if($result->type ==1)
	{
	$arr_SocietyList = $result->data;
		if(count($arr_SocietyList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_SocietyList as $obj_Society)
			 {		 
				$main_result .=getSocietyXml($obj_Society);
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
