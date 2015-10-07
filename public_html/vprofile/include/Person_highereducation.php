<?php
class Person_highereducation
{
		public $ResultId;
		public $SubjectId;
		public $InstituteId;
		public $Grade;
		public $Language;
		public $DateTime;
		public $PersonId;
		public $Level;


public function setPerson_highereducation($ResultId_,$SubjectId_,$InstituteId_,$Grade_,$Language_,$DateTime_,$PersonId_,$Level_)
{
		$this->ResultId= $ResultId_;
		$this->SubjectId= $SubjectId_;
		$this->InstituteId= $InstituteId_;
		$this->Grade= $Grade_;
		$this->Language= $Language_;
		$this->DateTime= $DateTime_;
		$this->PersonId= $PersonId_;
		$this->Level= $Level_;

}

public function wsGetPerson_highereducationData()
{
	return	array(	
		'ResultId'=> $this->ResultId,
		'SubjectId'=> $this->SubjectId,
		'InstituteId'=> $this->InstituteId,
		'Grade'=> $this->Grade,
		'Language'=> $this->Language,
		'DateTime'=> $this->DateTime,
		'PersonId'=> $this->PersonId,
		'Level'=> $this->Level

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_highereducationData()
 {
 	$packet = 	
		$this->ResultId.";".
		$this->SubjectId.";".
		$this->InstituteId.";".
		$this->Grade.";".
		$this->Language.";".
		$this->DateTime.";".
		$this->PersonId.";".
		$this->Level;

	return $packet;
 }
 
 
  public function getPerson_highereducationPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_highereducationData\" id=\"Person_highereducationdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_highereducationData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_highereducation()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->ResultId."</td>";
		$html .= "<td>".$this->SubjectId."</td>";
		$html .= "<td>".$this->InstituteId."</td>";
		$html .= "<td>".$this->Grade."</td>";
		$html .= "<td>".$this->Language."</td>";
		$html .= "<td>".$this->DateTime."</td>";
		$html .= "<td>".$this->PersonId."</td>";
		$html .= "<td>".$this->Level."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>