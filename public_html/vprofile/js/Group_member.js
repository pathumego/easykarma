function Group_member()
{
this.GroupId="";
this.MemberId="";
this.MemberType="";
this.MemberDate="";
this.Description="";

}

Group_member.prototype.setGroup_member = function(GroupId_,MemberId_,MemberType_,MemberDate_,Description_)
{
this.GroupId=GroupId_;
this.MemberId=MemberId_;
this.MemberType=MemberType_;
this.MemberDate=MemberDate_;
this.Description=Description_;

},

Group_member.prototype.createGroup_memberPacket = function()
{
	var packet = "";	
	packet += this.GroupId+";";
	packet += this.MemberId+";";
	packet += this.MemberType+";";
	packet += this.MemberDate+";";
	packet += this.Description;

	return packet;
}


Group_member.prototype.getGroup_memberData = function()
{
	var packet = "";	
	packet += this.GroupId+";";
	packet += this.MemberId+";";
	packet += this.MemberType+";";
	packet += this.MemberDate+";";
	packet += this.Description;

	return packet;
}

