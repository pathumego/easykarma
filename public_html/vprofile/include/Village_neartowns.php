<?php
class Village_neartowns
{
		public $VillageId;
		public $TownId;
		public $Distance;
		public $Description;


public function setVillage_neartowns($VillageId_,$TownId_,$Distance_,$Description_)
{
		$this->VillageId= $VillageId_;
		$this->TownId= $TownId_;
		$this->Distance= $Distance_;
		$this->Description= $Description_;

}

public function wsGetVillage_neartownsData()
{
	return	array(	
		'VillageId'=> $this->VillageId,
		'TownId'=> $this->TownId,
		'Distance'=> $this->Distance,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_neartownsData()
 {
 	$packet = 	
		$this->VillageId.";".
		$this->TownId.";".
		$this->Distance.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getVillage_neartownsPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_neartownsData\" id=\"Village_neartownsdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_neartownsData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_neartowns()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->TownId."</td>";
		$html .= "<td>".$this->Distance."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>