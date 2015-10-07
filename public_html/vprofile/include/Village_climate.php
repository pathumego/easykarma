<?php
class Village_climate
{
		public $ClimateId;
		public $VillageId;
		public $ClimateReagion;
		public $RainFall;
		public $Temparature;
		public $Humidity;


public function setVillage_climate($ClimateId_,$VillageId_,$ClimateReagion_,$RainFall_,$Temparature_,$Humidity_)
{
		$this->ClimateId= $ClimateId_;
		$this->VillageId= $VillageId_;
		$this->ClimateReagion= $ClimateReagion_;
		$this->RainFall= $RainFall_;
		$this->Temparature= $Temparature_;
		$this->Humidity= $Humidity_;

}

public function wsGetVillage_climateData()
{
	return	array(	
		'ClimateId'=> $this->ClimateId,
		'VillageId'=> $this->VillageId,
		'ClimateReagion'=> $this->ClimateReagion,
		'RainFall'=> $this->RainFall,
		'Temparature'=> $this->Temparature,
		'Humidity'=> $this->Humidity

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_climateData()
 {
 	$packet = 	
		$this->ClimateId.";".
		$this->VillageId.";".
		$this->ClimateReagion.";".
		$this->RainFall.";".
		$this->Temparature.";".
		$this->Humidity;

	return $packet;
 }
 
 
  public function getVillage_climatePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_climateData\" id=\"Village_climatedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_climateData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_climate()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->ClimateId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->ClimateReagion."</td>";
		$html .= "<td>".$this->RainFall."</td>";
		$html .= "<td>".$this->Temparature."</td>";
		$html .= "<td>".$this->Humidity."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>