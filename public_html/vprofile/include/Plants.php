<?php
class Plants
{
		public $PlantId;
		public $Name;
		public $Description;
		public $BioName;


public function setPlants($PlantId_,$Name_,$Description_,$BioName_)
{
		$this->PlantId= $PlantId_;
		$this->Name= $Name_;
		$this->Description= $Description_;
		$this->BioName= $BioName_;

}

public function wsGetPlantsData()
{
	return	array(	
		'PlantId'=> $this->PlantId,
		'Name'=> $this->Name,
		'Description'=> $this->Description,
		'BioName'=> $this->BioName

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPlantsData()
 {
 	$packet = 	
		$this->PlantId.";".
		$this->Name.";".
		$this->Description.";".
		$this->BioName;

	return $packet;
 }
 
 
  public function getPlantsPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"PlantsData\" id=\"Plantsdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPlantsData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPlants()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->PlantId."</td>";
		$html .= "<td>".$this->Name."</td>";
		$html .= "<td>".$this->Description."</td>";
		$html .= "<td>".$this->BioName."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>