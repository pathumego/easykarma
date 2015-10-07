<?php
class Person_workingexperiance
{
		public $WorkExpId;
		public $CompanyId;
		public $StartDate;
		public $EndDate;
		public $Position;
		public $PersonId;


public function setPerson_workingexperiance($WorkExpId_,$CompanyId_,$StartDate_,$EndDate_,$Position_,$PersonId_)
{
		$this->WorkExpId= $WorkExpId_;
		$this->CompanyId= $CompanyId_;
		$this->StartDate= $StartDate_;
		$this->EndDate= $EndDate_;
		$this->Position= $Position_;
		$this->PersonId= $PersonId_;

}

public function wsGetPerson_workingexperianceData()
{
	return	array(	
		'WorkExpId'=> $this->WorkExpId,
		'CompanyId'=> $this->CompanyId,
		'StartDate'=> $this->StartDate,
		'EndDate'=> $this->EndDate,
		'Position'=> $this->Position,
		'PersonId'=> $this->PersonId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_workingexperianceData()
 {
 	$packet = 	
		$this->WorkExpId.";".
		$this->CompanyId.";".
		$this->StartDate.";".
		$this->EndDate.";".
		$this->Position.";".
		$this->PersonId;

	return $packet;
 }
 
 
  public function getPerson_workingexperiancePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_workingexperianceData\" id=\"Person_workingexperiancedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_workingexperianceData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_workingexperiance()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->WorkExpId."</td>";
		$html .= "<td>".$this->CompanyId."</td>";
		$html .= "<td>".$this->StartDate."</td>";
		$html .= "<td>".$this->EndDate."</td>";
		$html .= "<td>".$this->Position."</td>";
		$html .= "<td>".$this->PersonId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>