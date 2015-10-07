function Person_talent()
{
this.TblId="";
this.PersonId="";
this.TalentId="";

}

Person_talent.prototype.setPerson_talent = function(TblId_,PersonId_,TalentId_)
{
this.TblId=TblId_;
this.PersonId=PersonId_;
this.TalentId=TalentId_;

},

Person_talent.prototype.createPerson_talentPacket = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.PersonId+";";
	packet += this.TalentId;

	return packet;
}


Person_talent.prototype.getPerson_talentData = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.PersonId+";";
	packet += this.TalentId;

	return packet;
}

