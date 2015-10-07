<?php
class Village_plant
{
		public $PlantId;
		public $VillageId;


public function setVillage_plant($PlantId_,$VillageId_)
{
		$this->PlantId= $PlantId_;
		$this->VillageId= $VillageId_;

}

public function wsGetVillage_plantData()
{
	return	array(	
		'PlantId'=> $this->PlantId,
		'VillageId'=> $this->VillageId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_plantData()
 {
 	$packet = 	
		$this->PlantId.";".
		$this->VillageId;

	return $packet;
 }
 
 
  public function getVillage_plantPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_plantData\" id=\"Village_plantdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_plantData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_plant()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->PlantId."</td>";
		$html .= "<td>".$this->VillageId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>