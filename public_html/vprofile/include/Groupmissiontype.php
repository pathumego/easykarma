<?php
class Groupmissiontype
{
		public $GroupMissionTypeId;
		public $GroupMissionTypeName;
		public $Description;


public function setGroupmissiontype($GroupMissionTypeId_,$GroupMissionTypeName_,$Description_)
{
		$this->GroupMissionTypeId= $GroupMissionTypeId_;
		$this->GroupMissionTypeName= $GroupMissionTypeName_;
		$this->Description= $Description_;

}

public function wsGetGroupmissiontypeData()
{
	return	array(	
		'GroupMissionTypeId'=> $this->GroupMissionTypeId,
		'GroupMissionTypeName'=> $this->GroupMissionTypeName,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getGroupmissiontypeData()
 {
 	$packet = 	
		$this->GroupMissionTypeId.";".
		$this->GroupMissionTypeName.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getGroupmissiontypePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"GroupmissiontypeData\" id=\"Groupmissiontypedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getGroupmissiontypeData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewGroupmissiontype()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->GroupMissionTypeId."</td>";
		$html .= "<td>".$this->GroupMissionTypeName."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>