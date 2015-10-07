<?php
class Business
{
		public $BusinessId;
		public $Name;
		public $Description;
		public $Address;
		public $telephone;
		public $fax;
		public $website;
		public $email;
		public $BusinessTypeId;
		public $BusinessSubTypeId;


public function setBusiness($BusinessId_,$Name_,$Description_,$Address_,$telephone_,$fax_,$website_,$email_,$BusinessTypeId_,$BusinessSubTypeId_)
{
		$this->BusinessId= $BusinessId_;
		$this->Name= $Name_;
		$this->Description= $Description_;
		$this->Address= $Address_;
		$this->telephone= $telephone_;
		$this->fax= $fax_;
		$this->website= $website_;
		$this->email= $email_;
		$this->BusinessTypeId= $BusinessTypeId_;
		$this->BusinessSubTypeId= $BusinessSubTypeId_;

}

public function wsGetBusinessData()
{
	return	array(	
		'BusinessId'=> $this->BusinessId,
		'Name'=> $this->Name,
		'Description'=> $this->Description,
		'Address'=> $this->Address,
		'telephone'=> $this->telephone,
		'fax'=> $this->fax,
		'website'=> $this->website,
		'email'=> $this->email,
		'BusinessTypeId'=> $this->BusinessTypeId,
		'BusinessSubTypeId'=> $this->BusinessSubTypeId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getBusinessData()
 {
 	$packet = 	
		$this->BusinessId.";".
		$this->Name.";".
		$this->Description.";".
		$this->Address.";".
		$this->telephone.";".
		$this->fax.";".
		$this->website.";".
		$this->email.";".
		$this->BusinessTypeId.";".
		$this->BusinessSubTypeId;

	return $packet;
 }
 
 
  public function getBusinessPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"BusinessData\" id=\"Businessdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getBusinessData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewBusiness()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->BusinessId."</td>";
		$html .= "<td>".$this->Name."</td>";
		$html .= "<td>".$this->Description."</td>";
		$html .= "<td>".$this->Address."</td>";
		$html .= "<td>".$this->telephone."</td>";
		$html .= "<td>".$this->fax."</td>";
		$html .= "<td>".$this->website."</td>";
		$html .= "<td>".$this->email."</td>";
		$html .= "<td>".$this->BusinessTypeId."</td>";
		$html .= "<td>".$this->BusinessSubTypeId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>