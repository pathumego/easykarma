<?php
class Person_address
{
		public $AddressId;
		public $Address;
		public $AddressType;
		public $VillageId;
		public $PersonId;


public function setPerson_address($AddressId_,$Address_,$AddressType_,$VillageId_,$PersonId_)
{
		$this->AddressId= $AddressId_;
		$this->Address= $Address_;
		$this->AddressType= $AddressType_;
		$this->VillageId= $VillageId_;
		$this->PersonId= $PersonId_;

}

public function wsGetPerson_addressData()
{
	return	array(	
		'AddressId'=> $this->AddressId,
		'Address'=> $this->Address,
		'AddressType'=> $this->AddressType,
		'VillageId'=> $this->VillageId,
		'PersonId'=> $this->PersonId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPerson_addressData()
 {
 	$packet = 	
		$this->AddressId.";".
		$this->Address.";".
		$this->AddressType.";".
		$this->VillageId.";".
		$this->PersonId;

	return $packet;
 }
 
 
  public function getPerson_addressPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Person_addressData\" id=\"Person_addressdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPerson_addressData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson_address()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->AddressId."</td>";
		$html .= "<td>".$this->Address."</td>";
		$html .= "<td>".$this->AddressType."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->PersonId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>