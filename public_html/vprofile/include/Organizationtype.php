<?php
class Organizationtype
{
		public $OrganizationTypeId;
		public $OrganizationTypeName;
		public $Description;


public function setOrganizationtype($OrganizationTypeId_,$OrganizationTypeName_,$Description_)
{
		$this->OrganizationTypeId= $OrganizationTypeId_;
		$this->OrganizationTypeName= $OrganizationTypeName_;
		$this->Description= $Description_;

}

public function wsGetOrganizationtypeData()
{
	return	array(	
		'OrganizationTypeId'=> $this->OrganizationTypeId,
		'OrganizationTypeName'=> $this->OrganizationTypeName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getOrganizationtypeData()
 {
 	$packet = 	
		$this->OrganizationTypeId.";".
		$this->OrganizationTypeName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getOrganizationtypePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"OrganizationtypeData\" id=\"Organizationtypedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getOrganizationtypeData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewOrganizationtype()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->OrganizationTypeId."</td>";
		$html .= "<td>".$this->OrganizationTypeName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>