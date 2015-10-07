<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageGroup.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageGroup.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addGroup',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','GROUPDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addGroup',                
    'rpc',                                
    'encoded',                            
    'add Group'            
);

$server->register('updateGroup',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','GROUPDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateGroup',                
    'rpc',                                
    'encoded',                            
    'update Group'            
);

$server->register('getGroupList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getGroupList',                
    'rpc',                                
    'encoded',                            
    'add Group'            
);


$server->register('getGroupByGroupId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getGroupByGroupId',                
    'rpc',                                
    'encoded',                            
    'get Group By GroupId'            
);


function addGroup($sessionkey, $appcode, $Groupdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Group = new Group();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "GROUPID":{$obj_Group->GroupId =  $child;break;};
		case "GROUPNAME":{$obj_Group->GroupName =  $child;break;};
		case "GROUPPRIMARYTYPE":{$obj_Group->GroupPrimaryType =  $child;break;};
		case "GROUPMISSIONTYPEID":{$obj_Group->GroupMissionTypeId =  $child;break;};
		case "GROUPADDRESS":{$obj_Group->GroupAddress =  $child;break;};

		}	
	}
	
    $obj_retResult_Group = DAL_manageGroup::addGroup($obj_Group);
    if ($obj_retResult_Group->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getGroupXml($obj_retResult_Group->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateGroup($sessionkey, $appcode, $Groupdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Group = new Group();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "GROUPID":{$obj_Group->GroupId =  $child;break;};
		case "GROUPNAME":{$obj_Group->GroupName =  $child;break;};
		case "GROUPPRIMARYTYPE":{$obj_Group->GroupPrimaryType =  $child;break;};
		case "GROUPMISSIONTYPEID":{$obj_Group->GroupMissionTypeId =  $child;break;};
		case "GROUPADDRESS":{$obj_Group->GroupAddress =  $child;break;};

		}	
	}
	
    $obj_retResult_Group = DAL_manageGroup::updateGroup($obj_Group);
    if ($obj_retResult_Group->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getGroupXml($obj_retResult_Group->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getGroupList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageGroup::getGroupList();
	if($result->type ==1)
	{
	$arr_GroupList = $result->data;
		if(count($arr_GroupList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<GROUPLIST>";
			 foreach($arr_GroupList as $obj_Group)
			 {		 
				$main_result .=getGroupXml($obj_Group);
			 }
			$main_result .= "</GROUPLIST>";

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

function getGroupXml($obj_Group)
{
	$xml  = "<GROUP>";	
		$xml .= "<GROUPID>".$obj_Group->GroupId."</GROUPID>";
		$xml .= "<GROUPNAME>".$obj_Group->GroupName."</GROUPNAME>";
		$xml .= "<GROUPPRIMARYTYPE>".$obj_Group->GroupPrimaryType."</GROUPPRIMARYTYPE>";
		$xml .= "<GROUPMISSIONTYPEID>".$obj_Group->GroupMissionTypeId."</GROUPMISSIONTYPEID>";
		$xml .= "<GROUPADDRESS>".$obj_Group->GroupAddress."</GROUPADDRESS>";

	$xml .= "</GROUP>";
	
	return $xml;
}
	
function getGroupByGroupId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageGroup::getGroupListByGroupId($id);
	if($result->type ==1)
	{
	$arr_GroupList = $result->data;
		if(count($arr_GroupList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_GroupList as $obj_Group)
			 {		 
				$main_result .=getGroupXml($obj_Group);
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
