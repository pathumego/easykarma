function Location()
{
this.LocationId="";
this.Name="";
this.LocationType="";
this.Description="";

}

Location.prototype.setLocation = function(LocationId_,Name_,LocationType_,Description_)
{
this.LocationId=LocationId_;
this.Name=Name_;
this.LocationType=LocationType_;
this.Description=Description_;

},

Location.prototype.createLocationPacket = function()
{
	var packet = "";	
	packet += this.LocationId+";";
	packet += this.Name+";";
	packet += this.LocationType+";";
	packet += this.Description;

	return packet;
}


Location.prototype.getLocationData = function()
{
	var packet = "";	
	packet += this.LocationId+";";
	packet += this.Name+";";
	packet += this.LocationType+";";
	packet += this.Description;

	return packet;
}

