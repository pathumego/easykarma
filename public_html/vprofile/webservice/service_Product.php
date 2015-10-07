<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageProduct.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageProduct.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addProduct',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PRODUCTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addProduct',                
    'rpc',                                
    'encoded',                            
    'add Product'            
);

$server->register('updateProduct',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PRODUCTDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateProduct',                
    'rpc',                                
    'encoded',                            
    'update Product'            
);

$server->register('getProductList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getProductList',                
    'rpc',                                
    'encoded',                            
    'add Product'            
);


$server->register('getProductByProductId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getProductByProductId',                
    'rpc',                                
    'encoded',                            
    'get Product By ProductId'            
);


function addProduct($sessionkey, $appcode, $Productdata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Product = new Product();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PRODUCTID":{$obj_Product->ProductId =  $child;break;};
		case "PRODUCTNAME":{$obj_Product->ProductName =  $child;break;};
		case "EXPIREDURATION":{$obj_Product->ExpireDuration =  $child;break;};
		case "DESCRIPTION":{$obj_Product->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Product = DAL_manageProduct::addProduct($obj_Product);
    if ($obj_retResult_Product->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getProductXml($obj_retResult_Product->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateProduct($sessionkey, $appcode, $Productdata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Product = new Product();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PRODUCTID":{$obj_Product->ProductId =  $child;break;};
		case "PRODUCTNAME":{$obj_Product->ProductName =  $child;break;};
		case "EXPIREDURATION":{$obj_Product->ExpireDuration =  $child;break;};
		case "DESCRIPTION":{$obj_Product->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Product = DAL_manageProduct::updateProduct($obj_Product);
    if ($obj_retResult_Product->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getProductXml($obj_retResult_Product->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getProductList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageProduct::getProductList();
	if($result->type ==1)
	{
	$arr_ProductList = $result->data;
		if(count($arr_ProductList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PRODUCTLIST>";
			 foreach($arr_ProductList as $obj_Product)
			 {		 
				$main_result .=getProductXml($obj_Product);
			 }
			$main_result .= "</PRODUCTLIST>";

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

function getProductXml($obj_Product)
{
	$xml  = "<PRODUCT>";	
		$xml .= "<PRODUCTID>".$obj_Product->ProductId."</PRODUCTID>";
		$xml .= "<PRODUCTNAME>".$obj_Product->ProductName."</PRODUCTNAME>";
		$xml .= "<EXPIREDURATION>".$obj_Product->ExpireDuration."</EXPIREDURATION>";
		$xml .= "<DESCRIPTION>".$obj_Product->Description."</DESCRIPTION>";

	$xml .= "</PRODUCT>";
	
	return $xml;
}
	
function getProductByProductId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageProduct::getProductListByProductId($id);
	if($result->type ==1)
	{
	$arr_ProductList = $result->data;
		if(count($arr_ProductList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_ProductList as $obj_Product)
			 {		 
				$main_result .=getProductXml($obj_Product);
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
