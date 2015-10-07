<?php
class Geographytype
{
		public $GeogrophyTypeId;
		public $Name;
		public $Description;


public function setGeographytype($GeogrophyTypeId_,$Name_,$Description_)
{
		$this->GeogrophyTypeId= $GeogrophyTypeId_;
		$this->Name= $Name_;
		$this->Description= $Description_;

}

public function wsGetGeographytypeData()
{
	return	array(	
		'GeogrophyTypeId'=> $this->GeogrophyTypeId,
		'Name'=> $this->Name,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getGeographytypeData()
 {
 	$packet = 	
		$this->GeogrophyTypeId.";".
		$this->Name.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getGeographytypePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"GeographytypeData\" id=\"Geographytypedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getGeographytypeData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewGeographytype()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->GeogrophyTypeId."</td>";
		$html .= "<td>".$this->Name."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>