<?php
class Village_transport
{
		public $TransportId;
		public $VillageId;
		public $Description;


public function setVillage_transport($TransportId_,$VillageId_,$Description_)
{
		$this->TransportId= $TransportId_;
		$this->VillageId= $VillageId_;
		$this->Description= $Description_;

}

public function wsGetVillage_transportData()
{
	return	array(	
		'TransportId'=> $this->TransportId,
		'VillageId'=> $this->VillageId,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_transportData()
 {
 	$packet = 	
		$this->TransportId.";".
		$this->VillageId.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getVillage_transportPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_transportData\" id=\"Village_transportdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_transportData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_transport()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TransportId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>