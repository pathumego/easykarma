<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageUser.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageUser.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addUser',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','USERDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addUser',                
    'rpc',                                
    'encoded',                            
    'add User'            
);

$server->register('updateUser',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','USERDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateUser',                
    'rpc',                                
    'encoded',                            
    'update User'            
);

$server->register('getUserList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getUserList',                
    'rpc',                                
    'encoded',                            
    'add User'            
);


$server->register('getUserByuserId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getUserByuserId',                
    'rpc',                                
    'encoded',                            
    'get User By userId'            
);


function addUser($sessionkey, $appcode, $Userdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_User = new User();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "USERID":{$obj_User->userId =  $child;break;};
		case "USERNAME":{$obj_User->userName =  $child;break;};
		case "PASSWORD":{$obj_User->password =  $child;break;};
		case "PERSONID":{$obj_User->personId =  $child;break;};
		case "USERTYPE":{$obj_User->userType =  $child;break;};
		case "USEROPTCODE":{$obj_User->userOptCode =  $child;break;};
		case "USERMETADATA":{$obj_User->userMetadata =  $child;break;};
		case "USERSTATUS":{$obj_User->userStatus =  $child;break;};

		}	
	}
	
    $obj_retResult_User = DAL_manageUser::addUser($obj_User);
    if ($obj_retResult_User->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getUserXml($obj_retResult_User->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateUser($sessionkey, $appcode, $Userdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_User = new User();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "USERID":{$obj_User->userId =  $child;break;};
		case "USERNAME":{$obj_User->userName =  $child;break;};
		case "PASSWORD":{$obj_User->password =  $child;break;};
		case "PERSONID":{$obj_User->personId =  $child;break;};
		case "USERTYPE":{$obj_User->userType =  $child;break;};
		case "USEROPTCODE":{$obj_User->userOptCode =  $child;break;};
		case "USERMETADATA":{$obj_User->userMetadata =  $child;break;};
		case "USERSTATUS":{$obj_User->userStatus =  $child;break;};

		}	
	}
	
    $obj_retResult_User = DAL_manageUser::updateUser($obj_User);
    if ($obj_retResult_User->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getUserXml($obj_retResult_User->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getUserList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageUser::getUserList();
	if($result->type ==1)
	{
	$arr_UserList = $result->data;
		if(count($arr_UserList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<USERLIST>";
			 foreach($arr_UserList as $obj_User)
			 {		 
				$main_result .=getUserXml($obj_User);
			 }
			$main_result .= "</USERLIST>";

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

function getUserXml($obj_User)
{
	$xml  = "<USER>";	
		$xml .= "<USERID>".$obj_User->userId."</USERID>";
		$xml .= "<USERNAME>".$obj_User->userName."</USERNAME>";
		$xml .= "<PASSWORD>".$obj_User->password."</PASSWORD>";
		$xml .= "<PERSONID>".$obj_User->personId."</PERSONID>";
		$xml .= "<USERTYPE>".$obj_User->userType."</USERTYPE>";
		$xml .= "<USEROPTCODE>".$obj_User->userOptCode."</USEROPTCODE>";
		$xml .= "<USERMETADATA>".$obj_User->userMetadata."</USERMETADATA>";
		$xml .= "<USERSTATUS>".$obj_User->userStatus."</USERSTATUS>";

	$xml .= "</USER>";
	
	return $xml;
}
	
function getUserByuserId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageUser::getUserListByuserId($id);
	if($result->type ==1)
	{
	$arr_UserList = $result->data;
		if(count($arr_UserList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_UserList as $obj_User)
			 {		 
				$main_result .=getUserXml($obj_User);
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
