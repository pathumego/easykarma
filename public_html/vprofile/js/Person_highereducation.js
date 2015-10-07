function Person_highereducation()
{
this.ResultId="";
this.SubjectId="";
this.InstituteId="";
this.Grade="";
this.Language="";
this.DateTime="";
this.PersonId="";
this.Level="";

}

Person_highereducation.prototype.setPerson_highereducation = function(ResultId_,SubjectId_,InstituteId_,Grade_,Language_,DateTime_,PersonId_,Level_)
{
this.ResultId=ResultId_;
this.SubjectId=SubjectId_;
this.InstituteId=InstituteId_;
this.Grade=Grade_;
this.Language=Language_;
this.DateTime=DateTime_;
this.PersonId=PersonId_;
this.Level=Level_;

},

Person_highereducation.prototype.createPerson_highereducationPacket = function()
{
	var packet = "";	
	packet += this.ResultId+";";
	packet += this.SubjectId+";";
	packet += this.InstituteId+";";
	packet += this.Grade+";";
	packet += this.Language+";";
	packet += this.DateTime+";";
	packet += this.PersonId+";";
	packet += this.Level;

	return packet;
}


Person_highereducation.prototype.getPerson_highereducationData = function()
{
	var packet = "";	
	packet += this.ResultId+";";
	packet += this.SubjectId+";";
	packet += this.InstituteId+";";
	packet += this.Grade+";";
	packet += this.Language+";";
	packet += this.DateTime+";";
	packet += this.PersonId+";";
	packet += this.Level;

	return packet;
}

