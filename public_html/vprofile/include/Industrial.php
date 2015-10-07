<?php
class Industrial
{
		public $IndustrialId;
		public $IndustrialName;
		public $Description;


public function setIndustrial($IndustrialId_,$IndustrialName_,$Description_)
{
		$this->IndustrialId= $IndustrialId_;
		$this->IndustrialName= $IndustrialName_;
		$this->Description= $Description_;

}

public function wsGetIndustrialData()
{
	return	array(	
		'IndustrialId'=> $this->IndustrialId,
		'IndustrialName'=> $this->IndustrialName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getIndustrialData()
 {
 	$packet = 	
		$this->IndustrialId.";".
		$this->IndustrialName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getIndustrialPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"IndustrialData\" id=\"Industrialdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getIndustrialData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewIndustrial()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->IndustrialId."</td>";
		$html .= "<td>".$this->IndustrialName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>