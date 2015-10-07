function Person_languageskill()
{
this.LangSkillId="";
this.PersonId="";
this.Language="";
this.SkillType="";
this.Grade="";

}

Person_languageskill.prototype.setPerson_languageskill = function(LangSkillId_,PersonId_,Language_,SkillType_,Grade_)
{
this.LangSkillId=LangSkillId_;
this.PersonId=PersonId_;
this.Language=Language_;
this.SkillType=SkillType_;
this.Grade=Grade_;

},

Person_languageskill.prototype.createPerson_languageskillPacket = function()
{
	var packet = "";	
	packet += this.LangSkillId+";";
	packet += this.PersonId+";";
	packet += this.Language+";";
	packet += this.SkillType+";";
	packet += this.Grade;

	return packet;
}


Person_languageskill.prototype.getPerson_languageskillData = function()
{
	var packet = "";	
	packet += this.LangSkillId+";";
	packet += this.PersonId+";";
	packet += this.Language+";";
	packet += this.SkillType+";";
	packet += this.Grade;

	return packet;
}

