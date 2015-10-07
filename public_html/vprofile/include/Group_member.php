<?php
class Group_member
{
		public $GroupId;
		public $MemberId;
		public $MemberType;
		public $MemberDate;
		public $Description;


public function setGroup_member($GroupId_,$MemberId_,$MemberType_,$MemberDate_,$Description_)
{
		$this->GroupId= $GroupId_;
		$this->MemberId= $MemberId_;
		$this->MemberType= $MemberType_;
		$this->MemberDate= $MemberDate_;
		$this->Description= $Description_;

}

public function wsGetGroup_memberData()
{
	return	array(	
		'GroupId'=> $this->GroupId,
		'MemberId'=> $this->MemberId,
		'MemberType'=> $this->MemberType,
		'MemberDate'=> $this->MemberDate,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getGroup_memberData()
 {
 	$packet = 	
		$this->GroupId.";".
		$this->MemberId.";".
		$this->MemberType.";".
		$this->MemberDate.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getGroup_memberPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Group_memberData\" id=\"Group_memberdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getGroup_memberData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewGroup_member()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->GroupId."</td>";
		$html .= "<td>".$this->MemberId."</td>";
		$html .= "<td>".$this->MemberType."</td>";
		$html .= "<td>".$this->MemberDate."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>