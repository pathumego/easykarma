<?php
class Person_educationlevel
{
		public $EducationLevelId;
		public $SchoolId;
		public $StartYear;
		public $StartClass;
		public $EndYear;
		public $EndClass;
		public $PersonId;


public function setPerson_educationlevel($EducationLevelId_,$SchoolId_,$StartYear_,$StartClass_,$EndYear_,$EndClass_,$PersonId_)
{
		$this->EducationLevelId= $EducationLevelId_;
		$this->SchoolId= $SchoolId_;
		$this->StartYear= $StartYear_;
		$this->StartClass= $StartClass_;
		$this->EndYear= $EndYear_;
		$this->EndClass= $EndClass_;
		$this->PersonId= $PersonId_;

}

public function wsGetPerson_educationlevelData()
{
	return	array(	
		'EducationLevelId'=> $this->EducationLevelId,
		'SchoolId'=> $this->SchoolId,
		'StartYear'=> $this->StartYear,
		'StartClass'=> $this->StartClass,
		'EndYear'=> $this->EndYear,
		'EndClass'=> $this->EndClass,
		'PersonId'=> $this->PersonId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_educationlevelData()
 {
 	$packet = 	
		$this->EducationLevelId.";".
		$this->SchoolId.";".
		$this->StartYear.";".
		$this->StartClass.";".
		$this->EndYear.";".
		$this->EndClass.";".
		$this->PersonId;

	return $packet;
 }
 
 
  public function getPerson_educationlevelPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_educationlevelData\" id=\"Person_educationleveldata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_educationlevelData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_educationlevel()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->EducationLevelId."</td>";
		$html .= "<td>".$this->SchoolId."</td>";
		$html .= "<td>".$this->StartYear."</td>";
		$html .= "<td>".$this->StartClass."</td>";
		$html .= "<td>".$this->EndYear."</td>";
		$html .= "<td>".$this->EndClass."</td>";
		$html .= "<td>".$this->PersonId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>