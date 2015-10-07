function Person_olresult()
{
this.OLResultId="";
this.SubjectId="";
this.SchoolId="";
this.Grade="";
this.Language="";
this.DateTime="";
this.PersonId="";

}

Person_olresult.prototype.setPerson_olresult = function(OLResultId_,SubjectId_,SchoolId_,Grade_,Language_,DateTime_,PersonId_)
{
this.OLResultId=OLResultId_;
this.SubjectId=SubjectId_;
this.SchoolId=SchoolId_;
this.Grade=Grade_;
this.Language=Language_;
this.DateTime=DateTime_;
this.PersonId=PersonId_;

},

Person_olresult.prototype.createPerson_olresultPacket = function()
{
	var packet = "";	
	packet += this.OLResultId+";";
	packet += this.SubjectId+";";
	packet += this.SchoolId+";";
	packet += this.Grade+";";
	packet += this.Language+";";
	packet += this.DateTime+";";
	packet += this.PersonId;

	return packet;
}


Person_olresult.prototype.getPerson_olresultData = function()
{
	var packet = "";	
	packet += this.OLResultId+";";
	packet += this.SubjectId+";";
	packet += this.SchoolId+";";
	packet += this.Grade+";";
	packet += this.Language+";";
	packet += this.DateTime+";";
	packet += this.PersonId;

	return packet;
}

