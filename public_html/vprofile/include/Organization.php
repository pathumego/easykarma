<?php
class Organization
{
		public $OrganizationId;
		public $Name;
		public $Description;
		public $Address;
		public $telephone;
		public $fax;
		public $website;
		public $email;
		public $OrganizationTypeId;
		public $OrganizationSubTypeId;


public function setOrganization($OrganizationId_,$Name_,$Description_,$Address_,$telephone_,$fax_,$website_,$email_,$OrganizationTypeId_,$OrganizationSubTypeId_)
{
		$this->OrganizationId= $OrganizationId_;
		$this->Name= $Name_;
		$this->Description= $Description_;
		$this->Address= $Address_;
		$this->telephone= $telephone_;
		$this->fax= $fax_;
		$this->website= $website_;
		$this->email= $email_;
		$this->OrganizationTypeId= $OrganizationTypeId_;
		$this->OrganizationSubTypeId= $OrganizationSubTypeId_;

}

public function wsGetOrganizationData()
{
	return	array(	
		'OrganizationId'=> $this->OrganizationId,
		'Name'=> $this->Name,
		'Description'=> $this->Description,
		'Address'=> $this->Address,
		'telephone'=> $this->telephone,
		'fax'=> $this->fax,
		'website'=> $this->website,
		'email'=> $this->email,
		'OrganizationTypeId'=> $this->OrganizationTypeId,
		'OrganizationSubTypeId'=> $this->OrganizationSubTypeId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getOrganizationData()
 {
 	$packet = 	
		$this->OrganizationId.";".
		$this->Name.";".
		$this->Description.";".
		$this->Address.";".
		$this->telephone.";".
		$this->fax.";".
		$this->website.";".
		$this->email.";".
		$this->OrganizationTypeId.";".
		$this->OrganizationSubTypeId;

	return $packet;
 }
 
 
  public function getOrganizationPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"OrganizationData\" id=\"Organizationdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getOrganizationData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewOrganization()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->OrganizationId."</td>";
		$html .= "<td>".$this->Name."</td>";
		$html .= "<td>".$this->Description."</td>";
		$html .= "<td>".$this->Address."</td>";
		$html .= "<td>".$this->telephone."</td>";
		$html .= "<td>".$this->fax."</td>";
		$html .= "<td>".$this->website."</td>";
		$html .= "<td>".$this->email."</td>";
		$html .= "<td>".$this->OrganizationTypeId."</td>";
		$html .= "<td>".$this->OrganizationSubTypeId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>