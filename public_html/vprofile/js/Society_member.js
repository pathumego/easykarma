function Society_member()
{
this.VillageSocietyId="";
this.MemberId="";
this.MemberType="";
this.MemberDate="";
this.Description="";

}

Society_member.prototype.setSociety_member = function(VillageSocietyId_,MemberId_,MemberType_,MemberDate_,Description_)
{
this.VillageSocietyId=VillageSocietyId_;
this.MemberId=MemberId_;
this.MemberType=MemberType_;
this.MemberDate=MemberDate_;
this.Description=Description_;

},

Society_member.prototype.createSociety_memberPacket = function()
{
	var packet = "";	
	packet += this.VillageSocietyId+";";
	packet += this.MemberId+";";
	packet += this.MemberType+";";
	packet += this.MemberDate+";";
	packet += this.Description;

	return packet;
}


Society_member.prototype.getSociety_memberData = function()
{
	var packet = "";	
	packet += this.VillageSocietyId+";";
	packet += this.MemberId+";";
	packet += this.MemberType+";";
	packet += this.MemberDate+";";
	packet += this.Description;

	return packet;
}

