<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePrimarygeolayertype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePrimarygeolayertype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPrimarygeolayertype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PRIMARYGEOLAYERTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPrimarygeolayertype',                
    'rpc',                                
    'encoded',                            
    'add Primarygeolayertype'            
);

$server->register('updatePrimarygeolayertype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PRIMARYGEOLAYERTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePrimarygeolayertype',                
    'rpc',                                
    'encoded',                            
    'update Primarygeolayertype'            
);

$server->register('getPrimarygeolayertypeList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPrimarygeolayertypeList',                
    'rpc',                                
    'encoded',                            
    'add Primarygeolayertype'            
);


$server->register('getPrimarygeolayertypeByPrimaryGeoLayerTypeId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPrimarygeolayertypeByPrimaryGeoLayerTypeId',                
    'rpc',                                
    'encoded',                            
    'get Primarygeolayertype By PrimaryGeoLayerTypeId'            
);


function addPrimarygeolayertype($sessionkey, $appcode, $Primarygeolayertypedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Primarygeolayertype = new Primarygeolayertype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PRIMARYGEOLAYERTYPEID":{$obj_Primarygeolayertype->PrimaryGeoLayerTypeId =  $child;break;};
		case "PRIMARYGEOLAYERNAME":{$obj_Primarygeolayertype->PrimaryGeoLayerName =  $child;break;};
		case "DESCRIPTION":{$obj_Primarygeolayertype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Primarygeolayertype = DAL_managePrimarygeolayertype::addPrimarygeolayertype($obj_Primarygeolayertype);
    if ($obj_retResult_Primarygeolayertype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPrimarygeolayertypeXml($obj_retResult_Primarygeolayertype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePrimarygeolayertype($sessionkey, $appcode, $Primarygeolayertypedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Primarygeolayertype = new Primarygeolayertype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PRIMARYGEOLAYERTYPEID":{$obj_Primarygeolayertype->PrimaryGeoLayerTypeId =  $child;break;};
		case "PRIMARYGEOLAYERNAME":{$obj_Primarygeolayertype->PrimaryGeoLayerName =  $child;break;};
		case "DESCRIPTION":{$obj_Primarygeolayertype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Primarygeolayertype = DAL_managePrimarygeolayertype::updatePrimarygeolayertype($obj_Primarygeolayertype);
    if ($obj_retResult_Primarygeolayertype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPrimarygeolayertypeXml($obj_retResult_Primarygeolayertype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPrimarygeolayertypeList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePrimarygeolayertype::getPrimarygeolayertypeList();
	if($result->type ==1)
	{
	$arr_PrimarygeolayertypeList = $result->data;
		if(count($arr_PrimarygeolayertypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PRIMARYGEOLAYERTYPELIST>";
			 foreach($arr_PrimarygeolayertypeList as $obj_Primarygeolayertype)
			 {		 
				$main_result .=getPrimarygeolayertypeXml($obj_Primarygeolayertype);
			 }
			$main_result .= "</PRIMARYGEOLAYERTYPELIST>";

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

function getPrimarygeolayertypeXml($obj_Primarygeolayertype)
{
	$xml  = "<PRIMARYGEOLAYERTYPE>";	
		$xml .= "<PRIMARYGEOLAYERTYPEID>".$obj_Primarygeolayertype->PrimaryGeoLayerTypeId."</PRIMARYGEOLAYERTYPEID>";
		$xml .= "<PRIMARYGEOLAYERNAME>".$obj_Primarygeolayertype->PrimaryGeoLayerName."</PRIMARYGEOLAYERNAME>";
		$xml .= "<DESCRIPTION>".$obj_Primarygeolayertype->Description."</DESCRIPTION>";

	$xml .= "</PRIMARYGEOLAYERTYPE>";
	
	return $xml;
}
	
function getPrimarygeolayertypeByPrimaryGeoLayerTypeId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePrimarygeolayertype::getPrimarygeolayertypeListByPrimaryGeoLayerTypeId($id);
	if($result->type ==1)
	{
	$arr_PrimarygeolayertypeList = $result->data;
		if(count($arr_PrimarygeolayertypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_PrimarygeolayertypeList as $obj_Primarygeolayertype)
			 {		 
				$main_result .=getPrimarygeolayertypeXml($obj_Primarygeolayertype);
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
