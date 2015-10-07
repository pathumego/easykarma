<?php
class Society_member
{
		public $VillageSocietyId;
		public $MemberId;
		public $MemberType;
		public $MemberDate;
		public $Description;


public function setSociety_member($VillageSocietyId_,$MemberId_,$MemberType_,$MemberDate_,$Description_)
{
		$this->VillageSocietyId= $VillageSocietyId_;
		$this->MemberId= $MemberId_;
		$this->MemberType= $MemberType_;
		$this->MemberDate= $MemberDate_;
		$this->Description= $Description_;

}

public function wsGetSociety_memberData()
{
	return	array(	
		'VillageSocietyId'=> $this->VillageSocietyId,
		'MemberId'=> $this->MemberId,
		'MemberType'=> $this->MemberType,
		'MemberDate'=> $this->MemberDate,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getSociety_memberData()
 {
 	$packet = 	
		$this->VillageSocietyId.";".
		$this->MemberId.";".
		$this->MemberType.";".
		$this->MemberDate.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getSociety_memberPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Society_memberData\" id=\"Society_memberdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getSociety_memberData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewSociety_member()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->VillageSocietyId."</td>";
		$html .= "<td>".$this->MemberId."</td>";
		$html .= "<td>".$this->MemberType."</td>";
		$html .= "<td>".$this->MemberDate."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>