<?php
class Town
{
		public $TownId;
		public $TownName;
		public $Description;


public function setTown($TownId_,$TownName_,$Description_)
{
		$this->TownId= $TownId_;
		$this->TownName= $TownName_;
		$this->Description= $Description_;

}

public function wsGetTownData()
{
	return	array(	
		'TownId'=> $this->TownId,
		'TownName'=> $this->TownName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getTownData()
 {
 	$packet = 	
		$this->TownId.";".
		$this->TownName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getTownPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"TownData\" id=\"Towndata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getTownData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewTown()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TownId."</td>";
		$html .= "<td>".$this->TownName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>