<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageBusiness_product.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageBusiness_product.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addBusiness_product',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','BUSINESS_PRODUCTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addBusiness_product',                
    'rpc',                                
    'encoded',                            
    'add Business_product'            
);

$server->register('updateBusiness_product',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','BUSINESS_PRODUCTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateBusiness_product',                
    'rpc',                                
    'encoded',                            
    'update Business_product'            
);

$server->register('getBusiness_productList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getBusiness_productList',                
    'rpc',                                
    'encoded',                            
    'add Business_product'            
);


$server->register('getBusiness_productByProductId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getBusiness_productByProductId',                
    'rpc',                                
    'encoded',                            
    'get Business_product By ProductId'            
);


function addBusiness_product($sessionkey, $appcode, $Business_productdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Business_product = new Business_product();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "BUSINESSID":{$obj_Business_product->BusinessId =  $child;break;};
		case "PRODUCTID":{$obj_Business_product->ProductId =  $child;break;};

		}	
	}
	
    $obj_retResult_Business_product = DAL_manageBusiness_product::addBusiness_product($obj_Business_product);
    if ($obj_retResult_Business_product->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getBusiness_productXml($obj_retResult_Business_product->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateBusiness_product($sessionkey, $appcode, $Business_productdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Business_product = new Business_product();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "BUSINESSID":{$obj_Business_product->BusinessId =  $child;break;};
		case "PRODUCTID":{$obj_Business_product->ProductId =  $child;break;};

		}	
	}
	
    $obj_retResult_Business_product = DAL_manageBusiness_product::updateBusiness_product($obj_Business_product);
    if ($obj_retResult_Business_product->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getBusiness_productXml($obj_retResult_Business_product->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getBusiness_productList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageBusiness_product::getBusiness_productList();
	if($result->type ==1)
	{
	$arr_Business_productList = $result->data;
		if(count($arr_Business_productList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<BUSINESS_PRODUCTLIST>";
			 foreach($arr_Business_productList as $obj_Business_product)
			 {		 
				$main_result .=getBusiness_productXml($obj_Business_product);
			 }
			$main_result .= "</BUSINESS_PRODUCTLIST>";

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

function getBusiness_productXml($obj_Business_product)
{
	$xml  = "<BUSINESS_PRODUCT>";	
		$xml .= "<BUSINESSID>".$obj_Business_product->BusinessId."</BUSINESSID>";
		$xml .= "<PRODUCTID>".$obj_Business_product->ProductId."</PRODUCTID>";

	$xml .= "</BUSINESS_PRODUCT>";
	
	return $xml;
}
	
function getBusiness_productByProductId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageBusiness_product::getBusiness_productListByProductId($id);
	if($result->type ==1)
	{
	$arr_Business_productList = $result->data;
		if(count($arr_Business_productList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Business_productList as $obj_Business_product)
			 {		 
				$main_result .=getBusiness_productXml($obj_Business_product);
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
