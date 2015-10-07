function Village_othernames()
{
this.VillageId="";
this.VillageNames="";

}

Village_othernames.prototype.setVillage_othernames = function(VillageId_,VillageNames_)
{
this.VillageId=VillageId_;
this.VillageNames=VillageNames_;

},

Village_othernames.prototype.createVillage_othernamesPacket = function()
{
	var packet = "";	
	packet += this.VillageId+";";
	packet += this.VillageNames;

	return packet;
}


Village_othernames.prototype.getVillage_othernamesData = function()
{
	var packet = "";	
	packet += this.VillageId+";";
	packet += this.VillageNames;

	return packet;
}

