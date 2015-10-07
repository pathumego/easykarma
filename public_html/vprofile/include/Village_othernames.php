<?php
class Village_othernames
{
		public $VillageId;
		public $VillageNames;


public function setVillage_othernames($VillageId_,$VillageNames_)
{
		$this->VillageId= $VillageId_;
		$this->VillageNames= $VillageNames_;

}

public function wsGetVillage_othernamesData()
{
	return	array(	
		'VillageId'=> $this->VillageId,
		'VillageNames'=> $this->VillageNames

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_othernamesData()
 {
 	$packet = 	
		$this->VillageId.";".
		$this->VillageNames;

	return $packet;
 }
 
 
  public function getVillage_othernamesPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_othernamesData\" id=\"Village_othernamesdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_othernamesData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_othernames()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->VillageNames."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>