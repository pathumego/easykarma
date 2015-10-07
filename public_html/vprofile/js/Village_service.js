function Village_service()
{
this.ServiceId="";
this.VillageId="";
this.BusinessId="";
this.Description="";

}

Village_service.prototype.setVillage_service = function(ServiceId_,VillageId_,BusinessId_,Description_)
{
this.ServiceId=ServiceId_;
this.VillageId=VillageId_;
this.BusinessId=BusinessId_;
this.Description=Description_;

},

Village_service.prototype.createVillage_servicePacket = function()
{
	var packet = "";	
	packet += this.ServiceId+";";
	packet += this.VillageId+";";
	packet += this.BusinessId+";";
	packet += this.Description;

	return packet;
}


Village_service.prototype.getVillage_serviceData = function()
{
	var packet = "";	
	packet += this.ServiceId+";";
	packet += this.VillageId+";";
	packet += this.BusinessId+";";
	packet += this.Description;

	return packet;
}

