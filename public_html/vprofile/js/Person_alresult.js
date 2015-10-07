function Person_alresult()
{
this.ALResultId="";
this.SubjectId="";
this.SchoolId="";
this.Grade="";
this.Language="";
this.DateTime="";
this.PersonId="";

}

Person_alresult.prototype.setPerson_alresult = function(ALResultId_,SubjectId_,SchoolId_,Grade_,Language_,DateTime_,PersonId_)
{
this.ALResultId=ALResultId_;
this.SubjectId=SubjectId_;
this.SchoolId=SchoolId_;
this.Grade=Grade_;
this.Language=Language_;
this.DateTime=DateTime_;
this.PersonId=PersonId_;

},

Person_alresult.prototype.createPerson_alresultPacket = function()
{
	var packet = "";	
	packet += this.ALResultId+";";
	packet += this.SubjectId+";";
	packet += this.SchoolId+";";
	packet += this.Grade+";";
	packet += this.Language+";";
	packet += this.DateTime+";";
	packet += this.PersonId;

	return packet;
}


Person_alresult.prototype.getPerson_alresultData = function()
{
	var packet = "";	
	packet += this.ALResultId+";";
	packet += this.SubjectId+";";
	packet += this.SchoolId+";";
	packet += this.Grade+";";
	packet += this.Language+";";
	packet += this.DateTime+";";
	packet += this.PersonId;

	return packet;
}

