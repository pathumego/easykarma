<?php
class User
{
		public $userId;
		public $userName;
		public $password;
		public $personId;
		public $userType;
		public $userOptCode;
		public $userMetadata;
		public $userStatus;

public function setUser($userId_,$userName_,$password_,$personId_,$userType_,$userOptCode_,$userMetadata_,$userStatus_)
{
		$this->userId= $userId_;
		$this->userName= $userName_;
		$this->password= $password_;
		$this->personId= $personId_;
		$this->userType= $userType_;
		$this->userOptCode= $userOptCode_;
		$this->userMetadata= $userMetadata_;
		$this->userStatus= $userStatus_;
}

public function wsGetUserData()
{
	return	array(	
		'userId'=> $this->userId,
		'userName'=> $this->userName,
		'password'=> $this->password,
		'personId'=> $this->personId,
		'userType'=> $this->userType,
		'userOptCode'=>$this->userOptCode,
		'userMetadata'=>$this->userMetadata,
		'userStatus'=>$this->userStatus
	);					
	
}
//---------------------------------------------------------------------------
 
 public function getUserData()
 {
 	$packet = 	
		$this->userId.";".
		$this->userName.";".
		$this->password.";".
		$this->personId.";".
		$this->userType.";".
		$this->userOptCode.";".
		$this->userMetadata.";".
		$this->userStatus;
	return $packet;
 }
 
 
  public function getUserPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"UserData\" id=\"Userdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getUserData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 
public function drawTableViewUser()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->userId."</td>";
		$html .= "<td>".$this->userName."</td>";
		$html .= "<td>".$this->password."</td>";
		$html .= "<td>".$this->personId."</td>";
		$html .= "<td>".$this->userType."</td>";
		$html .= "<td>".$this->userOptCode."</td>";
		$html .= "<td>".$this->userMetadata."</td>";
		$html .= "<td>".$this->userStatus."</td>";		
		$html .= "</tr>";

return $html;
}

 
}
?>