<?php
class Person
{
		public $PersonId;
		public $FullName;
		public $NickName;
		public $OtherNames;
		public $DrivingLicenceNo;
		public $PassportNo;
		public $PermanentAddress;
		public $Email;
		public $Website;
		public $Description;
		public $Gender;
		public $DOB;
		public $Height;
		public $Weight;
		public $HairColor;
		public $EyeColor;
		public $BloodType;
		public $Occupation;
		public $MonthlyIncome;
		public $FutureTargets;
		public $FutureNeeds;
		public $DOD;
		public $Picture;
		public $NIC;
		public $Status;


public function setPerson($PersonId_,$FullName_,$NickName_,$OtherNames_,$DrivingLicenceNo_,$PassportNo_,$PermanentAddress_,$Email_,$Website_,$Description_,$Gender_,$DOB_,$Height_,$Weight_,$HairColor_,$EyeColor_,$BloodType_,$Occupation_,$MonthlyIncome_,$FutureTargets_,$FutureNeeds_,$DOD_,$Picture_,$NIC_,$Status_)
{
		$this->PersonId= $PersonId_;
		$this->FullName= $FullName_;
		$this->NickName= $NickName_;
		$this->OtherNames= $OtherNames_;
		$this->DrivingLicenceNo= $DrivingLicenceNo_;
		$this->PassportNo= $PassportNo_;
		$this->PermanentAddress= $PermanentAddress_;
		$this->Email= $Email_;
		$this->Website= $Website_;
		$this->Description= $Description_;
		$this->Gender= $Gender_;
		$this->DOB= $DOB_;
		$this->Height= $Height_;
		$this->Weight= $Weight_;
		$this->HairColor= $HairColor_;
		$this->EyeColor= $EyeColor_;
		$this->BloodType= $BloodType_;
		$this->Occupation= $Occupation_;
		$this->MonthlyIncome= $MonthlyIncome_;
		$this->FutureTargets= $FutureTargets_;
		$this->FutureNeeds= $FutureNeeds_;
		$this->DOD= $DOD_;
		$this->Picture= $Picture_;
		$this->NIC= $NIC_;
		$this->Status= $Status_;

}

public function wsGetPersonData()
{
	return	array(	
		'PersonId'=> $this->PersonId,
		'FullName'=> $this->FullName,
		'NickName'=> $this->NickName,
		'OtherNames'=> $this->OtherNames,
		'DrivingLicenceNo'=> $this->DrivingLicenceNo,
		'PassportNo'=> $this->PassportNo,
		'PermanentAddress'=> $this->PermanentAddress,
		'Email'=> $this->Email,
		'Website'=> $this->Website,
		'Description'=> $this->Description,
		'Gender'=> $this->Gender,
		'DOB'=> $this->DOB,
		'Height'=> $this->Height,
		'Weight'=> $this->Weight,
		'HairColor'=> $this->HairColor,
		'EyeColor'=> $this->EyeColor,
		'BloodType'=> $this->BloodType,
		'Occupation'=> $this->Occupation,
		'MonthlyIncome'=> $this->MonthlyIncome,
		'FutureTargets'=> $this->FutureTargets,
		'FutureNeeds'=> $this->FutureNeeds,
		'DOD'=> $this->DOD,
		'Picture'=> $this->Picture,
		'NIC'=> $this->NIC,
		'Status'=> $this->Status

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getPersonData()
 {
 	$packet = 	
		$this->PersonId.";".
		$this->FullName.";".
		$this->NickName.";".
		$this->OtherNames.";".
		$this->DrivingLicenceNo.";".
		$this->PassportNo.";".
		$this->PermanentAddress.";".
		$this->Email.";".
		$this->Website.";".
		$this->Description.";".
		$this->Gender.";".
		$this->DOB.";".
		$this->Height.";".
		$this->Weight.";".
		$this->HairColor.";".
		$this->EyeColor.";".
		$this->BloodType.";".
		$this->Occupation.";".
		$this->MonthlyIncome.";".
		$this->FutureTargets.";".
		$this->FutureNeeds.";".
		$this->DOD.";".
		$this->Picture.";".
		$this->NIC.";".
		$this->Status;

	return $packet;
 }
 
 
  public function getPersonPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"PersonData\" id=\"Persondata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getPersonData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewPerson()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->PersonId."</td>";
		$html .= "<td>".$this->FullName."</td>";
		$html .= "<td>".$this->NickName."</td>";
		$html .= "<td>".$this->OtherNames."</td>";
		$html .= "<td>".$this->DrivingLicenceNo."</td>";
		$html .= "<td>".$this->PassportNo."</td>";
		$html .= "<td>".$this->PermanentAddress."</td>";
		$html .= "<td>".$this->Email."</td>";
		$html .= "<td>".$this->Website."</td>";
		$html .= "<td>".$this->Description."</td>";
		$html .= "<td>".$this->Gender."</td>";
		$html .= "<td>".$this->DOB."</td>";
		$html .= "<td>".$this->Height."</td>";
		$html .= "<td>".$this->Weight."</td>";
		$html .= "<td>".$this->HairColor."</td>";
		$html .= "<td>".$this->EyeColor."</td>";
		$html .= "<td>".$this->BloodType."</td>";
		$html .= "<td>".$this->Occupation."</td>";
		$html .= "<td>".$this->MonthlyIncome."</td>";
		$html .= "<td>".$this->FutureTargets."</td>";
		$html .= "<td>".$this->FutureNeeds."</td>";
		$html .= "<td>".$this->DOD."</td>";
		$html .= "<td>".$this->Picture."</td>";
		$html .= "<td>".$this->NIC."</td>";
		$html .= "<td>".$this->Status."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>