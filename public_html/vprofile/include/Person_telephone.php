<?php
class Person_telephone
{
		public $PhoneId;
		public $PhoneNumber;
		public $Type;
		public $PersonId;


public function setPerson_telephone($PhoneId_,$PhoneNumber_,$Type_,$PersonId_)
{
		$this->PhoneId= $PhoneId_;
		$this->PhoneNumber= $PhoneNumber_;
		$this->Type= $Type_;
		$this->PersonId= $PersonId_;

}

public function wsGetPerson_telephoneData()
{
	return	array(	
		'PhoneId'=> $this->PhoneId,
		'PhoneNumber'=> $this->PhoneNumber,
		'Type'=> $this->Type,
		'PersonId'=> $this->PersonId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_telephoneData()
 {
 	$packet = 	
		$this->PhoneId.";".
		$this->PhoneNumber.";".
		$this->Type.";".
		$this->PersonId;

	return $packet;
 }
 
 
  public function getPerson_telephonePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_telephoneData\" id=\"Person_telephonedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_telephoneData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_telephone()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->PhoneId."</td>";
		$html .= "<td>".$this->PhoneNumber."</td>";
		$html .= "<td>".$this->Type."</td>";
		$html .= "<td>".$this->PersonId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>