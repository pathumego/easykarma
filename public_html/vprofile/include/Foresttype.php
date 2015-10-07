<?php
class Foresttype
{
		public $ForestTypeId;
		public $Name;
		public $Description;


public function setForesttype($ForestTypeId_,$Name_,$Description_)
{
		$this->ForestTypeId= $ForestTypeId_;
		$this->Name= $Name_;
		$this->Description= $Description_;

}

public function wsGetForesttypeData()
{
	return	array(	
		'ForestTypeId'=> $this->ForestTypeId,
		'Name'=> $this->Name,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getForesttypeData()
 {
 	$packet = 	
		$this->ForestTypeId.";".
		$this->Name.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getForesttypePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"ForesttypeData\" id=\"Foresttypedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getForesttypeData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewForesttype()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->ForestTypeId."</td>";
		$html .= "<td>".$this->Name."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>