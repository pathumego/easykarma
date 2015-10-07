<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageWebservicecall.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageWebservicecall.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addWebservicecall',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','WEBSERVICECALLDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addWebservicecall',                
    'rpc',                                
    'encoded',                            
    'add Webservicecall'            
);

$server->register('updateWebservicecall',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','WEBSERVICECALLDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateWebservicecall',                
    'rpc',                                
    'encoded',                            
    'update Webservicecall'            
);

$server->register('getWebservicecallList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getWebservicecallList',                
    'rpc',                                
    'encoded',                            
    'add Webservicecall'            
);


$server->register('getWebservicecallByid',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getWebservicecallByid',                
    'rpc',                                
    'encoded',                            
    'get Webservicecall By id'            
);


function addWebservicecall($sessionkey, $appcode, $Webservicecalldata)
{
  $main_result = "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
  $xml=simplexml_load_string($Webservicecalldata);
	
	$obj_Webservicecall = new Webservicecall();
	
	foreach($xml->children() as $child)
	{  
		switch($child->getName())
		{
		case "ID":{$obj_Webservicecall->id =  $child;break;};
		case "USERNAME":{$obj_Webservicecall->userName =  $child;break;};
		case "USERID":{$obj_Webservicecall->userId =  $child;break;};
		case "SESSIONKEY":{$obj_Webservicecall->sessionKey =  $child;break;};
		case "STARTTIME":{$obj_Webservicecall->startTime =  $child;break;};
		case "LASTUPDATETIME":{$obj_Webservicecall->lastUpdateTime =  $child;break;};

		}	
	}
	
    $obj_retResult_Webservicecall = DAL_manageWebservicecall::addWebservicecall($obj_Webservicecall);
    if ($obj_retResult_Person->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getWebservicecallXml($obj_retResult_Webservicecall->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  return $main_result;
}
	
function updateWebservicecall($sessionkey, $appcode, $Webservicecalldata)
{
  $main_result = "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$xml=simplexml_load_string($Webservicecalldata);
	
	$obj_Webservicecall = new Webservicecall();
	
	foreach($xml->children() as $child)
	{  
		switch($child->getName())
		{
		case "ID":{$obj_Webservicecall->id =  $child;break;};
		case "USERNAME":{$obj_Webservicecall->userName =  $child;break;};
		case "USERID":{$obj_Webservicecall->userId =  $child;break;};
		case "SESSIONKEY":{$obj_Webservicecall->sessionKey =  $child;break;};
		case "STARTTIME":{$obj_Webservicecall->startTime =  $child;break;};
		case "LASTUPDATETIME":{$obj_Webservicecall->lastUpdateTime =  $child;break;};

		}	
	}
	
    $obj_retResult_Webservicecall = DAL_manageWebservicecall::updateWebservicecall($obj_Webservicecall);
    if ($obj_retResult_Person->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getWebservicecallXml($obj_retResult_Webservicecall->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  return $main_result;

}

function getWebservicecallList($sessionkey, $appcode, $paging)
{
  $main_result = "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageWebservicecall::getWebservicecallList();
	if($result->type ==1)
	{
	$arr_PersonList = $result->data;
		if(count($arr_WebservicecallList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<WEBSERVICECALLLIST>";
			 foreach($arr_WebservicecallList as $obj_Webservicecall)
			 {		 
				$main_result .=getPersonXml($obj_Webservicecall);
			 }
			$main_result .= "</WEBSERVICECALLLIST>";

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
return $main_result;

}

function getWebservicecallXml($obj_Webservicecall)
{
	$xml  = "<PERSON>";	
		$xml .= "<ID>".$obj_Webservicecall->id."</ID>";
		$xml .= "<USERNAME>".$obj_Webservicecall->userName."</USERNAME>";
		$xml .= "<USERID>".$obj_Webservicecall->userId."</USERID>";
		$xml .= "<SESSIONKEY>".$obj_Webservicecall->sessionKey."</SESSIONKEY>";
		$xml .= "<STARTTIME>".$obj_Webservicecall->startTime."</STARTTIME>";
		$xml .= "<LASTUPDATETIME>".$obj_Webservicecall->lastUpdateTime."</LASTUPDATETIME>";

	$xml .= "</PERSON>";
	
	return $xml;
}
	
function getWebservicecallByid($sessionkey, $appcode, $id)
{
  $main_result = "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageWebservicecall::getWebservicecallListByid($id);
	if($result->type ==1)
	{
	$arr_WebservicecallList = $result->data;
		if(count($arr_WebservicecallList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<WEBSERVICECALLLIST>";
			 foreach($arr_WebservicecallList as $obj_Webservicecall)
			 {		 
				$main_result .=getWebservicecallXml($obj_Webservicecall);
			 }
			 $main_result .= "</WEBSERVICECALLLIST>";
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
  return $main_result;

}	
?>
