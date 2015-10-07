<?php
require_once('nusoap/lib/nusoap.php');
$server = new nusoap_server;
$server->configureWSDL("server", "urn:server");
$server->wsdl->schemaTargetNamespace = "urn:server";
$server->register("pollServer",

array("name" => "xsd:string", "surname" => "xsd:string"),
array("return" => "xsd:string"),
"urn:server",
"urn:server#pollServer");

function pollServer($value,$value2)
{

$name = isset($value["name"]) ? $value["name"] : "";
$surname = isset($value['surname']) ? $value["surname"] : "";

if( $name !== "" && $surname !== "" )
{
return $value ." $value2 have been Registered";
}else
{
return "Not registered!!";
}
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";

$server->service($HTTP_RAW_POST_DATA);
?>
