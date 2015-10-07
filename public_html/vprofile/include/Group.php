<?php
class Group
{
		public $GroupId;
		public $GroupName;
		public $GroupPrimaryType;
		public $GroupMissionTypeId;
		public $GroupAddress;


public function setGroup($GroupId_,$GroupName_,$GroupPrimaryType_,$GroupMissionTypeId_,$GroupAddress_)
{
		$this->GroupId= $GroupId_;
		$this->GroupName= $GroupName_;
		$this->GroupPrimaryType= $GroupPrimaryType_;
		$this->GroupMissionTypeId= $GroupMissionTypeId_;
		$this->GroupAddress= $GroupAddress_;

}

public function wsGetGroupData()
{
	return	array(	
		'GroupId'=> $this->GroupId,
		'GroupName'=> $this->GroupName,
		'GroupPrimaryType'=> $this->GroupPrimaryType,
		'GroupMissionTypeId'=> $this->GroupMissionTypeId,
		'GroupAddress'=> $this->GroupAddress

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getGroupData()
 {
 	$packet = 	
		$this->GroupId.";".
		$this->GroupName.";".
		$this->GroupPrimaryType.";".
		$this->GroupMissionTypeId.";".
		$this->GroupAddress;

	return $packet;
 }
 
 
  public function getGroupPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"GroupData\" id=\"Groupdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getGroupData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewGroup()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->GroupId."</td>";
		$html .= "<td>".$this->GroupName."</td>";
		$html .= "<td>".$this->GroupPrimaryType."</td>";
		$html .= "<td>".$this->GroupMissionTypeId."</td>";
		$html .= "<td>".$this->GroupAddress."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>