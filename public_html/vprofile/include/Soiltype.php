<?php
class Soiltype
{
		public $TblId;
		public $SoilTypeId;
		public $SoilTypeName;
		public $Description;


public function setSoiltype($TblId_,$SoilTypeId_,$SoilTypeName_,$Description_)
{
		$this->TblId= $TblId_;
		$this->SoilTypeId= $SoilTypeId_;
		$this->SoilTypeName= $SoilTypeName_;
		$this->Description= $Description_;

}

public function wsGetSoiltypeData()
{
	return	array(	
		'TblId'=> $this->TblId,
		'SoilTypeId'=> $this->SoilTypeId,
		'SoilTypeName'=> $this->SoilTypeName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getSoiltypeData()
 {
 	$packet = 	
		$this->TblId.";".
		$this->SoilTypeId.";".
		$this->SoilTypeName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getSoiltypePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"SoiltypeData\" id=\"Soiltypedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getSoiltypeData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewSoiltype()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TblId."</td>";
		$html .= "<td>".$this->SoilTypeId."</td>";
		$html .= "<td>".$this->SoilTypeName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>