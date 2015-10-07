<?php
class Society
{
		public $SocietyId;
		public $Name;
		public $Description;
		public $Mission;
		public $SocietyTypeId;
		public $SocietyAddress;


public function setSociety($SocietyId_,$Name_,$Description_,$Mission_,$SocietyTypeId_,$SocietyAddress_)
{
		$this->SocietyId= $SocietyId_;
		$this->Name= $Name_;
		$this->Description= $Description_;
		$this->Mission= $Mission_;
		$this->SocietyTypeId= $SocietyTypeId_;
		$this->SocietyAddress= $SocietyAddress_;

}

public function wsGetSocietyData()
{
	return	array(	
		'SocietyId'=> $this->SocietyId,
		'Name'=> $this->Name,
		'Description'=> $this->Description,
		'Mission'=> $this->Mission,
		'SocietyTypeId'=> $this->SocietyTypeId,
		'SocietyAddress'=> $this->SocietyAddress

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getSocietyData()
 {
 	$packet = 	
		$this->SocietyId.";".
		$this->Name.";".
		$this->Description.";".
		$this->Mission.";".
		$this->SocietyTypeId.";".
		$this->SocietyAddress;

	return $packet;
 }
 
 
  public function getSocietyPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"SocietyData\" id=\"Societydata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getSocietyData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewSociety()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->SocietyId."</td>";
		$html .= "<td>".$this->Name."</td>";
		$html .= "<td>".$this->Description."</td>";
		$html .= "<td>".$this->Mission."</td>";
		$html .= "<td>".$this->SocietyTypeId."</td>";
		$html .= "<td>".$this->SocietyAddress."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>