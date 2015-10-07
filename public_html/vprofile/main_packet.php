<?php
class mainpacket
{
public $stationId;
public $moduleId;
public $actionId;
public $packet;
public $returnValues;

//-------------------------------------------------------------------------------------

function get_incomming_Packet($packetText)
{
	$arr_mainpacket = explode(";", $packetText);
	$_SESSION["stationid"] = $this->stationId = $arr_mainpacket[0];
	$this->moduleId = $arr_mainpacket[1];
	$this->actionId = $arr_mainpacket[2];
	
	array_splice($arr_mainpacket, 0, 3);
	//array_shift($arr_mainpacket);
	//array_shift($arr_mainpacket);
	
	$this->packet = $arr_mainpacket;
	$this->formatstring();
	
}

//-------------------------------------------------------------------------------------

function main_setPacket()
{
    $dataPacket = $this->main_createPacket();
    if (is_null($_SESSION["outgoingpackets"]))
    {
        $_SESSION["outgoingpackets"] = array ();
    }
    array_push($_SESSION["outgoingpackets"], $dataPacket);

}

//-------------------------------------------------------------------------------------
	
	function main_createPacket()
	{
		$datastr = "";

		foreach($this->returnValues as $key=>$value)
		{
			$datastr .= ";".$this->reformatstring($value);
		}
		
		return $packet = $this->stationId.";".$this->moduleId.";".$this->actionId.$datastr;
		
	}
	
//-------------------------------------------------------------------------------------

function get_outgoing_Packet()
{
	$packets = array();
    $arrtemp = $_SESSION["outgoingpackets"];
	if(count($arrtemp)>0)
	{
    $packets = array_splice($arrtemp, 0, count($arrtemp)); 
    unset ($_SESSION["outgoingpackets"]);
	}
    return $packets;
}


//-------------------------------------------------------------------------------------

function formatstring()
{
	foreach($this->packet as $key => $messageText){
    $messageText = str_replace("&coln", ";", $messageText);
    $messageText = str_replace("&pipe", "|", $messageText);
	
	array_splice($this->packet, $key,1,$messageText);
	}
}

//-------------------------------------------------------------------------------------

function reformatstring($value)
{
	
    $value = str_replace(";", "&coln", $value);
    $value = str_replace("|", "&pipe", $value);
		return $value;
}

//-------------------------------------------------------------------------------------

}
?>
