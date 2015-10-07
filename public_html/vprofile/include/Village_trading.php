<?php
class Village_trading
{
		public $TradingId;
		public $VillageId;
		public $BusinessId;
		public $Description;


public function setVillage_trading($TradingId_,$VillageId_,$BusinessId_,$Description_)
{
		$this->TradingId= $TradingId_;
		$this->VillageId= $VillageId_;
		$this->BusinessId= $BusinessId_;
		$this->Description= $Description_;

}

public function wsGetVillage_tradingData()
{
	return	array(	
		'TradingId'=> $this->TradingId,
		'VillageId'=> $this->VillageId,
		'BusinessId'=> $this->BusinessId,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_tradingData()
 {
 	$packet = 	
		$this->TradingId.";".
		$this->VillageId.";".
		$this->BusinessId.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getVillage_tradingPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_tradingData\" id=\"Village_tradingdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_tradingData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_trading()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TradingId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->BusinessId."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>