function Village_industrial()
{
this.IndustrialId="";
this.VillageId="";
this.BusinessId="";
this.Description="";

}

Village_industrial.prototype.setVillage_industrial = function(IndustrialId_,VillageId_,BusinessId_,Description_)
{
this.IndustrialId=IndustrialId_;
this.VillageId=VillageId_;
this.BusinessId=BusinessId_;
this.Description=Description_;

},

Village_industrial.prototype.createVillage_industrialPacket = function()
{
	var packet = "";	
	packet += this.IndustrialId+";";
	packet += this.VillageId+";";
	packet += this.BusinessId+";";
	packet += this.Description;

	return packet;
}


Village_industrial.prototype.getVillage_industrialData = function()
{
	var packet = "";	
	packet += this.IndustrialId+";";
	packet += this.VillageId+";";
	packet += this.BusinessId+";";
	packet += this.Description;

	return packet;
}

