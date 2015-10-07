<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePostalkandy.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePostalkandy.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPostalkandy',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','POSTALKANDYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPostalkandy',                
    'rpc',                                
    'encoded',                            
    'add Postalkandy'            
);

$server->register('updatePostalkandy',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','POSTALKANDYDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePostalkandy',                
    'rpc',                                
    'encoded',                            
    'update Postalkandy'            
);

$server->register('getPostalkandyList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPostalkandyList',                
    'rpc',                                
    'encoded',                            
    'add Postalkandy'            
);


$server->register('getPostalkandyBy',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPostalkandyBy',                
    'rpc',                                
    'encoded',                            
    'get Postalkandy By '            
);


function addPostalkandy($sessionkey, $appcode, $Postalkandydata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Postalkandy = new Postalkandy();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "COL1":{$obj_Postalkandy->col1 =  $child;break;};
		case "COL2":{$obj_Postalkandy->col2 =  $child;break;};
		case "COL3":{$obj_Postalkandy->col3 =  $child;break;};

		}	
	}
	
    $obj_retResult_Postalkandy = DAL_managePostalkandy::addPostalkandy($obj_Postalkandy);
    if ($obj_retResult_Postalkandy->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPostalkandyXml($obj_retResult_Postalkandy->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePostalkandy($sessionkey, $appcode, $Postalkandydata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Postalkandy = new Postalkandy();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "COL1":{$obj_Postalkandy->col1 =  $child;break;};
		case "COL2":{$obj_Postalkandy->col2 =  $child;break;};
		case "COL3":{$obj_Postalkandy->col3 =  $child;break;};

		}	
	}
	
    $obj_retResult_Postalkandy = DAL_managePostalkandy::updatePostalkandy($obj_Postalkandy);
    if ($obj_retResult_Postalkandy->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPostalkandyXml($obj_retResult_Postalkandy->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPostalkandyList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePostalkandy::getPostalkandyList();
	if($result->type ==1)
	{
	$arr_PostalkandyList = $result->data;
		if(count($arr_PostalkandyList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<POSTALKANDYLIST>";
			 foreach($arr_PostalkandyList as $obj_Postalkandy)
			 {		 
				$main_result .=getPostalkandyXml($obj_Postalkandy);
			 }
			$main_result .= "</POSTALKANDYLIST>";

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

function getPostalkandyXml($obj_Postalkandy)
{
	$xml  = "<POSTALKANDY>";	
		$xml .= "<COL1>".$obj_Postalkandy->col1."</COL1>";
		$xml .= "<COL2>".$obj_Postalkandy->col2."</COL2>";
		$xml .= "<COL3>".$obj_Postalkandy->col3."</COL3>";

	$xml .= "</POSTALKANDY>";
	
	return $xml;
}
	
function getPostalkandyBy($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePostalkandy::getPostalkandyListBy($id);
	if($result->type ==1)
	{
	$arr_PostalkandyList = $result->data;
		if(count($arr_PostalkandyList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_PostalkandyList as $obj_Postalkandy)
			 {		 
				$main_result .=getPostalkandyXml($obj_Postalkandy);
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
