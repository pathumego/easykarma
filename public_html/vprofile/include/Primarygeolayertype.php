<?php
class Primarygeolayertype
{
		public $PrimaryGeoLayerTypeId;
		public $PrimaryGeoLayerName;
		public $Description;


public function setPrimarygeolayertype($PrimaryGeoLayerTypeId_,$PrimaryGeoLayerName_,$Description_)
{
		$this->PrimaryGeoLayerTypeId= $PrimaryGeoLayerTypeId_;
		$this->PrimaryGeoLayerName= $PrimaryGeoLayerName_;
		$this->Description= $Description_;

}

public function wsGetPrimarygeolayertypeData()
{
	return	array(	
		'PrimaryGeoLayerTypeId'=> $this->PrimaryGeoLayerTypeId,
		'PrimaryGeoLayerName'=> $this->PrimaryGeoLayerName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPrimarygeolayertypeData()
 {
 	$packet = 	
		$this->PrimaryGeoLayerTypeId.";".
		$this->PrimaryGeoLayerName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getPrimarygeolayertypePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"PrimarygeolayertypeData\" id=\"Primarygeolayertypedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPrimarygeolayertypeData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPrimarygeolayertype()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->PrimaryGeoLayerTypeId."</td>";
		$html .= "<td>".$this->PrimaryGeoLayerName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>