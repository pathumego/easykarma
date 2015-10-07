<?php
class Businesstype
{
		public $BusinessTypeId;
		public $BusinessTypeName;
		public $Description;


public function setBusinesstype($BusinessTypeId_,$BusinessTypeName_,$Description_)
{
		$this->BusinessTypeId= $BusinessTypeId_;
		$this->BusinessTypeName= $BusinessTypeName_;
		$this->Description= $Description_;

}

public function wsGetBusinesstypeData()
{
	return	array(	
		'BusinessTypeId'=> $this->BusinessTypeId,
		'BusinessTypeName'=> $this->BusinessTypeName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getBusinesstypeData()
 {
 	$packet = 	
		$this->BusinessTypeId.";".
		$this->BusinessTypeName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getBusinesstypePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"BusinesstypeData\" id=\"Businesstypedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getBusinesstypeData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewBusinesstype()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->BusinessTypeId."</td>";
		$html .= "<td>".$this->BusinessTypeName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>