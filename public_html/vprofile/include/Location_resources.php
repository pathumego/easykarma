<?php
class Location_resources
{
		public $ResourceId;
		public $LocationId;
		public $ResourceType;
		public $ResourcePath;


public function setLocation_resources($ResourceId_,$LocationId_,$ResourceType_,$ResourcePath_)
{
		$this->ResourceId= $ResourceId_;
		$this->LocationId= $LocationId_;
		$this->ResourceType= $ResourceType_;
		$this->ResourcePath= $ResourcePath_;

}

public function wsGetLocation_resourcesData()
{
	return	array(	
		'ResourceId'=> $this->ResourceId,
		'LocationId'=> $this->LocationId,
		'ResourceType'=> $this->ResourceType,
		'ResourcePath'=> $this->ResourcePath

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getLocation_resourcesData()
 {
 	$packet = 	
		$this->ResourceId.";".
		$this->LocationId.";".
		$this->ResourceType.";".
		$this->ResourcePath;

	return $packet;
 }
 
 
  public function getLocation_resourcesPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Location_resourcesData\" id=\"Location_resourcesdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getLocation_resourcesData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewLocation_resources()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->ResourceId."</td>";
		$html .= "<td>".$this->LocationId."</td>";
		$html .= "<td>".$this->ResourceType."</td>";
		$html .= "<td>".$this->ResourcePath."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>