<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageIndustrial.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageIndustrial.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addIndustrial',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','INDUSTRIALDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addIndustrial',                
    'rpc',                                
    'encoded',                            
    'add Industrial'            
);

$server->register('updateIndustrial',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','INDUSTRIALDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateIndustrial',                
    'rpc',                                
    'encoded',                            
    'update Industrial'            
);

$server->register('getIndustrialList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getIndustrialList',                
    'rpc',                                
    'encoded',                            
    'add Industrial'            
);


$server->register('getIndustrialByIndustrialId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getIndustrialByIndustrialId',                
    'rpc',                                
    'encoded',                            
    'get Industrial By IndustrialId'            
);


function addIndustrial($sessionkey, $appcode, $Industrialdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Industrial = new Industrial();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "INDUSTRIALID":{$obj_Industrial->IndustrialId =  $child;break;};
		case "INDUSTRIALNAME":{$obj_Industrial->IndustrialName =  $child;break;};
		case "DESCRIPTION":{$obj_Industrial->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Industrial = DAL_manageIndustrial::addIndustrial($obj_Industrial);
    if ($obj_retResult_Industrial->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getIndustrialXml($obj_retResult_Industrial->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateIndustrial($sessionkey, $appcode, $Industrialdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Industrial = new Industrial();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "INDUSTRIALID":{$obj_Industrial->IndustrialId =  $child;break;};
		case "INDUSTRIALNAME":{$obj_Industrial->IndustrialName =  $child;break;};
		case "DESCRIPTION":{$obj_Industrial->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Industrial = DAL_manageIndustrial::updateIndustrial($obj_Industrial);
    if ($obj_retResult_Industrial->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getIndustrialXml($obj_retResult_Industrial->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getIndustrialList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageIndustrial::getIndustrialList();
	if($result->type ==1)
	{
	$arr_IndustrialList = $result->data;
		if(count($arr_IndustrialList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<INDUSTRIALLIST>";
			 foreach($arr_IndustrialList as $obj_Industrial)
			 {		 
				$main_result .=getIndustrialXml($obj_Industrial);
			 }
			$main_result .= "</INDUSTRIALLIST>";

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

function getIndustrialXml($obj_Industrial)
{
	$xml  = "<INDUSTRIAL>";	
		$xml .= "<INDUSTRIALID>".$obj_Industrial->IndustrialId."</INDUSTRIALID>";
		$xml .= "<INDUSTRIALNAME>".$obj_Industrial->IndustrialName."</INDUSTRIALNAME>";
		$xml .= "<DESCRIPTION>".$obj_Industrial->Description."</DESCRIPTION>";

	$xml .= "</INDUSTRIAL>";
	
	return $xml;
}
	
function getIndustrialByIndustrialId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageIndustrial::getIndustrialListByIndustrialId($id);
	if($result->type ==1)
	{
	$arr_IndustrialList = $result->data;
		if(count($arr_IndustrialList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_IndustrialList as $obj_Industrial)
			 {		 
				$main_result .=getIndustrialXml($obj_Industrial);
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
