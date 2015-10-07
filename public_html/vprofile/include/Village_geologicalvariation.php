<?php
class Village_geologicalvariation
{
		public $TblId;
		public $VillageId;
		public $Variation;
		public $Description;
		public $PrimaryGeoLayerTypeId;
		public $SoilTypeId;


public function setVillage_geologicalvariation($TblId_,$VillageId_,$Variation_,$Description_,$PrimaryGeoLayerTypeId_,$SoilTypeId_)
{
		$this->TblId= $TblId_;
		$this->VillageId= $VillageId_;
		$this->Variation= $Variation_;
		$this->Description= $Description_;
		$this->PrimaryGeoLayerTypeId= $PrimaryGeoLayerTypeId_;
		$this->SoilTypeId= $SoilTypeId_;

}

public function wsGetVillage_geologicalvariationData()
{
	return	array(	
		'TblId'=> $this->TblId,
		'VillageId'=> $this->VillageId,
		'Variation'=> $this->Variation,
		'Description'=> $this->Description,
		'PrimaryGeoLayerTypeId'=> $this->PrimaryGeoLayerTypeId,
		'SoilTypeId'=> $this->SoilTypeId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_geologicalvariationData()
 {
 	$packet = 	
		$this->TblId.";".
		$this->VillageId.";".
		$this->Variation.";".
		$this->Description.";".
		$this->PrimaryGeoLayerTypeId.";".
		$this->SoilTypeId;

	return $packet;
 }
 
 
  public function getVillage_geologicalvariationPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_geologicalvariationData\" id=\"Village_geologicalvariationdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_geologicalvariationData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_geologicalvariation()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TblId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->Variation."</td>";
		$html .= "<td>".$this->Description."</td>";
		$html .= "<td>".$this->PrimaryGeoLayerTypeId."</td>";
		$html .= "<td>".$this->SoilTypeId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>