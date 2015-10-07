<?php
class Alsubjects
{
		public $SubjectId;
		public $SubjectName;
		public $SubjectNumber;


public function setAlsubjects($SubjectId_,$SubjectName_,$SubjectNumber_)
{
		$this->SubjectId= $SubjectId_;
		$this->SubjectName= $SubjectName_;
		$this->SubjectNumber= $SubjectNumber_;

}

public function wsGetAlsubjectsData()
{
	return	array(	
		'SubjectId'=> $this->SubjectId,
		'SubjectName'=> $this->SubjectName,
		'SubjectNumber'=> $this->SubjectNumber

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getAlsubjectsData()
 {
 	$packet = 	
		$this->SubjectId.";".
		$this->SubjectName.";".
		$this->SubjectNumber;

	return $packet;
 }
 
 
  public function getAlsubjectsPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"AlsubjectsData\" id=\"Alsubjectsdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getAlsubjectsData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewAlsubjects()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->SubjectId."</td>";
		$html .= "<td>".$this->SubjectName."</td>";
		$html .= "<td>".$this->SubjectNumber."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>