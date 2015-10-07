<?php
class Transport
{
		public $TransportId;
		public $TransportName;
		public $TransportType;
		public $Description;


public function setTransport($TransportId_,$TransportName_,$TransportType_,$Description_)
{
		$this->TransportId= $TransportId_;
		$this->TransportName= $TransportName_;
		$this->TransportType= $TransportType_;
		$this->Description= $Description_;

}

public function wsGetTransportData()
{
	return	array(	
		'TransportId'=> $this->TransportId,
		'TransportName'=> $this->TransportName,
		'TransportType'=> $this->TransportType,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getTransportData()
 {
 	$packet = 	
		$this->TransportId.";".
		$this->TransportName.";".
		$this->TransportType.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getTransportPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"TransportData\" id=\"Transportdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getTransportData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewTransport()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TransportId."</td>";
		$html .= "<td>".$this->TransportName."</td>";
		$html .= "<td>".$this->TransportType."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>