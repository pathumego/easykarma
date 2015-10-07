<?php
class Village_society
{
		public $SocietyId;
		public $VillageId;
		public $VillageSocietyId;


public function setVillage_society($SocietyId_,$VillageId_,$VillageSocietyId_)
{
		$this->SocietyId= $SocietyId_;
		$this->VillageId= $VillageId_;
		$this->VillageSocietyId= $VillageSocietyId_;

}

public function wsGetVillage_societyData()
{
	return	array(	
		'SocietyId'=> $this->SocietyId,
		'VillageId'=> $this->VillageId,
		'VillageSocietyId'=> $this->VillageSocietyId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_societyData()
 {
 	$packet = 	
		$this->SocietyId.";".
		$this->VillageId.";".
		$this->VillageSocietyId;

	return $packet;
 }
 
 
  public function getVillage_societyPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_societyData\" id=\"Village_societydata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_societyData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_society()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->SocietyId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->VillageSocietyId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>