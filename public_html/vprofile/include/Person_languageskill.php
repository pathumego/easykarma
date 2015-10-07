<?php
class Person_languageskill
{
		public $LangSkillId;
		public $PersonId;
		public $Language;
		public $SkillType;
		public $Grade;


public function setPerson_languageskill($LangSkillId_,$PersonId_,$Language_,$SkillType_,$Grade_)
{
		$this->LangSkillId= $LangSkillId_;
		$this->PersonId= $PersonId_;
		$this->Language= $Language_;
		$this->SkillType= $SkillType_;
		$this->Grade= $Grade_;

}

public function wsGetPerson_languageskillData()
{
	return	array(	
		'LangSkillId'=> $this->LangSkillId,
		'PersonId'=> $this->PersonId,
		'Language'=> $this->Language,
		'SkillType'=> $this->SkillType,
		'Grade'=> $this->Grade

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_languageskillData()
 {
 	$packet = 	
		$this->LangSkillId.";".
		$this->PersonId.";".
		$this->Language.";".
		$this->SkillType.";".
		$this->Grade;

	return $packet;
 }
 
 
  public function getPerson_languageskillPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_languageskillData\" id=\"Person_languageskilldata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_languageskillData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_languageskill()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->LangSkillId."</td>";
		$html .= "<td>".$this->PersonId."</td>";
		$html .= "<td>".$this->Language."</td>";
		$html .= "<td>".$this->SkillType."</td>";
		$html .= "<td>".$this->Grade."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>