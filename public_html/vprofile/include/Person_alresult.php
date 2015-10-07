<?php
class Person_alresult
{
		public $ALResultId;
		public $SubjectId;
		public $SchoolId;
		public $Grade;
		public $Language;
		public $DateTime;
		public $PersonId;


public function setPerson_alresult($ALResultId_,$SubjectId_,$SchoolId_,$Grade_,$Language_,$DateTime_,$PersonId_)
{
		$this->ALResultId= $ALResultId_;
		$this->SubjectId= $SubjectId_;
		$this->SchoolId= $SchoolId_;
		$this->Grade= $Grade_;
		$this->Language= $Language_;
		$this->DateTime= $DateTime_;
		$this->PersonId= $PersonId_;

}

public function wsGetPerson_alresultData()
{
	return	array(	
		'ALResultId'=> $this->ALResultId,
		'SubjectId'=> $this->SubjectId,
		'SchoolId'=> $this->SchoolId,
		'Grade'=> $this->Grade,
		'Language'=> $this->Language,
		'DateTime'=> $this->DateTime,
		'PersonId'=> $this->PersonId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_alresultData()
 {
 	$packet = 	
		$this->ALResultId.";".
		$this->SubjectId.";".
		$this->SchoolId.";".
		$this->Grade.";".
		$this->Language.";".
		$this->DateTime.";".
		$this->PersonId;

	return $packet;
 }
 
 
  public function getPerson_alresultPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_alresultData\" id=\"Person_alresultdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_alresultData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_alresult()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->ALResultId."</td>";
		$html .= "<td>".$this->SubjectId."</td>";
		$html .= "<td>".$this->SchoolId."</td>";
		$html .= "<td>".$this->Grade."</td>";
		$html .= "<td>".$this->Language."</td>";
		$html .= "<td>".$this->DateTime."</td>";
		$html .= "<td>".$this->PersonId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>