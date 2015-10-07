function Village_neartowns()
{
this.VillageId="";
this.TownId="";
this.Distance="";
this.Description="";

}

Village_neartowns.prototype.setVillage_neartowns = function(VillageId_,TownId_,Distance_,Description_)
{
this.VillageId=VillageId_;
this.TownId=TownId_;
this.Distance=Distance_;
this.Description=Description_;

},

Village_neartowns.prototype.createVillage_neartownsPacket = function()
{
	var packet = "";	
	packet += this.VillageId+";";
	packet += this.TownId+";";
	packet += this.Distance+";";
	packet += this.Description;

	return packet;
}


Village_neartowns.prototype.getVillage_neartownsData = function()
{
	var packet = "";	
	packet += this.VillageId+";";
	packet += this.TownId+";";
	packet += this.Distance+";";
	packet += this.Description;

	return packet;
}

