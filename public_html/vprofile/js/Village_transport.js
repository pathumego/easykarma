function Village_transport()
{
this.TransportId="";
this.VillageId="";
this.Description="";

}

Village_transport.prototype.setVillage_transport = function(TransportId_,VillageId_,Description_)
{
this.TransportId=TransportId_;
this.VillageId=VillageId_;
this.Description=Description_;

},

Village_transport.prototype.createVillage_transportPacket = function()
{
	var packet = "";	
	packet += this.TransportId+";";
	packet += this.VillageId+";";
	packet += this.Description;

	return packet;
}


Village_transport.prototype.getVillage_transportData = function()
{
	var packet = "";	
	packet += this.TransportId+";";
	packet += this.VillageId+";";
	packet += this.Description;

	return packet;
}

