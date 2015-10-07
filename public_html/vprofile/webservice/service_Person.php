<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_managePerson.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");

$server->register('addPerson',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#addPerson',                
    'rpc',                                
    'encoded',                            
    'add Person'            
);

$server->register('updatePerson',              
	array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PERSONDATA' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#updatePerson',                
    'rpc',                                
    'encoded',                            
    'update Person'            
);

$server->register('getPersonList',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','PAGING' => 'xsd:text/xml'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPersonList',                
    'rpc',                                
    'encoded',                            
    'add Person'            
);


$server->register('getPersonByPersonId',              
    array('SESSIONKEY' => 'xsd:string','APPCODE' => 'xsd:string','ID' => 'xsd:string'),        
    array('RETURN' => 'xsd:text/xml'),     
    $NAMESPACE,                      
    $NAMESPACE.'#getPersonByPersonId',                
    'rpc',                                
    'encoded',                            
    'get Person By PersonId'            
);


function addPerson($sessionkey, $appcode, $Persondata)
{

  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
 
	$obj_Person = new Person();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PERSONID":{$obj_Person->PersonId =  $child;break;};
		case "FULLNAME":{$obj_Person->FullName =  $child;break;};
		case "NICKNAME":{$obj_Person->NickName =  $child;break;};
		case "OTHERNAMES":{$obj_Person->OtherNames =  $child;break;};
		case "DRIVINGLICENCENO":{$obj_Person->DrivingLicenceNo =  $child;break;};
		case "PASSPORTNO":{$obj_Person->PassportNo =  $child;break;};
		case "PERMANENTADDRESS":{$obj_Person->PermanentAddress =  $child;break;};
		case "EMAIL":{$obj_Person->Email =  $child;break;};
		case "WEBSITE":{$obj_Person->Website =  $child;break;};
		case "DESCRIPTION":{$obj_Person->Description =  $child;break;};
		case "GENDER":{$obj_Person->Gender =  $child;break;};
		case "DOB":{$obj_Person->DOB =  $child;break;};
		case "HEIGHT":{$obj_Person->Height =  $child;break;};
		case "WEIGHT":{$obj_Person->Weight =  $child;break;};
		case "HAIRCOLOR":{$obj_Person->HairColor =  $child;break;};
		case "EYECOLOR":{$obj_Person->EyeColor =  $child;break;};
		case "BLOODTYPE":{$obj_Person->BloodType =  $child;break;};
		case "OCCUPATION":{$obj_Person->Occupation =  $child;break;};
		case "MONTHLYINCOME":{$obj_Person->MonthlyIncome =  $child;break;};
		case "FUTURETARGETS":{$obj_Person->FutureTargets =  $child;break;};
		case "FUTURENEEDS":{$obj_Person->FutureNeeds =  $child;break;};
		case "DOD":{$obj_Person->DOD =  $child;break;};
		case "PICTURE":{$obj_Person->Picture =  $child;break;};
		case "NIC":{$obj_Person->NIC =  $child;break;};
		case "STATUS":{$obj_Person->Status =  $child;break;};

		}	
	}
	
    $obj_retResult_Person = DAL_managePerson::addPerson($obj_Person);
    if ($obj_retResult_Person->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPersonXml($obj_retResult_Person->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;
}
	
function updatePerson($sessionkey, $appcode, $Persondata)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
	$main_result = "<AUTHSTATUS>1</AUTHSTATUS>";
	$obj_Person = new Person();
	
	foreach($Userdata["[UPPERTEMPLATENAME"] as $key => $child)
	{  
		switch($key)
		{
		case "PERSONID":{$obj_Person->PersonId =  $child;break;};
		case "FULLNAME":{$obj_Person->FullName =  $child;break;};
		case "NICKNAME":{$obj_Person->NickName =  $child;break;};
		case "OTHERNAMES":{$obj_Person->OtherNames =  $child;break;};
		case "DRIVINGLICENCENO":{$obj_Person->DrivingLicenceNo =  $child;break;};
		case "PASSPORTNO":{$obj_Person->PassportNo =  $child;break;};
		case "PERMANENTADDRESS":{$obj_Person->PermanentAddress =  $child;break;};
		case "EMAIL":{$obj_Person->Email =  $child;break;};
		case "WEBSITE":{$obj_Person->Website =  $child;break;};
		case "DESCRIPTION":{$obj_Person->Description =  $child;break;};
		case "GENDER":{$obj_Person->Gender =  $child;break;};
		case "DOB":{$obj_Person->DOB =  $child;break;};
		case "HEIGHT":{$obj_Person->Height =  $child;break;};
		case "WEIGHT":{$obj_Person->Weight =  $child;break;};
		case "HAIRCOLOR":{$obj_Person->HairColor =  $child;break;};
		case "EYECOLOR":{$obj_Person->EyeColor =  $child;break;};
		case "BLOODTYPE":{$obj_Person->BloodType =  $child;break;};
		case "OCCUPATION":{$obj_Person->Occupation =  $child;break;};
		case "MONTHLYINCOME":{$obj_Person->MonthlyIncome =  $child;break;};
		case "FUTURETARGETS":{$obj_Person->FutureTargets =  $child;break;};
		case "FUTURENEEDS":{$obj_Person->FutureNeeds =  $child;break;};
		case "DOD":{$obj_Person->DOD =  $child;break;};
		case "PICTURE":{$obj_Person->Picture =  $child;break;};
		case "NIC":{$obj_Person->NIC =  $child;break;};
		case "STATUS":{$obj_Person->Status =  $child;break;};

		}	
	}
	
    $obj_retResult_Person = DAL_managePerson::updatePerson($obj_Person);
    if ($obj_retResult_Person->type ==1)
	{
		$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
		$main_result .= getPersonXml($obj_retResult_Person->data);
	}
	else
	{
		$main_result .= "<RESULTSTATUS>0</RESULTSTATUS>";	
	} 
  
  }
  $main_result .= "</VPROFILERESULT>";
  return $main_result;

}

function getPersonList($sessionkey, $appcode, $paging)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey, $appcode);  
  
if($userId > -1)
{
$main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
$result =BL_managePerson::getPersonList();
	if($result->type ==1)
	{
	$arr_PersonList = $result->data;
		if(count($arr_PersonList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";
			$main_result .= "<PERSONLIST>";
			 foreach($arr_PersonList as $obj_Person)
			 {		 
				$main_result .=getPersonXml($obj_Person);
			 }
			$main_result .= "</PERSONLIST>";

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

function getPersonXml($obj_Person)
{
	$xml  = "<PERSON>";	
		$xml .= "<PERSONID>".$obj_Person->PersonId."</PERSONID>";
		$xml .= "<FULLNAME>".$obj_Person->FullName."</FULLNAME>";
		$xml .= "<NICKNAME>".$obj_Person->NickName."</NICKNAME>";
		$xml .= "<OTHERNAMES>".$obj_Person->OtherNames."</OTHERNAMES>";
		$xml .= "<DRIVINGLICENCENO>".$obj_Person->DrivingLicenceNo."</DRIVINGLICENCENO>";
		$xml .= "<PASSPORTNO>".$obj_Person->PassportNo."</PASSPORTNO>";
		$xml .= "<PERMANENTADDRESS>".$obj_Person->PermanentAddress."</PERMANENTADDRESS>";
		$xml .= "<EMAIL>".$obj_Person->Email."</EMAIL>";
		$xml .= "<WEBSITE>".$obj_Person->Website."</WEBSITE>";
		$xml .= "<DESCRIPTION>".$obj_Person->Description."</DESCRIPTION>";
		$xml .= "<GENDER>".$obj_Person->Gender."</GENDER>";
		$xml .= "<DOB>".$obj_Person->DOB."</DOB>";
		$xml .= "<HEIGHT>".$obj_Person->Height."</HEIGHT>";
		$xml .= "<WEIGHT>".$obj_Person->Weight."</WEIGHT>";
		$xml .= "<HAIRCOLOR>".$obj_Person->HairColor."</HAIRCOLOR>";
		$xml .= "<EYECOLOR>".$obj_Person->EyeColor."</EYECOLOR>";
		$xml .= "<BLOODTYPE>".$obj_Person->BloodType."</BLOODTYPE>";
		$xml .= "<OCCUPATION>".$obj_Person->Occupation."</OCCUPATION>";
		$xml .= "<MONTHLYINCOME>".$obj_Person->MonthlyIncome."</MONTHLYINCOME>";
		$xml .= "<FUTURETARGETS>".$obj_Person->FutureTargets."</FUTURETARGETS>";
		$xml .= "<FUTURENEEDS>".$obj_Person->FutureNeeds."</FUTURENEEDS>";
		$xml .= "<DOD>".$obj_Person->DOD."</DOD>";
		$xml .= "<PICTURE>".$obj_Person->Picture."</PICTURE>";
		$xml .= "<NIC>".$obj_Person->NIC."</NIC>";
		$xml .= "<STATUS>".$obj_Person->Status."</STATUS>";

	$xml .= "</PERSON>";
	
	return $xml;
}
	
function getPersonByPersonId($sessionkey, $appcode, $id)
{
  $main_result = "<VPROFILERESULT>";
  $main_result .= "<AUTHSTATUS>0</AUTHSTATUS>";
  $userId = ValidateSession($sessionkey,$appcode);  
  if($userId > -1)
  {
  $main_result .= "<AUTHSTATUS>1</AUTHSTATUS>";
	$result =BL_managePerson::getPersonListByPersonId($id);
	if($result->type ==1)
	{
	$arr_PersonList = $result->data;
		if(count($arr_PersonList)>0)
		{ 
			$main_result .= "<RESULTSTATUS>1</RESULTSTATUS>";			
			 foreach($arr_PersonList as $obj_Person)
			 {		 
				$main_result .=getPersonXml($obj_Person);
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
