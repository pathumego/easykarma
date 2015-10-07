<?php
class Village_history
{
		public $TblId;
		public $VillageId;
		public $DescriptionType;
		public $Description;


public function setVillage_history($TblId_,$VillageId_,$DescriptionType_,$Description_)
{
		$this->TblId= $TblId_;
		$this->VillageId= $VillageId_;
		$this->DescriptionType= $DescriptionType_;
		$this->Description= $Description_;

}

public function wsGetVillage_historyData()
{
	return	array(	
		'TblId'=> $this->TblId,
		'VillageId'=> $this->VillageId,
		'DescriptionType'=> $this->DescriptionType,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_historyData()
 {
 	$packet = 	
		$this->TblId.";".
		$this->VillageId.";".
		$this->DescriptionType.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getVillage_historyPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_historyData\" id=\"Village_historydata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_historyData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_history()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TblId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->DescriptionType."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>