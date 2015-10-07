<?php
class Service
{
		public $ServiceId;
		public $ServiceName;
		public $Description;


public function setService($ServiceId_,$ServiceName_,$Description_)
{
		$this->ServiceId= $ServiceId_;
		$this->ServiceName= $ServiceName_;
		$this->Description= $Description_;

}

public function wsGetServiceData()
{
	return	array(	
		'ServiceId'=> $this->ServiceId,
		'ServiceName'=> $this->ServiceName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getServiceData()
 {
 	$packet = 	
		$this->ServiceId.";".
		$this->ServiceName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getServicePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"ServiceData\" id=\"Servicedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getServiceData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewService()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->ServiceId."</td>";
		$html .= "<td>".$this->ServiceName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>