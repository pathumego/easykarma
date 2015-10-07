<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageAgriculture.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageAgriculture.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addAgriculture',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','AGRICULTUREDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addAgriculture',                
    'rpc',                                
    'encoded',                            
    'add Agriculture'            
);

$server->register('updateAgriculture',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','AGRICULTUREDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateAgriculture',                
    'rpc',                                
    'encoded',                            
    'update Agriculture'            
);

$server->register('getAgricultureList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getAgricultureList',                
    'rpc',                                
    'encoded',                            
    'add Agriculture'            
);


$server->register('getAgricultureByAgricultureId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getAgricultureByAgricultureId',                
    'rpc',                                
    'encoded',                            
    'get Agriculture By AgricultureId'            
);


function addAgriculture($sessionkey, $appcode, $Agriculturedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Agriculture = new Agriculture();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "AGRICULTUREID":{$obj_Agriculture->AgricultureId =  $child;break;};
		case "AGRICULTURENAME":{$obj_Agriculture->AgricultureName =  $child;break;};
		case "DESCRIPTION":{$obj_Agriculture->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Agriculture = DAL_manageAgriculture::addAgriculture($obj_Agriculture);
    if ($obj_retResult_Agriculture->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getAgricultureXml($obj_retResult_Agriculture->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateAgriculture($sessionkey, $appcode, $Agriculturedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Agriculture = new Agriculture();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "AGRICULTUREID":{$obj_Agriculture->AgricultureId =  $child;break;};
		case "AGRICULTURENAME":{$obj_Agriculture->AgricultureName =  $child;break;};
		case "DESCRIPTION":{$obj_Agriculture->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Agriculture = DAL_manageAgriculture::updateAgriculture($obj_Agriculture);
    if ($obj_retResult_Agriculture->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getAgricultureXml($obj_retResult_Agriculture->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getAgricultureList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageAgriculture::getAgricultureList();
	if($result->type ==1)
	{
	$arr_AgricultureList = $result->data;
		if(count($arr_AgricultureList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<AGRICULTURELIST>";
			 foreach($arr_AgricultureList as $obj_Agriculture)
			 {		 
				$main_result .=getAgricultureXml($obj_Agriculture);
			 }
			$main_result .= "</AGRICULTURELIST>";

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

function getAgricultureXml($obj_Agriculture)
{
	$xml  = "<AGRICULTURE>";	
		$xml .= "<AGRICULTUREID>".$obj_Agriculture->AgricultureId."</AGRICULTUREID>";
		$xml .= "<AGRICULTURENAME>".$obj_Agriculture->AgricultureName."</AGRICULTURENAME>";
		$xml .= "<DESCRIPTION>".$obj_Agriculture->Description."</DESCRIPTION>";

	$xml .= "</AGRICULTURE>";
	
	return $xml;
}
	
function getAgricultureByAgricultureId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageAgriculture::getAgricultureListByAgricultureId($id);
	if($result->type ==1)
	{
	$arr_AgricultureList = $result->data;
		if(count($arr_AgricultureList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_AgricultureList as $obj_Agriculture)
			 {		 
				$main_result .=getAgricultureXml($obj_Agriculture);
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
