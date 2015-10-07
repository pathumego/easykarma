<?php
class Trading
{
		public $tradingId;
		public $tradingName;
		public $tradingType;
		public $Description;


public function setTrading($tradingId_,$tradingName_,$tradingType_,$Description_)
{
		$this->tradingId= $tradingId_;
		$this->tradingName= $tradingName_;
		$this->tradingType= $tradingType_;
		$this->Description= $Description_;

}

public function wsGetTradingData()
{
	return	array(	
		'tradingId'=> $this->tradingId,
		'tradingName'=> $this->tradingName,
		'tradingType'=> $this->tradingType,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getTradingData()
 {
 	$packet = 	
		$this->tradingId.";".
		$this->tradingName.";".
		$this->tradingType.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getTradingPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"TradingData\" id=\"Tradingdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getTradingData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewTrading()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->tradingId."</td>";
		$html .= "<td>".$this->tradingName."</td>";
		$html .= "<td>".$this->tradingType."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>