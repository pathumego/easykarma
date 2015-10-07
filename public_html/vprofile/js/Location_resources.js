function Location_resources()
{
this.ResourceId="";
this.LocationId="";
this.ResourceType="";
this.ResourcePath="";

}

Location_resources.prototype.setLocation_resources = function(ResourceId_,LocationId_,ResourceType_,ResourcePath_)
{
this.ResourceId=ResourceId_;
this.LocationId=LocationId_;
this.ResourceType=ResourceType_;
this.ResourcePath=ResourcePath_;

},

Location_resources.prototype.createLocation_resourcesPacket = function()
{
	var packet = "";	
	packet += this.ResourceId+";";
	packet += this.LocationId+";";
	packet += this.ResourceType+";";
	packet += this.ResourcePath;

	return packet;
}


Location_resources.prototype.getLocation_resourcesData = function()
{
	var packet = "";	
	packet += this.ResourceId+";";
	packet += this.LocationId+";";
	packet += this.ResourceType+";";
	packet += this.ResourcePath;

	return packet;
}

