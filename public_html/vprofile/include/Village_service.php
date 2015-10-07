<?php
class Village_service
{
		public $ServiceId;
		public $VillageId;
		public $BusinessId;
		public $Description;


public function setVillage_service($ServiceId_,$VillageId_,$BusinessId_,$Description_)
{
		$this->ServiceId= $ServiceId_;
		$this->VillageId= $VillageId_;
		$this->BusinessId= $BusinessId_;
		$this->Description= $Description_;

}

public function wsGetVillage_serviceData()
{
	return	array(	
		'ServiceId'=> $this->ServiceId,
		'VillageId'=> $this->VillageId,
		'BusinessId'=> $this->BusinessId,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_serviceData()
 {
 	$packet = 	
		$this->ServiceId.";".
		$this->VillageId.";".
		$this->BusinessId.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getVillage_servicePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_serviceData\" id=\"Village_servicedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_serviceData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_service()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->ServiceId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->BusinessId."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>