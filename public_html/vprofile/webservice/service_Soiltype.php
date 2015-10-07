<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageSoiltype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageSoiltype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addSoiltype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','SOILTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addSoiltype',                
    'rpc',                                
    'encoded',                            
    'add Soiltype'            
);

$server->register('updateSoiltype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','SOILTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateSoiltype',                
    'rpc',                                
    'encoded',                            
    'update Soiltype'            
);

$server->register('getSoiltypeList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getSoiltypeList',                
    'rpc',                                
    'encoded',                            
    'add Soiltype'            
);


$server->register('getSoiltypeByTblId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getSoiltypeByTblId',                
    'rpc',                                
    'encoded',                            
    'get Soiltype By TblId'            
);


function addSoiltype($sessionkey, $appcode, $Soiltypedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Soiltype = new Soiltype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Soiltype->TblId =  $child;break;};
		case "SOILTYPEID":{$obj_Soiltype->SoilTypeId =  $child;break;};
		case "SOILTYPENAME":{$obj_Soiltype->SoilTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Soiltype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Soiltype = DAL_manageSoiltype::addSoiltype($obj_Soiltype);
    if ($obj_retResult_Soiltype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getSoiltypeXml($obj_retResult_Soiltype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateSoiltype($sessionkey, $appcode, $Soiltypedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Soiltype = new Soiltype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "TBLID":{$obj_Soiltype->TblId =  $child;break;};
		case "SOILTYPEID":{$obj_Soiltype->SoilTypeId =  $child;break;};
		case "SOILTYPENAME":{$obj_Soiltype->SoilTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Soiltype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Soiltype = DAL_manageSoiltype::updateSoiltype($obj_Soiltype);
    if ($obj_retResult_Soiltype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getSoiltypeXml($obj_retResult_Soiltype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getSoiltypeList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageSoiltype::getSoiltypeList();
	if($result->type ==1)
	{
	$arr_SoiltypeList = $result->data;
		if(count($arr_SoiltypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<SOILTYPELIST>";
			 foreach($arr_SoiltypeList as $obj_Soiltype)
			 {		 
				$main_result .=getSoiltypeXml($obj_Soiltype);
			 }
			$main_result .= "</SOILTYPELIST>";

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

function getSoiltypeXml($obj_Soiltype)
{
	$xml  = "<SOILTYPE>";	
		$xml .= "<TBLID>".$obj_Soiltype->TblId."</TBLID>";
		$xml .= "<SOILTYPEID>".$obj_Soiltype->SoilTypeId."</SOILTYPEID>";
		$xml .= "<SOILTYPENAME>".$obj_Soiltype->SoilTypeName."</SOILTYPENAME>";
		$xml .= "<DESCRIPTION>".$obj_Soiltype->Description."</DESCRIPTION>";

	$xml .= "</SOILTYPE>";
	
	return $xml;
}
	
function getSoiltypeByTblId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageSoiltype::getSoiltypeListByTblId($id);
	if($result->type ==1)
	{
	$arr_SoiltypeList = $result->data;
		if(count($arr_SoiltypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_SoiltypeList as $obj_Soiltype)
			 {		 
				$main_result .=getSoiltypeXml($obj_Soiltype);
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
