function Talent()
{
this.TalentId="";
this.TalentType="";
this.TalentField="";
this.Description="";
this.TalentName="";

}

Talent.prototype.setTalent = function(TalentId_,TalentType_,TalentField_,Description_,TalentName_)
{
this.TalentId=TalentId_;
this.TalentType=TalentType_;
this.TalentField=TalentField_;
this.Description=Description_;
this.TalentName=TalentName_;

},

Talent.prototype.createTalentPacket = function()
{
	var packet = "";	
	packet += this.TalentId+";";
	packet += this.TalentType+";";
	packet += this.TalentField+";";
	packet += this.Description+";";
	packet += this.TalentName;

	return packet;
}


Talent.prototype.getTalentData = function()
{
	var packet = "";	
	packet += this.TalentId+";";
	packet += this.TalentType+";";
	packet += this.TalentField+";";
	packet += this.Description+";";
	packet += this.TalentName;

	return packet;
}

