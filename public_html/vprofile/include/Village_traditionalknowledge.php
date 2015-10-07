<?php
class Village_traditionalknowledge
{
		public $TblId;
		public $VillageId;
		public $TraditionalKnowledgeCategoryID;
		public $Discription;


public function setVillage_traditionalknowledge($TblId_,$VillageId_,$TraditionalKnowledgeCategoryID_,$Discription_)
{
		$this->TblId= $TblId_;
		$this->VillageId= $VillageId_;
		$this->TraditionalKnowledgeCategoryID= $TraditionalKnowledgeCategoryID_;
		$this->Discription= $Discription_;

}

public function wsGetVillage_traditionalknowledgeData()
{
	return	array(	
		'TblId'=> $this->TblId,
		'VillageId'=> $this->VillageId,
		'TraditionalKnowledgeCategoryID'=> $this->TraditionalKnowledgeCategoryID,
		'Discription'=> $this->Discription

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_traditionalknowledgeData()
 {
 	$packet = 	
		$this->TblId.";".
		$this->VillageId.";".
		$this->TraditionalKnowledgeCategoryID.";".
		$this->Discription;

	return $packet;
 }
 
 
  public function getVillage_traditionalknowledgePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_traditionalknowledgeData\" id=\"Village_traditionalknowledgedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_traditionalknowledgeData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_traditionalknowledge()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TblId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->TraditionalKnowledgeCategoryID."</td>";
		$html .= "<td>".$this->Discription."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>