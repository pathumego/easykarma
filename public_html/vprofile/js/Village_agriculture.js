function Village_agriculture()
{
this.AgricultureId="";
this.VillageId="";
this.BusinessId="";
this.Description="";

}

Village_agriculture.prototype.setVillage_agriculture = function(AgricultureId_,VillageId_,BusinessId_,Description_)
{
this.AgricultureId=AgricultureId_;
this.VillageId=VillageId_;
this.BusinessId=BusinessId_;
this.Description=Description_;

},

Village_agriculture.prototype.createVillage_agriculturePacket = function()
{
	var packet = "";	
	packet += this.AgricultureId+";";
	packet += this.VillageId+";";
	packet += this.BusinessId+";";
	packet += this.Description;

	return packet;
}


Village_agriculture.prototype.getVillage_agricultureData = function()
{
	var packet = "";	
	packet += this.AgricultureId+";";
	packet += this.VillageId+";";
	packet += this.BusinessId+";";
	packet += this.Description;

	return packet;
}

