<?php
class Socierytype
{
		public $SocieryTypeId;
		public $SocieryTypeName;
		public $Description;


public function setSocierytype($SocieryTypeId_,$SocieryTypeName_,$Description_)
{
		$this->SocieryTypeId= $SocieryTypeId_;
		$this->SocieryTypeName= $SocieryTypeName_;
		$this->Description= $Description_;

}

public function wsGetSocierytypeData()
{
	return	array(	
		'SocieryTypeId'=> $this->SocieryTypeId,
		'SocieryTypeName'=> $this->SocieryTypeName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getSocierytypeData()
 {
 	$packet = 	
		$this->SocieryTypeId.";".
		$this->SocieryTypeName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getSocierytypePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"SocierytypeData\" id=\"Socierytypedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getSocierytypeData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewSocierytype()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->SocieryTypeId."</td>";
		$html .= "<td>".$this->SocieryTypeName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>