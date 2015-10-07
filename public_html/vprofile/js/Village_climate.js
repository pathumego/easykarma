function Village_climate()
{
this.ClimateId="";
this.VillageId="";
this.ClimateReagion="";
this.RainFall="";
this.Temparature="";
this.Humidity="";

}

Village_climate.prototype.setVillage_climate = function(ClimateId_,VillageId_,ClimateReagion_,RainFall_,Temparature_,Humidity_)
{
this.ClimateId=ClimateId_;
this.VillageId=VillageId_;
this.ClimateReagion=ClimateReagion_;
this.RainFall=RainFall_;
this.Temparature=Temparature_;
this.Humidity=Humidity_;

},

Village_climate.prototype.createVillage_climatePacket = function()
{
	var packet = "";	
	packet += this.ClimateId+";";
	packet += this.VillageId+";";
	packet += this.ClimateReagion+";";
	packet += this.RainFall+";";
	packet += this.Temparature+";";
	packet += this.Humidity;

	return packet;
}


Village_climate.prototype.getVillage_climateData = function()
{
	var packet = "";	
	packet += this.ClimateId+";";
	packet += this.VillageId+";";
	packet += this.ClimateReagion+";";
	packet += this.RainFall+";";
	packet += this.Temparature+";";
	packet += this.Humidity;

	return packet;
}

