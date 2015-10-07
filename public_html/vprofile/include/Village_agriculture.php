<?php
class Village_agriculture
{
		public $AgricultureId;
		public $VillageId;
		public $BusinessId;
		public $Description;


public function setVillage_agriculture($AgricultureId_,$VillageId_,$BusinessId_,$Description_)
{
		$this->AgricultureId= $AgricultureId_;
		$this->VillageId= $VillageId_;
		$this->BusinessId= $BusinessId_;
		$this->Description= $Description_;

}

public function wsGetVillage_agricultureData()
{
	return	array(	
		'AgricultureId'=> $this->AgricultureId,
		'VillageId'=> $this->VillageId,
		'BusinessId'=> $this->BusinessId,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_agricultureData()
 {
 	$packet = 	
		$this->AgricultureId.";".
		$this->VillageId.";".
		$this->BusinessId.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getVillage_agriculturePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_agricultureData\" id=\"Village_agriculturedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_agricultureData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_agriculture()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->AgricultureId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->BusinessId."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>