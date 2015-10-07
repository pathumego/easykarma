function Person_workingexperiance()
{
this.WorkExpId="";
this.CompanyId="";
this.StartDate="";
this.EndDate="";
this.Position="";
this.PersonId="";

}

Person_workingexperiance.prototype.setPerson_workingexperiance = function(WorkExpId_,CompanyId_,StartDate_,EndDate_,Position_,PersonId_)
{
this.WorkExpId=WorkExpId_;
this.CompanyId=CompanyId_;
this.StartDate=StartDate_;
this.EndDate=EndDate_;
this.Position=Position_;
this.PersonId=PersonId_;

},

Person_workingexperiance.prototype.createPerson_workingexperiancePacket = function()
{
	var packet = "";	
	packet += this.WorkExpId+";";
	packet += this.CompanyId+";";
	packet += this.StartDate+";";
	packet += this.EndDate+";";
	packet += this.Position+";";
	packet += this.PersonId;

	return packet;
}


Person_workingexperiance.prototype.getPerson_workingexperianceData = function()
{
	var packet = "";	
	packet += this.WorkExpId+";";
	packet += this.CompanyId+";";
	packet += this.StartDate+";";
	packet += this.EndDate+";";
	packet += this.Position+";";
	packet += this.PersonId;

	return packet;
}

