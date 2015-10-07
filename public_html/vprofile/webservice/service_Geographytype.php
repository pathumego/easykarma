<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageGeographytype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageGeographytype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addGeographytype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','GEOGRAPHYTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addGeographytype',                
    'rpc',                                
    'encoded',                            
    'add Geographytype'            
);

$server->register('updateGeographytype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','GEOGRAPHYTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateGeographytype',                
    'rpc',                                
    'encoded',                            
    'update Geographytype'            
);

$server->register('getGeographytypeList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getGeographytypeList',                
    'rpc',                                
    'encoded',                            
    'add Geographytype'            
);


$server->register('getGeographytypeByGeogrophyTypeId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getGeographytypeByGeogrophyTypeId',                
    'rpc',                                
    'encoded',                            
    'get Geographytype By GeogrophyTypeId'            
);


function addGeographytype($sessionkey, $appcode, $Geographytypedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Geographytype = new Geographytype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "GEOGROPHYTYPEID":{$obj_Geographytype->GeogrophyTypeId =  $child;break;};
		case "NAME":{$obj_Geographytype->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Geographytype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Geographytype = DAL_manageGeographytype::addGeographytype($obj_Geographytype);
    if ($obj_retResult_Geographytype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getGeographytypeXml($obj_retResult_Geographytype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateGeographytype($sessionkey, $appcode, $Geographytypedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Geographytype = new Geographytype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "GEOGROPHYTYPEID":{$obj_Geographytype->GeogrophyTypeId =  $child;break;};
		case "NAME":{$obj_Geographytype->Name =  $child;break;};
		case "DESCRIPTION":{$obj_Geographytype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Geographytype = DAL_manageGeographytype::updateGeographytype($obj_Geographytype);
    if ($obj_retResult_Geographytype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getGeographytypeXml($obj_retResult_Geographytype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getGeographytypeList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageGeographytype::getGeographytypeList();
	if($result->type ==1)
	{
	$arr_GeographytypeList = $result->data;
		if(count($arr_GeographytypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<GEOGRAPHYTYPELIST>";
			 foreach($arr_GeographytypeList as $obj_Geographytype)
			 {		 
				$main_result .=getGeographytypeXml($obj_Geographytype);
			 }
			$main_result .= "</GEOGRAPHYTYPELIST>";

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

function getGeographytypeXml($obj_Geographytype)
{
	$xml  = "<GEOGRAPHYTYPE>";	
		$xml .= "<GEOGROPHYTYPEID>".$obj_Geographytype->GeogrophyTypeId."</GEOGROPHYTYPEID>";
		$xml .= "<NAME>".$obj_Geographytype->Name."</NAME>";
		$xml .= "<DESCRIPTION>".$obj_Geographytype->Description."</DESCRIPTION>";

	$xml .= "</GEOGRAPHYTYPE>";
	
	return $xml;
}
	
function getGeographytypeByGeogrophyTypeId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageGeographytype::getGeographytypeListByGeogrophyTypeId($id);
	if($result->type ==1)
	{
	$arr_GeographytypeList = $result->data;
		if(count($arr_GeographytypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_GeographytypeList as $obj_Geographytype)
			 {		 
				$main_result .=getGeographytypeXml($obj_Geographytype);
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
