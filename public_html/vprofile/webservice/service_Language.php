<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageLanguage.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageLanguage.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addLanguage',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','LANGUAGEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addLanguage',                
    'rpc',                                
    'encoded',                            
    'add Language'            
);

$server->register('updateLanguage',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','LANGUAGEDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updateLanguage',                
    'rpc',                                
    'encoded',                            
    'update Language'            
);

$server->register('getLanguageList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getLanguageList',                
    'rpc',                                
    'encoded',                            
    'add Language'            
);


$server->register('getLanguageByLangId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getLanguageByLangId',                
    'rpc',                                
    'encoded',                            
    'get Language By LangId'            
);


function addLanguage($sessionkey, $appcode, $Languagedata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Language = new Language();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "LANGID":{$obj_Language->LangId =  $child;break;};
		case "LANGTAG":{$obj_Language->LangTag =  $child;break;};
		case "ENGLISH":{$obj_Language->English =  $child;break;};
		case "SINHALA":{$obj_Language->Sinhala =  $child;break;};
		case "TAMIL":{$obj_Language->Tamil =  $child;break;};
		case "BANGLA":{$obj_Language->Bangla =  $child;break;};
		case "NEPALI":{$obj_Language->Nepali =  $child;break;};
		case "LANG1":{$obj_Language->Lang1 =  $child;break;};
		case "LANG2":{$obj_Language->Lang2 =  $child;break;};
		case "LANG3":{$obj_Language->Lang3 =  $child;break;};

		}	
	}
	
    $obj_retResult_Language = DAL_manageLanguage::addLanguage($obj_Language);
    if ($obj_retResult_Language->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getLanguageXml($obj_retResult_Language->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updateLanguage($sessionkey, $appcode, $Languagedata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Language = new Language();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "LANGID":{$obj_Language->LangId =  $child;break;};
		case "LANGTAG":{$obj_Language->LangTag =  $child;break;};
		case "ENGLISH":{$obj_Language->English =  $child;break;};
		case "SINHALA":{$obj_Language->Sinhala =  $child;break;};
		case "TAMIL":{$obj_Language->Tamil =  $child;break;};
		case "BANGLA":{$obj_Language->Bangla =  $child;break;};
		case "NEPALI":{$obj_Language->Nepali =  $child;break;};
		case "LANG1":{$obj_Language->Lang1 =  $child;break;};
		case "LANG2":{$obj_Language->Lang2 =  $child;break;};
		case "LANG3":{$obj_Language->Lang3 =  $child;break;};

		}	
	}
	
    $obj_retResult_Language = DAL_manageLanguage::updateLanguage($obj_Language);
    if ($obj_retResult_Language->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getLanguageXml($obj_retResult_Language->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getLanguageList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_manageLanguage::getLanguageList();
	if($result->type ==1)
	{
	$arr_LanguageList = $result->data;
		if(count($arr_LanguageList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<LANGUAGELIST>";
			 foreach($arr_LanguageList as $obj_Language)
			 {		 
				$main_result .=getLanguageXml($obj_Language);
			 }
			$main_result .= "</LANGUAGELIST>";

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

function getLanguageXml($obj_Language)
{
	$xml  = "<LANGUAGE>";	
		$xml .= "<LANGID>".$obj_Language->LangId."</LANGID>";
		$xml .= "<LANGTAG>".$obj_Language->LangTag."</LANGTAG>";
		$xml .= "<ENGLISH>".$obj_Language->English."</ENGLISH>";
		$xml .= "<SINHALA>".$obj_Language->Sinhala."</SINHALA>";
		$xml .= "<TAMIL>".$obj_Language->Tamil."</TAMIL>";
		$xml .= "<BANGLA>".$obj_Language->Bangla."</BANGLA>";
		$xml .= "<NEPALI>".$obj_Language->Nepali."</NEPALI>";
		$xml .= "<LANG1>".$obj_Language->Lang1."</LANG1>";
		$xml .= "<LANG2>".$obj_Language->Lang2."</LANG2>";
		$xml .= "<LANG3>".$obj_Language->Lang3."</LANG3>";

	$xml .= "</LANGUAGE>";
	
	return $xml;
}
	
function getLanguageByLangId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_manageLanguage::getLanguageListByLangId($id);
	if($result->type ==1)
	{
	$arr_LanguageList = $result->data;
		if(count($arr_LanguageList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_LanguageList as $obj_Language)
			 {		 
				$main_result .=getLanguageXml($obj_Language);
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
