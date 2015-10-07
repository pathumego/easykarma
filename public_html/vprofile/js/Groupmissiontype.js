function Groupmissiontype()
{
this.GroupMissionTypeId="";
this.GroupMissionTypeName="";
this.Description="";

}

Groupmissiontype.prototype.setGroupmissiontype = function(GroupMissionTypeId_,GroupMissionTypeName_,Description_)
{
this.GroupMissionTypeId=GroupMissionTypeId_;
this.GroupMissionTypeName=GroupMissionTypeName_;
this.Description=Description_;

},

Groupmissiontype.prototype.createGroupmissiontypePacket = function()
{
	var packet = "";	
	packet += this.GroupMissionTypeId+";";
	packet += this.GroupMissionTypeName+";";
	packet += this.Description;

	return packet;
}


Groupmissiontype.prototype.getGroupmissiontypeData = function()
{
	var packet = "";	
	packet += this.GroupMissionTypeId+";";
	packet += this.GroupMissionTypeName+";";
	packet += this.Description;

	return packet;
}

