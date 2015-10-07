function Village_plant()
{
this.PlantId="";
this.VillageId="";

}

Village_plant.prototype.setVillage_plant = function(PlantId_,VillageId_)
{
this.PlantId=PlantId_;
this.VillageId=VillageId_;

},

Village_plant.prototype.createVillage_plantPacket = function()
{
	var packet = "";	
	packet += this.PlantId+";";
	packet += this.VillageId;

	return packet;
}


Village_plant.prototype.getVillage_plantData = function()
{
	var packet = "";	
	packet += this.PlantId+";";
	packet += this.VillageId;

	return packet;
}

