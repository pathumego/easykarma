function Village_group()
{
this.GroupId="";
this.VillageId="";

}

Village_group.prototype.setVillage_group = function(GroupId_,VillageId_)
{
this.GroupId=GroupId_;
this.VillageId=VillageId_;

},

Village_group.prototype.createVillage_groupPacket = function()
{
	var packet = "";	
	packet += this.GroupId+";";
	packet += this.VillageId;

	return packet;
}


Village_group.prototype.getVillage_groupData = function()
{
	var packet = "";	
	packet += this.GroupId+";";
	packet += this.VillageId;

	return packet;
}

