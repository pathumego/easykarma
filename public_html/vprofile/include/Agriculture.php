<?php
class Agriculture
{
		public $AgricultureId;
		public $AgricultureName;
		public $Description;


public function setAgriculture($AgricultureId_,$AgricultureName_,$Description_)
{
		$this->AgricultureId= $AgricultureId_;
		$this->AgricultureName= $AgricultureName_;
		$this->Description= $Description_;

}

public function wsGetAgricultureData()
{
	return	array(	
		'AgricultureId'=> $this->AgricultureId,
		'AgricultureName'=> $this->AgricultureName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getAgricultureData()
 {
 	$packet = 	
		$this->AgricultureId.";".
		$this->AgricultureName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getAgriculturePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"AgricultureData\" id=\"Agriculturedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getAgricultureData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewAgriculture()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->AgricultureId."</td>";
		$html .= "<td>".$this->AgricultureName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>