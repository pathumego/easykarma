<?php
class Village_group
{
		public $GroupId;
		public $VillageId;


public function setVillage_group($GroupId_,$VillageId_)
{
		$this->GroupId= $GroupId_;
		$this->VillageId= $VillageId_;

}

public function wsGetVillage_groupData()
{
	return	array(	
		'GroupId'=> $this->GroupId,
		'VillageId'=> $this->VillageId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_groupData()
 {
 	$packet = 	
		$this->GroupId.";".
		$this->VillageId;

	return $packet;
 }
 
 
  public function getVillage_groupPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_groupData\" id=\"Village_groupdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_groupData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_group()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->GroupId."</td>";
		$html .= "<td>".$this->VillageId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>