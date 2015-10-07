function Person_educationlevel()
{
this.EducationLevelId="";
this.SchoolId="";
this.StartYear="";
this.StartClass="";
this.EndYear="";
this.EndClass="";
this.PersonId="";

}

Person_educationlevel.prototype.setPerson_educationlevel = function(EducationLevelId_,SchoolId_,StartYear_,StartClass_,EndYear_,EndClass_,PersonId_)
{
this.EducationLevelId=EducationLevelId_;
this.SchoolId=SchoolId_;
this.StartYear=StartYear_;
this.StartClass=StartClass_;
this.EndYear=EndYear_;
this.EndClass=EndClass_;
this.PersonId=PersonId_;

},

Person_educationlevel.prototype.createPerson_educationlevelPacket = function()
{
	var packet = "";	
	packet += this.EducationLevelId+";";
	packet += this.SchoolId+";";
	packet += this.StartYear+";";
	packet += this.StartClass+";";
	packet += this.EndYear+";";
	packet += this.EndClass+";";
	packet += this.PersonId;

	return packet;
}


Person_educationlevel.prototype.getPerson_educationlevelData = function()
{
	var packet = "";	
	packet += this.EducationLevelId+";";
	packet += this.SchoolId+";";
	packet += this.StartYear+";";
	packet += this.StartClass+";";
	packet += this.EndYear+";";
	packet += this.EndClass+";";
	packet += this.PersonId;

	return packet;
}

