function Person_vocationaltraining()
{
this.VocationalTrainId="";
this.FieldName="";
this.CourseName="";
this.InstituteId="";
this.StartDate="";
this.EndDate="";
this.CertificateType="";
this.PersonId="";

}

Person_vocationaltraining.prototype.setPerson_vocationaltraining = function(VocationalTrainId_,FieldName_,CourseName_,InstituteId_,StartDate_,EndDate_,CertificateType_,PersonId_)
{
this.VocationalTrainId=VocationalTrainId_;
this.FieldName=FieldName_;
this.CourseName=CourseName_;
this.InstituteId=InstituteId_;
this.StartDate=StartDate_;
this.EndDate=EndDate_;
this.CertificateType=CertificateType_;
this.PersonId=PersonId_;

},

Person_vocationaltraining.prototype.createPerson_vocationaltrainingPacket = function()
{
	var packet = "";	
	packet += this.VocationalTrainId+";";
	packet += this.FieldName+";";
	packet += this.CourseName+";";
	packet += this.InstituteId+";";
	packet += this.StartDate+";";
	packet += this.EndDate+";";
	packet += this.CertificateType+";";
	packet += this.PersonId;

	return packet;
}


Person_vocationaltraining.prototype.getPerson_vocationaltrainingData = function()
{
	var packet = "";	
	packet += this.VocationalTrainId+";";
	packet += this.FieldName+";";
	packet += this.CourseName+";";
	packet += this.InstituteId+";";
	packet += this.StartDate+";";
	packet += this.EndDate+";";
	packet += this.CertificateType+";";
	packet += this.PersonId;

	return packet;
}

