<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageGroupmissiontype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageGroupmissiontype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addGroupmissiontype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','GROUPMISSIONTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addGroupmissiontype',                
    'rpc',                                
    'encoded',                            
    'add Groupmissiontype'            
);

$server->register('updateGroupmissiontype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','GROUPMISSIONTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateGroupmissiontype',                
    'rpc',                                
    'encoded',                            
    'update Groupmissiontype'            
);

$server->register('getGroupmissiontypeList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getGroupmissiontypeList',                
    'rpc',                                
    'encoded',                            
    'add Groupmissiontype'            
);


$server->register('getGroupmissiontypeByGroupMissionTypeId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getGroupmissiontypeByGroupMissionTypeId',                
    'rpc',                                
    'encoded',                            
    'get Groupmissiontype By GroupMissionTypeId'            
);


function addGroupmissiontype($sessionkey, $appcode, $Groupmissiontypedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Groupmissiontype = new Groupmissiontype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "GROUPMISSIONTYPEID":{$obj_Groupmissiontype->GroupMissionTypeId =  $child;break;};
		case "GROUPMISSIONTYPENAME":{$obj_Groupmissiontype->GroupMissionTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Groupmissiontype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Groupmissiontype = DAL_manageGroupmissiontype::addGroupmissiontype($obj_Groupmissiontype);
    if ($obj_retResult_Groupmissiontype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getGroupmissiontypeXml($obj_retResult_Groupmissiontype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateGroupmissiontype($sessionkey, $appcode, $Groupmissiontypedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Groupmissiontype = new Groupmissiontype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "GROUPMISSIONTYPEID":{$obj_Groupmissiontype->GroupMissionTypeId =  $child;break;};
		case "GROUPMISSIONTYPENAME":{$obj_Groupmissiontype->GroupMissionTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Groupmissiontype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Groupmissiontype = DAL_manageGroupmissiontype::updateGroupmissiontype($obj_Groupmissiontype);
    if ($obj_retResult_Groupmissiontype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getGroupmissiontypeXml($obj_retResult_Groupmissiontype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getGroupmissiontypeList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageGroupmissiontype::getGroupmissiontypeList();
	if($result->type ==1)
	{
	$arr_GroupmissiontypeList = $result->data;
		if(count($arr_GroupmissiontypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<GROUPMISSIONTYPELIST>";
			 foreach($arr_GroupmissiontypeList as $obj_Groupmissiontype)
			 {		 
				$main_result .=getGroupmissiontypeXml($obj_Groupmissiontype);
			 }
			$main_result .= "</GROUPMISSIONTYPELIST>";

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

function getGroupmissiontypeXml($obj_Groupmissiontype)
{
	$xml  = "<GROUPMISSIONTYPE>";	
		$xml .= "<GROUPMISSIONTYPEID>".$obj_Groupmissiontype->GroupMissionTypeId."</GROUPMISSIONTYPEID>";
		$xml .= "<GROUPMISSIONTYPENAME>".$obj_Groupmissiontype->GroupMissionTypeName."</GROUPMISSIONTYPENAME>";
		$xml .= "<DESCRIPTION>".$obj_Groupmissiontype->Description."</DESCRIPTION>";

	$xml .= "</GROUPMISSIONTYPE>";
	
	return $xml;
}
	
function getGroupmissiontypeByGroupMissionTypeId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageGroupmissiontype::getGroupmissiontypeListByGroupMissionTypeId($id);
	if($result->type ==1)
	{
	$arr_GroupmissiontypeList = $result->data;
		if(count($arr_GroupmissiontypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_GroupmissiontypeList as $obj_Groupmissiontype)
			 {		 
				$main_result .=getGroupmissiontypeXml($obj_Groupmissiontype);
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
