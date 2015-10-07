function Group()
{
this.GroupId="";
this.GroupName="";
this.GroupPrimaryType="";
this.GroupMissionTypeId="";
this.GroupAddress="";

}

Group.prototype.setGroup = function(GroupId_,GroupName_,GroupPrimaryType_,GroupMissionTypeId_,GroupAddress_)
{
this.GroupId=GroupId_;
this.GroupName=GroupName_;
this.GroupPrimaryType=GroupPrimaryType_;
this.GroupMissionTypeId=GroupMissionTypeId_;
this.GroupAddress=GroupAddress_;

},

Group.prototype.createGroupPacket = function()
{
	var packet = "";	
	packet += this.GroupId+";";
	packet += this.GroupName+";";
	packet += this.GroupPrimaryType+";";
	packet += this.GroupMissionTypeId+";";
	packet += this.GroupAddress;

	return packet;
}


Group.prototype.getGroupData = function()
{
	var packet = "";	
	packet += this.GroupId+";";
	packet += this.GroupName+";";
	packet += this.GroupPrimaryType+";";
	packet += this.GroupMissionTypeId+";";
	packet += this.GroupAddress;

	return packet;
}

