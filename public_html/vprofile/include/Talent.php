<?php
class Talent
{
		public $TalentId;
		public $TalentType;
		public $TalentField;
		public $Description;
		public $TalentName;


public function setTalent($TalentId_,$TalentType_,$TalentField_,$Description_,$TalentName_)
{
		$this->TalentId= $TalentId_;
		$this->TalentType= $TalentType_;
		$this->TalentField= $TalentField_;
		$this->Description= $Description_;
		$this->TalentName= $TalentName_;

}

public function wsGetTalentData()
{
	return	array(	
		'TalentId'=> $this->TalentId,
		'TalentType'=> $this->TalentType,
		'TalentField'=> $this->TalentField,
		'Description'=> $this->Description,
		'TalentName'=> $this->TalentName

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getTalentData()
 {
 	$packet = 	
		$this->TalentId.";".
		$this->TalentType.";".
		$this->TalentField.";".
		$this->Description.";".
		$this->TalentName;

	return $packet;
 }
 
 
  public function getTalentPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"TalentData\" id=\"Talentdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getTalentData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewTalent()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TalentId."</td>";
		$html .= "<td>".$this->TalentType."</td>";
		$html .= "<td>".$this->TalentField."</td>";
		$html .= "<td>".$this->Description."</td>";
		$html .= "<td>".$this->TalentName."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>