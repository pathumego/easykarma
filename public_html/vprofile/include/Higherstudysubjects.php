<?php
class Higherstudysubjects
{
		public $SubjectId;
		public $SubjectName;
		public $SubjectNumber;
		public $SubjectField;
		public $Level;


public function setHigherstudysubjects($SubjectId_,$SubjectName_,$SubjectNumber_,$SubjectField_,$Level_)
{
		$this->SubjectId= $SubjectId_;
		$this->SubjectName= $SubjectName_;
		$this->SubjectNumber= $SubjectNumber_;
		$this->SubjectField= $SubjectField_;
		$this->Level= $Level_;

}

public function wsGetHigherstudysubjectsData()
{
	return	array(	
		'SubjectId'=> $this->SubjectId,
		'SubjectName'=> $this->SubjectName,
		'SubjectNumber'=> $this->SubjectNumber,
		'SubjectField'=> $this->SubjectField,
		'Level'=> $this->Level

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getHigherstudysubjectsData()
 {
 	$packet = 	
		$this->SubjectId.";".
		$this->SubjectName.";".
		$this->SubjectNumber.";".
		$this->SubjectField.";".
		$this->Level;

	return $packet;
 }
 
 
  public function getHigherstudysubjectsPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"HigherstudysubjectsData\" id=\"Higherstudysubjectsdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getHigherstudysubjectsData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewHigherstudysubjects()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->SubjectId."</td>";
		$html .= "<td>".$this->SubjectName."</td>";
		$html .= "<td>".$this->SubjectNumber."</td>";
		$html .= "<td>".$this->SubjectField."</td>";
		$html .= "<td>".$this->Level."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>