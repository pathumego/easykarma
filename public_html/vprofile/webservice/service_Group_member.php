<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageGroup_member.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageGroup_member.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addGroup_member',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','GROUP_MEMBERDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addGroup_member',                
    'rpc',                                
    'encoded',                            
    'add Group_member'            
);

$server->register('updateGroup_member',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','GROUP_MEMBERDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateGroup_member',                
    'rpc',                                
    'encoded',                            
    'update Group_member'            
);

$server->register('getGroup_memberList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getGroup_memberList',                
    'rpc',                                
    'encoded',                            
    'add Group_member'            
);


$server->register('getGroup_memberByMemberId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getGroup_memberByMemberId',                
    'rpc',                                
    'encoded',                            
    'get Group_member By MemberId'            
);


function addGroup_member($sessionkey, $appcode, $Group_memberdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Group_member = new Group_member();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "GROUPID":{$obj_Group_member->GroupId =  $child;break;};
		case "MEMBERID":{$obj_Group_member->MemberId =  $child;break;};
		case "MEMBERTYPE":{$obj_Group_member->MemberType =  $child;break;};
		case "MEMBERDATE":{$obj_Group_member->MemberDate =  $child;break;};
		case "DESCRIPTION":{$obj_Group_member->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Group_member = DAL_manageGroup_member::addGroup_member($obj_Group_member);
    if ($obj_retResult_Group_member->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getGroup_memberXml($obj_retResult_Group_member->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateGroup_member($sessionkey, $appcode, $Group_memberdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Group_member = new Group_member();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "GROUPID":{$obj_Group_member->GroupId =  $child;break;};
		case "MEMBERID":{$obj_Group_member->MemberId =  $child;break;};
		case "MEMBERTYPE":{$obj_Group_member->MemberType =  $child;break;};
		case "MEMBERDATE":{$obj_Group_member->MemberDate =  $child;break;};
		case "DESCRIPTION":{$obj_Group_member->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Group_member = DAL_manageGroup_member::updateGroup_member($obj_Group_member);
    if ($obj_retResult_Group_member->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getGroup_memberXml($obj_retResult_Group_member->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getGroup_memberList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageGroup_member::getGroup_memberList();
	if($result->type ==1)
	{
	$arr_Group_memberList = $result->data;
		if(count($arr_Group_memberList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<GROUP_MEMBERLIST>";
			 foreach($arr_Group_memberList as $obj_Group_member)
			 {		 
				$main_result .=getGroup_memberXml($obj_Group_member);
			 }
			$main_result .= "</GROUP_MEMBERLIST>";

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

function getGroup_memberXml($obj_Group_member)
{
	$xml  = "<GROUP_MEMBER>";	
		$xml .= "<GROUPID>".$obj_Group_member->GroupId."</GROUPID>";
		$xml .= "<MEMBERID>".$obj_Group_member->MemberId."</MEMBERID>";
		$xml .= "<MEMBERTYPE>".$obj_Group_member->MemberType."</MEMBERTYPE>";
		$xml .= "<MEMBERDATE>".$obj_Group_member->MemberDate."</MEMBERDATE>";
		$xml .= "<DESCRIPTION>".$obj_Group_member->Description."</DESCRIPTION>";

	$xml .= "</GROUP_MEMBER>";
	
	return $xml;
}
	
function getGroup_memberByMemberId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageGroup_member::getGroup_memberListByMemberId($id);
	if($result->type ==1)
	{
	$arr_Group_memberList = $result->data;
		if(count($arr_Group_memberList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Group_memberList as $obj_Group_member)
			 {		 
				$main_result .=getGroup_memberXml($obj_Group_member);
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
