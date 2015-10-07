<?php
class Person_olresult
{
		public $OLResultId;
		public $SubjectId;
		public $SchoolId;
		public $Grade;
		public $Language;
		public $DateTime;
		public $PersonId;


public function setPerson_olresult($OLResultId_,$SubjectId_,$SchoolId_,$Grade_,$Language_,$DateTime_,$PersonId_)
{
		$this->OLResultId= $OLResultId_;
		$this->SubjectId= $SubjectId_;
		$this->SchoolId= $SchoolId_;
		$this->Grade= $Grade_;
		$this->Language= $Language_;
		$this->DateTime= $DateTime_;
		$this->PersonId= $PersonId_;

}

public function wsGetPerson_olresultData()
{
	return	array(	
		'OLResultId'=> $this->OLResultId,
		'SubjectId'=> $this->SubjectId,
		'SchoolId'=> $this->SchoolId,
		'Grade'=> $this->Grade,
		'Language'=> $this->Language,
		'DateTime'=> $this->DateTime,
		'PersonId'=> $this->PersonId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_olresultData()
 {
 	$packet = 	
		$this->OLResultId.";".
		$this->SubjectId.";".
		$this->SchoolId.";".
		$this->Grade.";".
		$this->Language.";".
		$this->DateTime.";".
		$this->PersonId;

	return $packet;
 }
 
 
  public function getPerson_olresultPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_olresultData\" id=\"Person_olresultdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_olresultData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_olresult()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->OLResultId."</td>";
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