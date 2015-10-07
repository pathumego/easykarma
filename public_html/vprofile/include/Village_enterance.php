<?php
class Village_enterance
{
		public $TblId;
		public $VillageId;
		public $Direction;
		public $Description;


public function setVillage_enterance($TblId_,$VillageId_,$Direction_,$Description_)
{
		$this->TblId= $TblId_;
		$this->VillageId= $VillageId_;
		$this->Direction= $Direction_;
		$this->Description= $Description_;

}

public function wsGetVillage_enteranceData()
{
	return	array(	
		'TblId'=> $this->TblId,
		'VillageId'=> $this->VillageId,
		'Direction'=> $this->Direction,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_enteranceData()
 {
 	$packet = 	
		$this->TblId.";".
		$this->VillageId.";".
		$this->Direction.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getVillage_enterancePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_enteranceData\" id=\"Village_enterancedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_enteranceData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_enterance()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TblId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->Direction."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>