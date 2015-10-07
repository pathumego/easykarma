function Olsubjects()
{
this.SubjectId="";
this.SubjectName="";
this.SubjectNumber="";

}

Olsubjects.prototype.setOlsubjects = function(SubjectId_,SubjectName_,SubjectNumber_)
{
this.SubjectId=SubjectId_;
this.SubjectName=SubjectName_;
this.SubjectNumber=SubjectNumber_;

},

Olsubjects.prototype.createOlsubjectsPacket = function()
{
	var packet = "";	
	packet += this.SubjectId+";";
	packet += this.SubjectName+";";
	packet += this.SubjectNumber;

	return packet;
}


Olsubjects.prototype.getOlsubjectsData = function()
{
	var packet = "";	
	packet += this.SubjectId+";";
	packet += this.SubjectName+";";
	packet += this.SubjectNumber;

	return packet;
}

