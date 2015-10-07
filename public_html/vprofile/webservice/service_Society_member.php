<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageSociety_member.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageSociety_member.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addSociety_member',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','SOCIETY_MEMBERDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addSociety_member',                
    'rpc',                                
    'encoded',                            
    'add Society_member'            
);

$server->register('updateSociety_member',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','SOCIETY_MEMBERDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateSociety_member',                
    'rpc',                                
    'encoded',                            
    'update Society_member'            
);

$server->register('getSociety_memberList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getSociety_memberList',                
    'rpc',                                
    'encoded',                            
    'add Society_member'            
);


$server->register('getSociety_memberByMemberId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getSociety_memberByMemberId',                
    'rpc',                                
    'encoded',                            
    'get Society_member By MemberId'            
);


function addSociety_member($sessionkey, $appcode, $Society_memberdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Society_member = new Society_member();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "VILLAGESOCIETYID":{$obj_Society_member->VillageSocietyId =  $child;break;};
		case "MEMBERID":{$obj_Society_member->MemberId =  $child;break;};
		case "MEMBERTYPE":{$obj_Society_member->MemberType =  $child;break;};
		case "MEMBERDATE":{$obj_Society_member->MemberDate =  $child;break;};
		case "DESCRIPTION":{$obj_Society_member->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Society_member = DAL_manageSociety_member::addSociety_member($obj_Society_member);
    if ($obj_retResult_Society_member->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getSociety_memberXml($obj_retResult_Society_member->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateSociety_member($sessionkey, $appcode, $Society_memberdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Society_member = new Society_member();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "VILLAGESOCIETYID":{$obj_Society_member->VillageSocietyId =  $child;break;};
		case "MEMBERID":{$obj_Society_member->MemberId =  $child;break;};
		case "MEMBERTYPE":{$obj_Society_member->MemberType =  $child;break;};
		case "MEMBERDATE":{$obj_Society_member->MemberDate =  $child;break;};
		case "DESCRIPTION":{$obj_Society_member->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Society_member = DAL_manageSociety_member::updateSociety_member($obj_Society_member);
    if ($obj_retResult_Society_member->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getSociety_memberXml($obj_retResult_Society_member->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getSociety_memberList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageSociety_member::getSociety_memberList();
	if($result->type ==1)
	{
	$arr_Society_memberList = $result->data;
		if(count($arr_Society_memberList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<SOCIETY_MEMBERLIST>";
			 foreach($arr_Society_memberList as $obj_Society_member)
			 {		 
				$main_result .=getSociety_memberXml($obj_Society_member);
			 }
			$main_result .= "</SOCIETY_MEMBERLIST>";

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

function getSociety_memberXml($obj_Society_member)
{
	$xml  = "<SOCIETY_MEMBER>";	
		$xml .= "<VILLAGESOCIETYID>".$obj_Society_member->VillageSocietyId."</VILLAGESOCIETYID>";
		$xml .= "<MEMBERID>".$obj_Society_member->MemberId."</MEMBERID>";
		$xml .= "<MEMBERTYPE>".$obj_Society_member->MemberType."</MEMBERTYPE>";
		$xml .= "<MEMBERDATE>".$obj_Society_member->MemberDate."</MEMBERDATE>";
		$xml .= "<DESCRIPTION>".$obj_Society_member->Description."</DESCRIPTION>";

	$xml .= "</SOCIETY_MEMBER>";
	
	return $xml;
}
	
function getSociety_memberByMemberId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageSociety_member::getSociety_memberListByMemberId($id);
	if($result->type ==1)
	{
	$arr_Society_memberList = $result->data;
		if(count($arr_Society_memberList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Society_memberList as $obj_Society_member)
			 {		 
				$main_result .=getSociety_memberXml($obj_Society_member);
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
