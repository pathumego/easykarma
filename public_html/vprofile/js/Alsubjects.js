function Alsubjects()
{
this.SubjectId="";
this.SubjectName="";
this.SubjectNumber="";

}

Alsubjects.prototype.setAlsubjects = function(SubjectId_,SubjectName_,SubjectNumber_)
{
this.SubjectId=SubjectId_;
this.SubjectName=SubjectName_;
this.SubjectNumber=SubjectNumber_;

},

Alsubjects.prototype.createAlsubjectsPacket = function()
{
	var packet = "";	
	packet += this.SubjectId+";";
	packet += this.SubjectName+";";
	packet += this.SubjectNumber;

	return packet;
}


Alsubjects.prototype.getAlsubjectsData = function()
{
	var packet = "";	
	packet += this.SubjectId+";";
	packet += this.SubjectName+";";
	packet += this.SubjectNumber;

	return packet;
}

