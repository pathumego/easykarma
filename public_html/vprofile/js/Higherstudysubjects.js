function Higherstudysubjects()
{
this.SubjectId="";
this.SubjectName="";
this.SubjectNumber="";
this.SubjectField="";
this.Level="";

}

Higherstudysubjects.prototype.setHigherstudysubjects = function(SubjectId_,SubjectName_,SubjectNumber_,SubjectField_,Level_)
{
this.SubjectId=SubjectId_;
this.SubjectName=SubjectName_;
this.SubjectNumber=SubjectNumber_;
this.SubjectField=SubjectField_;
this.Level=Level_;

},

Higherstudysubjects.prototype.createHigherstudysubjectsPacket = function()
{
	var packet = "";	
	packet += this.SubjectId+";";
	packet += this.SubjectName+";";
	packet += this.SubjectNumber+";";
	packet += this.SubjectField+";";
	packet += this.Level;

	return packet;
}


Higherstudysubjects.prototype.getHigherstudysubjectsData = function()
{
	var packet = "";	
	packet += this.SubjectId+";";
	packet += this.SubjectName+";";
	packet += this.SubjectNumber+";";
	packet += this.SubjectField+";";
	packet += this.Level;

	return packet;
}

