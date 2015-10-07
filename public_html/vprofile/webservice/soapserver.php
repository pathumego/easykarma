<?php
class soapserver2 extends soap_server
{
	
function __construct() {
       parent::__construct();
   }

function addComplexType($complexTypeName , $arrStructureVariables)
{
$arrVariable = array();	
foreach($arrStructureVariables as $key=>$value)
{
	$arrVariable[$value] = array('name' => $value, 'type' => 'xsd:string');
}

$this->wsdl->addComplexType(
    $complexTypeName,
    'complexType',
    'struct',
    'all',
    '',
   $arrVariable
   );
}	
	
}

?>