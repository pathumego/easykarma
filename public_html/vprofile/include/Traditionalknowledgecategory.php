<?php
class Traditionalknowledgecategory
{
		public $CategoryId;
		public $CategoryName;
		public $Description;


public function setTraditionalknowledgecategory($CategoryId_,$CategoryName_,$Description_)
{
		$this->CategoryId= $CategoryId_;
		$this->CategoryName= $CategoryName_;
		$this->Description= $Description_;

}

public function wsGetTraditionalknowledgecategoryData()
{
	return	array(	
		'CategoryId'=> $this->CategoryId,
		'CategoryName'=> $this->CategoryName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getTraditionalknowledgecategoryData()
 {
 	$packet = 	
		$this->CategoryId.";".
		$this->CategoryName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getTraditionalknowledgecategoryPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"TraditionalknowledgecategoryData\" id=\"Traditionalknowledgecategorydata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getTraditionalknowledgecategoryData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewTraditionalknowledgecategory()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->CategoryId."</td>";
		$html .= "<td>".$this->CategoryName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>