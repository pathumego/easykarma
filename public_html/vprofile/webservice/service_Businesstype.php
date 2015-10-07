<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageBusinesstype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageBusinesstype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addBusinesstype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','BUSINESSTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addBusinesstype',                
    'rpc',                                
    'encoded',                            
    'add Businesstype'            
);

$server->register('updateBusinesstype',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','BUSINESSTYPEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateBusinesstype',                
    'rpc',                                
    'encoded',                            
    'update Businesstype'            
);

$server->register('getBusinesstypeList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getBusinesstypeList',                
    'rpc',                                
    'encoded',                            
    'add Businesstype'            
);


$server->register('getBusinesstypeByBusinessTypeId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getBusinesstypeByBusinessTypeId',                
    'rpc',                                
    'encoded',                            
    'get Businesstype By BusinessTypeId'            
);


function addBusinesstype($sessionkey, $appcode, $Businesstypedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Businesstype = new Businesstype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "BUSINESSTYPEID":{$obj_Businesstype->BusinessTypeId =  $child;break;};
		case "BUSINESSTYPENAME":{$obj_Businesstype->BusinessTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Businesstype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Businesstype = DAL_manageBusinesstype::addBusinesstype($obj_Businesstype);
    if ($obj_retResult_Businesstype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getBusinesstypeXml($obj_retResult_Businesstype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateBusinesstype($sessionkey, $appcode, $Businesstypedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Businesstype = new Businesstype();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "BUSINESSTYPEID":{$obj_Businesstype->BusinessTypeId =  $child;break;};
		case "BUSINESSTYPENAME":{$obj_Businesstype->BusinessTypeName =  $child;break;};
		case "DESCRIPTION":{$obj_Businesstype->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Businesstype = DAL_manageBusinesstype::updateBusinesstype($obj_Businesstype);
    if ($obj_retResult_Businesstype->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getBusinesstypeXml($obj_retResult_Businesstype->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getBusinesstypeList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageBusinesstype::getBusinesstypeList();
	if($result->type ==1)
	{
	$arr_BusinesstypeList = $result->data;
		if(count($arr_BusinesstypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<BUSINESSTYPELIST>";
			 foreach($arr_BusinesstypeList as $obj_Businesstype)
			 {		 
				$main_result .=getBusinesstypeXml($obj_Businesstype);
			 }
			$main_result .= "</BUSINESSTYPELIST>";

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

function getBusinesstypeXml($obj_Businesstype)
{
	$xml  = "<BUSINESSTYPE>";	
		$xml .= "<BUSINESSTYPEID>".$obj_Businesstype->BusinessTypeId."</BUSINESSTYPEID>";
		$xml .= "<BUSINESSTYPENAME>".$obj_Businesstype->BusinessTypeName."</BUSINESSTYPENAME>";
		$xml .= "<DESCRIPTION>".$obj_Businesstype->Description."</DESCRIPTION>";

	$xml .= "</BUSINESSTYPE>";
	
	return $xml;
}
	
function getBusinesstypeByBusinessTypeId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageBusinesstype::getBusinesstypeListByBusinessTypeId($id);
	if($result->type ==1)
	{
	$arr_BusinesstypeList = $result->data;
		if(count($arr_BusinesstypeList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_BusinesstypeList as $obj_Businesstype)
			 {		 
				$main_result .=getBusinesstypeXml($obj_Businesstype);
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
