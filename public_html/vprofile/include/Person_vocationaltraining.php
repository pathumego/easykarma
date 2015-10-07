<?php
class Person_vocationaltraining
{
		public $VocationalTrainId;
		public $FieldName;
		public $CourseName;
		public $InstituteId;
		public $StartDate;
		public $EndDate;
		public $CertificateType;
		public $PersonId;


public function setPerson_vocationaltraining($VocationalTrainId_,$FieldName_,$CourseName_,$InstituteId_,$StartDate_,$EndDate_,$CertificateType_,$PersonId_)
{
		$this->VocationalTrainId= $VocationalTrainId_;
		$this->FieldName= $FieldName_;
		$this->CourseName= $CourseName_;
		$this->InstituteId= $InstituteId_;
		$this->StartDate= $StartDate_;
		$this->EndDate= $EndDate_;
		$this->CertificateType= $CertificateType_;
		$this->PersonId= $PersonId_;

}

public function wsGetPerson_vocationaltrainingData()
{
	return	array(	
		'VocationalTrainId'=> $this->VocationalTrainId,
		'FieldName'=> $this->FieldName,
		'CourseName'=> $this->CourseName,
		'InstituteId'=> $this->InstituteId,
		'StartDate'=> $this->StartDate,
		'EndDate'=> $this->EndDate,
		'CertificateType'=> $this->CertificateType,
		'PersonId'=> $this->PersonId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_vocationaltrainingData()
 {
 	$packet = 	
		$this->VocationalTrainId.";".
		$this->FieldName.";".
		$this->CourseName.";".
		$this->InstituteId.";".
		$this->StartDate.";".
		$this->EndDate.";".
		$this->CertificateType.";".
		$this->PersonId;

	return $packet;
 }
 
 
  public function getPerson_vocationaltrainingPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_vocationaltrainingData\" id=\"Person_vocationaltrainingdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_vocationaltrainingData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_vocationaltraining()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->VocationalTrainId."</td>";
		$html .= "<td>".$this->FieldName."</td>";
		$html .= "<td>".$this->CourseName."</td>";
		$html .= "<td>".$this->InstituteId."</td>";
		$html .= "<td>".$this->StartDate."</td>";
		$html .= "<td>".$this->EndDate."</td>";
		$html .= "<td>".$this->CertificateType."</td>";
		$html .= "<td>".$this->PersonId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>