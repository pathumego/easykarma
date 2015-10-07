<?php
class Organization_subtype
{
		public $OrganizationSubTypeId;
		public $OrganizationSubTypeName;
		public $Description;


public function setOrganization_subtype($OrganizationSubTypeId_,$OrganizationSubTypeName_,$Description_)
{
		$this->OrganizationSubTypeId= $OrganizationSubTypeId_;
		$this->OrganizationSubTypeName= $OrganizationSubTypeName_;
		$this->Description= $Description_;

}

public function wsGetOrganization_subtypeData()
{
	return	array(	
		'OrganizationSubTypeId'=> $this->OrganizationSubTypeId,
		'OrganizationSubTypeName'=> $this->OrganizationSubTypeName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getOrganization_subtypeData()
 {
 	$packet = 	
		$this->OrganizationSubTypeId.";".
		$this->OrganizationSubTypeName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getOrganization_subtypePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Organization_subtypeData\" id=\"Organization_subtypedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getOrganization_subtypeData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewOrganization_subtype()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->OrganizationSubTypeId."</td>";
		$html .= "<td>".$this->OrganizationSubTypeName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>