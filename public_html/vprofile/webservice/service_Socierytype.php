<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageSocierytype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageSocierytype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addSocierytype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','SOCIERYTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addSocierytype',                
    'rpc',                                
    'encoded',                            
    'add Socierytype'            
);

$server->register('updateSocierytype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','SOCIERYTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateSocierytype',                
    'rpc',                                
    'encoded',                            
    'update Socierytype'            
);

$server->register('getSocierytypeList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getSocierytypeList',                
    'rpc',                                
    'encoded',                            
    'add Socierytype'            
);


$server->register('getSocierytypeBySocieryTypeId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getSocierytypeBySocieryTypeId',                
    'rpc',                                
    'encoded',                            
    'get Socierytype By SocieryTypeId'            
);


function addSocierytype($sessionkey, $appcode, $Socierytypedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Socierytype = new Socierytype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SOCIERYTYPEID":{$obj_Socierytype->SocieryTypeId =  $child;break;};
		case "SOCIERYTYPENAME":{$obj_Socierytype->SocieryTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Socierytype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Socierytype = DAL_manageSocierytype::addSocierytype($obj_Socierytype);
    if ($obj_retResult_Socierytype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getSocierytypeXml($obj_retResult_Socierytype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateSocierytype($sessionkey, $appcode, $Socierytypedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Socierytype = new Socierytype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "SOCIERYTYPEID":{$obj_Socierytype->SocieryTypeId =  $child;break;};
		case "SOCIERYTYPENAME":{$obj_Socierytype->SocieryTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Socierytype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Socierytype = DAL_manageSocierytype::updateSocierytype($obj_Socierytype);
    if ($obj_retResult_Socierytype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getSocierytypeXml($obj_retResult_Socierytype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getSocierytypeList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageSocierytype::getSocierytypeList();
	if($result->type ==1)
	{
	$arr_SocierytypeList = $result->data;
		if(count($arr_SocierytypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<SOCIERYTYPELIST>";
			 foreach($arr_SocierytypeList as $obj_Socierytype)
			 {		 
				$main_result .=getSocierytypeXml($obj_Socierytype);
			 }
			$main_result .= "</SOCIERYTYPELIST>";

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

function getSocierytypeXml($obj_Socierytype)
{
	$xml  = "<SOCIERYTYPE>";	
		$xml .= "<SOCIERYTYPEID>".$obj_Socierytype->SocieryTypeId."</SOCIERYTYPEID>";
		$xml .= "<SOCIERYTYPENAME>".$obj_Socierytype->SocieryTypeName."</SOCIERYTYPENAME>";
		$xml .= "<DESCRIPTION>".$obj_Socierytype->Description."</DESCRIPTION>";

	$xml .= "</SOCIERYTYPE>";
	
	return $xml;
}
	
function getSocierytypeBySocieryTypeId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageSocierytype::getSocierytypeListBySocieryTypeId($id);
	if($result->type ==1)
	{
	$arr_SocierytypeList = $result->data;
		if(count($arr_SocierytypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_SocierytypeList as $obj_Socierytype)
			 {		 
				$main_result .=getSocierytypeXml($obj_Socierytype);
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
