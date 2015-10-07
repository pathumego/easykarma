<?php
class Village_organization
{
		public $OrganizationId;
		public $VillageId;


public function setVillage_organization($OrganizationId_,$VillageId_)
{
		$this->OrganizationId= $OrganizationId_;
		$this->VillageId= $VillageId_;

}

public function wsGetVillage_organizationData()
{
	return	array(	
		'OrganizationId'=> $this->OrganizationId,
		'VillageId'=> $this->VillageId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_organizationData()
 {
 	$packet = 	
		$this->OrganizationId.";".
		$this->VillageId;

	return $packet;
 }
 
 
  public function getVillage_organizationPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_organizationData\" id=\"Village_organizationdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_organizationData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_organization()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->OrganizationId."</td>";
		$html .= "<td>".$this->VillageId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>