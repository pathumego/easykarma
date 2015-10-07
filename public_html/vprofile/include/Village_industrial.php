<?php
class Village_industrial
{
		public $IndustrialId;
		public $VillageId;
		public $BusinessId;
		public $Description;


public function setVillage_industrial($IndustrialId_,$VillageId_,$BusinessId_,$Description_)
{
		$this->IndustrialId= $IndustrialId_;
		$this->VillageId= $VillageId_;
		$this->BusinessId= $BusinessId_;
		$this->Description= $Description_;

}

public function wsGetVillage_industrialData()
{
	return	array(	
		'IndustrialId'=> $this->IndustrialId,
		'VillageId'=> $this->VillageId,
		'BusinessId'=> $this->BusinessId,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_industrialData()
 {
 	$packet = 	
		$this->IndustrialId.";".
		$this->VillageId.";".
		$this->BusinessId.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getVillage_industrialPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_industrialData\" id=\"Village_industrialdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_industrialData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_industrial()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->IndustrialId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->BusinessId."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>