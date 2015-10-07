<?php
class Person_property
{
		public $PropertyId;
		public $PropertyName;
		public $PropertyType;
		public $AssessValue;
		public $Description;


public function setPerson_property($PropertyId_,$PropertyName_,$PropertyType_,$AssessValue_,$Description_)
{
		$this->PropertyId= $PropertyId_;
		$this->PropertyName= $PropertyName_;
		$this->PropertyType= $PropertyType_;
		$this->AssessValue= $AssessValue_;
		$this->Description= $Description_;

}

public function wsGetPerson_propertyData()
{
	return	array(	
		'PropertyId'=> $this->PropertyId,
		'PropertyName'=> $this->PropertyName,
		'PropertyType'=> $this->PropertyType,
		'AssessValue'=> $this->AssessValue,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_propertyData()
 {
 	$packet = 	
		$this->PropertyId.";".
		$this->PropertyName.";".
		$this->PropertyType.";".
		$this->AssessValue.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getPerson_propertyPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_propertyData\" id=\"Person_propertydata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_propertyData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_property()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->PropertyId."</td>";
		$html .= "<td>".$this->PropertyName."</td>";
		$html .= "<td>".$this->PropertyType."</td>";
		$html .= "<td>".$this->AssessValue."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>