<?php
class Person_talent
{
		public $TblId;
		public $PersonId;
		public $TalentId;


public function setPerson_talent($TblId_,$PersonId_,$TalentId_)
{
		$this->TblId= $TblId_;
		$this->PersonId= $PersonId_;
		$this->TalentId= $TalentId_;

}

public function wsGetPerson_talentData()
{
	return	array(	
		'TblId'=> $this->TblId,
		'PersonId'=> $this->PersonId,
		'TalentId'=> $this->TalentId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_talentData()
 {
 	$packet = 	
		$this->TblId.";".
		$this->PersonId.";".
		$this->TalentId;

	return $packet;
 }
 
 
  public function getPerson_talentPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_talentData\" id=\"Person_talentdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_talentData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_talent()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->TblId."</td>";
		$html .= "<td>".$this->PersonId."</td>";
		$html .= "<td>".$this->TalentId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>