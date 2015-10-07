<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_image.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageVillage_image.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addVillage_image',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_IMAGEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addVillage_image',                
    'rpc',                                
    'encoded',                            
    'add Village_image'            
);

$server->register('updateVillage_image',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','VILLAGE_IMAGEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateVillage_image',                
    'rpc',                                
    'encoded',                            
    'update Village_image'            
);

$server->register('getVillage_imageList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_imageList',                
    'rpc',                                
    'encoded',                            
    'add Village_image'            
);


$server->register('getVillage_imageByPictureId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getVillage_imageByPictureId',                
    'rpc',                                
    'encoded',                            
    'get Village_image By PictureId'            
);


function addVillage_image($sessionkey, $appcode, $Village_imagedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Village_image = new Village_image();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PICTUREID":{$obj_Village_image->PictureId =  $child;break;};
		case "VILLAGEID":{$obj_Village_image->VillageId =  $child;break;};
		case "PICTUREPATH":{$obj_Village_image->PicturePath =  $child;break;};
		case "DESCRIPTION":{$obj_Village_image->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_image = DAL_manageVillage_image::addVillage_image($obj_Village_image);
    if ($obj_retResult_Village_image->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_imageXml($obj_retResult_Village_image->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateVillage_image($sessionkey, $appcode, $Village_imagedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Village_image = new Village_image();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PICTUREID":{$obj_Village_image->PictureId =  $child;break;};
		case "VILLAGEID":{$obj_Village_image->VillageId =  $child;break;};
		case "PICTUREPATH":{$obj_Village_image->PicturePath =  $child;break;};
		case "DESCRIPTION":{$obj_Village_image->Description =  $child;break;};

		}	
	}
	
    $obj_retResult_Village_image = DAL_manageVillage_image::updateVillage_image($obj_Village_image);
    if ($obj_retResult_Village_image->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getVillage_imageXml($obj_retResult_Village_image->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getVillage_imageList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageVillage_image::getVillage_imageList();
	if($result->type ==1)
	{
	$arr_Village_imageList = $result->data;
		if(count($arr_Village_imageList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<VILLAGE_IMAGELIST>";
			 foreach($arr_Village_imageList as $obj_Village_image)
			 {		 
				$main_result .=getVillage_imageXml($obj_Village_image);
			 }
			$main_result .= "</VILLAGE_IMAGELIST>";

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

function getVillage_imageXml($obj_Village_image)
{
	$xml  = "<VILLAGE_IMAGE>";	
		$xml .= "<PICTUREID>".$obj_Village_image->PictureId."</PICTUREID>";
		$xml .= "<VILLAGEID>".$obj_Village_image->VillageId."</VILLAGEID>";
		$xml .= "<PICTUREPATH>".$obj_Village_image->PicturePath."</PICTUREPATH>";
		$xml .= "<DESCRIPTION>".$obj_Village_image->Description."</DESCRIPTION>";

	$xml .= "</VILLAGE_IMAGE>";
	
	return $xml;
}
	
function getVillage_imageByPictureId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageVillage_image::getVillage_imageListByPictureId($id);
	if($result->type ==1)
	{
	$arr_Village_imageList = $result->data;
		if(count($arr_Village_imageList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_Village_imageList as $obj_Village_image)
			 {		 
				$main_result .=getVillage_imageXml($obj_Village_image);
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
