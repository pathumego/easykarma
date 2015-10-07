<?php
class Olsubjects
{
		public $SubjectId;
		public $SubjectName;
		public $SubjectNumber;


public function setOlsubjects($SubjectId_,$SubjectName_,$SubjectNumber_)
{
		$this->SubjectId= $SubjectId_;
		$this->SubjectName= $SubjectName_;
		$this->SubjectNumber= $SubjectNumber_;

}

public function wsGetOlsubjectsData()
{
	return	array(	
		'SubjectId'=> $this->SubjectId,
		'SubjectName'=> $this->SubjectName,
		'SubjectNumber'=> $this->SubjectNumber

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getOlsubjectsData()
 {
 	$packet = 	
		$this->SubjectId.";".
		$this->SubjectName.";".
		$this->SubjectNumber;

	return $packet;
 }
 
 
  public function getOlsubjectsPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"OlsubjectsData\" id=\"Olsubjectsdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getOlsubjectsData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewOlsubjects()
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