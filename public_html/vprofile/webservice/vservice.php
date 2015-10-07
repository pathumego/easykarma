<?php 
//ini_set("error_reporting","E_ALL^E_STRICT");
date_default_timezone_set('Asia/Colombo');
require_once('nusoap/lib/nusoap.php');
require_once('soapserver.php');
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageUser.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageWebService.php");


$NAMESPACE = 'http://localhost:8000/vprofile2/webservice';
$server = new soapserver2();
$server->configureWSDL('vprofilewsdl', $NAMESPACE);
$server->wsdl->schemaTargetNamespace = $NAMESPACE;

require_once('service_Agriculture.php');
require_once('service_Alsubjects.php');
require_once('service_Business.php');
require_once('service_Business_product.php');
require_once('service_Businesstype.php');
require_once('service_Foresttype.php');
require_once('service_Geographytype.php');
require_once('service_Group.php');
require_once('service_Group_member.php');
require_once('service_Groupmissiontype.php');
require_once('service_Higherstudysubjects.php');
require_once('service_Industrial.php');
require_once('service_Language.php');
require_once('service_Location.php');
require_once('service_Location_resources.php');
require_once('service_Olsubjects.php');
require_once('service_Organization.php');
require_once('service_Organization_subtype.php');
require_once('service_Organizationtype.php');
require_once('service_Person.php');
require_once('service_Person_address.php');
require_once('service_Person_alresult.php');
require_once('service_Person_educationlevel.php');
require_once('service_Person_highereducation.php');
require_once('service_Person_languageskill.php');
require_once('service_Person_olresult.php');
require_once('service_Person_property.php');
require_once('service_Person_talent.php');
require_once('service_Person_telephone.php');
require_once('service_Person_vocationaltraining.php');
require_once('service_Person_workingexperiance.php');
require_once('service_Plants.php');
require_once('service_Primarygeolayertype.php');
require_once('service_Product.php');
require_once('service_Service.php');
require_once('service_Socierytype.php');
require_once('service_Society.php');
require_once('service_Society_member.php');
require_once('service_Soiltype.php');
require_once('service_Talent.php');
require_once('service_Town.php');
require_once('service_Trading.php');
require_once('service_Traditionalknowledgecategory.php');
require_once('service_Transport.php');
require_once('service_User.php');
require_once('service_Village.php');
require_once('service_Village_agriculture.php');
require_once('service_Village_climate.php');
require_once('service_Village_enterance.php');
require_once('service_Village_geologicalvariation.php');
require_once('service_Village_group.php');
require_once('service_Village_history.php');
require_once('service_Village_image.php');
require_once('service_Village_industrial.php');
require_once('service_Village_neartowns.php');
require_once('service_Village_organization.php');
require_once('service_Village_othernames.php');
require_once('service_Village_plant.php');
require_once('service_Village_service.php');
require_once('service_Village_society.php');
require_once('service_Village_trading.php');
require_once('service_Village_traditionalknowledge.php');
require_once('service_Village_transport.php');



$server->wsdl->addComplexType(
    'AUTHRETURN',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'VALIDSTATUS' => array('name' => 'VALIDSTATUS', 'type' => 'xsd:string'),
        'SESSIONKEY' => array('name' => 'SESSIONKEY', 'type' => 'xsd:string'),
        'MESSAGE' => array('name' => 'MESSAGE', 'type' => 'xsd:string')
    )
);

        
//-----------------------------------------------------------------------------------------------------------

$server->register('Authentication',              
    array('USERNAME' => 'xsd:string','PASSWORD' => 'xsd:string', 'APPCODE' => 'xsd:string'),        
    array('RETURN' => 'tns:AUTHRETURN'),     
    $NAMESPACE,                      
    $NAMESPACE.'#Authentication',                
    'rpc',                                
    'encoded',                            
    'user authentication'            
);

$server->register('ping',              
    array('VALUE' => 'xsd:string'),        
    array('RETURN' => 'xsd:string'),     
    $NAMESPACE,                      
    $NAMESPACE.'#ping',                
    'rpc',                                
    'encoded',                            
    'hello'           
);

//-----------------------------------------------------------------------------------------------------------

function ping($value) {

    return 'ping:'.$value;
}


function Authentication($userName, $password, $appcode)
{
$obj_result = BL_manageWebService::webservice_authentication($userName, $password);
$returnArr = array('VALIDSTATUS' => "",'SESSIONKEY' =>"",'MESSAGE' =>"");

            if ($obj_result->type == 1)
            {
            	$returnArr = 	$obj_result->data;	
				
            }
            else
            {			
				$isValid = 0;
                $errorMsg =$obj_result->msg;	
				$sessionkey = "";
				$returnArr = array('VALIDSTATUS' => $isValid,'SESSIONKEY' =>$sessionkey,'MESSAGE' =>$errorMsg);	
            }
			
	return $returnArr;
 
}

//-----------------------------------------------------------------------------------------------------------

function ValidateSession($sessionKey,$appcode)
{
	$validUId = -1;
	
  if(IsValidAppCode($appcode))
  {	 
	   $obj_result = BL_manageWebService::validateSession($sessionKey);
	   if($obj_result->type ==1)
	   {   	
			$validUId = $obj_result->data->userId;
	   }
  }
  return $validUId;
}

function IsValidAppCode($appcode)
{
$result = false;
$allApps = array("KJHH776DSFHSD34MN3J", "SKJHFJS76SD65FSD5F", "SDF7SDF87S6EF876SEDF7", "FG89F7HF87B6BFGB");
if (in_array($appcode, $allApps)) {
   $result = true;
}
return $result;
}

//-----------------------------------------------------------------------------------------------------------

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
