function Town()
{
this.TownId="";
this.TownName="";
this.Description="";

}

Town.prototype.setTown = function(TownId_,TownName_,Description_)
{
this.TownId=TownId_;
this.TownName=TownName_;
this.Description=Description_;

},

Town.prototype.createTownPacket = function()
{
	var packet = "";	
	packet += this.TownId+";";
	packet += this.TownName+";";
	packet += this.Description;

	return packet;
}


Town.prototype.getTownData = function()
{
	var packet = "";	
	packet += this.TownId+";";
	packet += this.TownName+";";
	packet += this.Description;

	return packet;
}

