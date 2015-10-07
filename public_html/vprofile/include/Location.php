<?php
class Location
{
		public $LocationId;
		public $Name;
		public $LocationType;
		public $Description;


public function setLocation($LocationId_,$Name_,$LocationType_,$Description_)
{
		$this->LocationId= $LocationId_;
		$this->Name= $Name_;
		$this->LocationType= $LocationType_;
		$this->Description= $Description_;

}

public function wsGetLocationData()
{
	return	array(	
		'LocationId'=> $this->LocationId,
		'Name'=> $this->Name,
		'LocationType'=> $this->LocationType,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getLocationData()
 {
 	$packet = 	
		$this->LocationId.";".
		$this->Name.";".
		$this->LocationType.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getLocationPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"LocationData\" id=\"Locationdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getLocationData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewLocation()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->LocationId."</td>";
		$html .= "<td>".$this->Name."</td>";
		$html .= "<td>".$this->LocationType."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>