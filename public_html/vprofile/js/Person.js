function Person()
{
this.PersonId="";
this.FullName="";
this.NickName="";
this.OtherNames="";
this.DrivingLicenceNo="";
this.PassportNo="";
this.PermanentAddress="";
this.Email="";
this.Website="";
this.Description="";
this.Gender="";
this.DOB="";
this.Height="";
this.Weight="";
this.HairColor="";
this.EyeColor="";
this.BloodType="";
this.Occupation="";
this.MonthlyIncome="";
this.FutureTargets="";
this.FutureNeeds="";
this.DOD="";
this.Picture="";
this.NIC="";
this.Status="";

}

Person.prototype.setPerson = function(PersonId_,FullName_,NickName_,OtherNames_,DrivingLicenceNo_,PassportNo_,PermanentAddress_,Email_,Website_,Description_,Gender_,DOB_,Height_,Weight_,HairColor_,EyeColor_,BloodType_,Occupation_,MonthlyIncome_,FutureTargets_,FutureNeeds_,DOD_,Picture_,NIC_,Status_)
{
this.PersonId=PersonId_;
this.FullName=FullName_;
this.NickName=NickName_;
this.OtherNames=OtherNames_;
this.DrivingLicenceNo=DrivingLicenceNo_;
this.PassportNo=PassportNo_;
this.PermanentAddress=PermanentAddress_;
this.Email=Email_;
this.Website=Website_;
this.Description=Description_;
this.Gender=Gender_;
this.DOB=DOB_;
this.Height=Height_;
this.Weight=Weight_;
this.HairColor=HairColor_;
this.EyeColor=EyeColor_;
this.BloodType=BloodType_;
this.Occupation=Occupation_;
this.MonthlyIncome=MonthlyIncome_;
this.FutureTargets=FutureTargets_;
this.FutureNeeds=FutureNeeds_;
this.DOD=DOD_;
this.Picture=Picture_;
this.NIC=NIC_;
this.Status=Status_;

},

Person.prototype.createPersonPacket = function()
{
	var packet = "";	
	packet += this.PersonId+";";
	packet += this.FullName+";";
	packet += this.NickName+";";
	packet += this.OtherNames+";";
	packet += this.DrivingLicenceNo+";";
	packet += this.PassportNo+";";
	packet += this.PermanentAddress+";";
	packet += this.Email+";";
	packet += this.Website+";";
	packet += this.Description+";";
	packet += this.Gender+";";
	packet += this.DOB+";";
	packet += this.Height+";";
	packet += this.Weight+";";
	packet += this.HairColor+";";
	packet += this.EyeColor+";";
	packet += this.BloodType+";";
	packet += this.Occupation+";";
	packet += this.MonthlyIncome+";";
	packet += this.FutureTargets+";";
	packet += this.FutureNeeds+";";
	packet += this.DOD+";";
	packet += this.Picture+";";
	packet += this.NIC+";";
	packet += this.Status;

	return packet;
}


Person.prototype.getPersonData = function()
{
	var packet = "";	
	packet += this.PersonId+";";
	packet += this.FullName+";";
	packet += this.NickName+";";
	packet += this.OtherNames+";";
	packet += this.DrivingLicenceNo+";";
	packet += this.PassportNo+";";
	packet += this.PermanentAddress+";";
	packet += this.Email+";";
	packet += this.Website+";";
	packet += this.Description+";";
	packet += this.Gender+";";
	packet += this.DOB+";";
	packet += this.Height+";";
	packet += this.Weight+";";
	packet += this.HairColor+";";
	packet += this.EyeColor+";";
	packet += this.BloodType+";";
	packet += this.Occupation+";";
	packet += this.MonthlyIncome+";";
	packet += this.FutureTargets+";";
	packet += this.FutureNeeds+";";
	packet += this.DOD+";";
	packet += this.Picture+";";
	packet += this.NIC+";";
	packet += this.Status;

	return packet;
}

