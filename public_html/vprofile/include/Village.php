<?php
class Village
{
		public $VillageId;
		public $Name;
		public $VillageNumber;
		public $AgaDevision;
		public $District;
		public $Province;
		public $GeogrophyTypeId;
		public $ForestTypeId;
		public $ForestDescription;
		public $TraditionalKnowledge;


public function setVillage($VillageId_,$Name_,$VillageNumber_,$AgaDevision_,$District_,$Province_,$GeogrophyTypeId_,$ForestTypeId_,$ForestDescription_,$TraditionalKnowledge_)
{
		$this->VillageId= $VillageId_;
		$this->Name= $Name_;
		$this->VillageNumber= $VillageNumber_;
		$this->AgaDevision= $AgaDevision_;
		$this->District= $District_;
		$this->Province= $Province_;
		$this->GeogrophyTypeId= $GeogrophyTypeId_;
		$this->ForestTypeId= $ForestTypeId_;
		$this->ForestDescription= $ForestDescription_;
		$this->TraditionalKnowledge= $TraditionalKnowledge_;

}

public function wsGetVillageData()
{
	return	array(	
		'VillageId'=> $this->VillageId,
		'Name'=> $this->Name,
		'VillageNumber'=> $this->VillageNumber,
		'AgaDevision'=> $this->AgaDevision,
		'District'=> $this->District,
		'Province'=> $this->Province,
		'GeogrophyTypeId'=> $this->GeogrophyTypeId,
		'ForestTypeId'=> $this->ForestTypeId,
		'ForestDescription'=> $this->ForestDescription,
		'TraditionalKnowledge'=> $this->TraditionalKnowledge

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillageData()
 {
 	$packet = 	
		$this->VillageId.";".
		$this->Name.";".
		$this->VillageNumber.";".
		$this->AgaDevision.";".
		$this->District.";".
		$this->Province.";".
		$this->GeogrophyTypeId.";".
		$this->ForestTypeId.";".
		$this->ForestDescription.";".
		$this->TraditionalKnowledge;

	return $packet;
 }
 
 
  public function getVillagePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"VillageData\" id=\"Villagedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillageData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->Name."</td>";
		$html .= "<td>".$this->VillageNumber."</td>";
		$html .= "<td>".$this->AgaDevision."</td>";
		$html .= "<td>".$this->District."</td>";
		$html .= "<td>".$this->Province."</td>";
		$html .= "<td>".$this->GeogrophyTypeId."</td>";
		$html .= "<td>".$this->ForestTypeId."</td>";
		$html .= "<td>".$this->ForestDescription."</td>";
		$html .= "<td>".$this->TraditionalKnowledge."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>