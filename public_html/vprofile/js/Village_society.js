function Village_society()
{
this.SocietyId="";
this.VillageId="";
this.VillageSocietyId="";

}

Village_society.prototype.setVillage_society = function(SocietyId_,VillageId_,VillageSocietyId_)
{
this.SocietyId=SocietyId_;
this.VillageId=VillageId_;
this.VillageSocietyId=VillageSocietyId_;

},

Village_society.prototype.createVillage_societyPacket = function()
{
	var packet = "";	
	packet += this.SocietyId+";";
	packet += this.VillageId+";";
	packet += this.VillageSocietyId;

	return packet;
}


Village_society.prototype.getVillage_societyData = function()
{
	var packet = "";	
	packet += this.SocietyId+";";
	packet += this.VillageId+";";
	packet += this.VillageSocietyId;

	return packet;
}

