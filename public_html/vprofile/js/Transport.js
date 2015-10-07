function Transport()
{
this.TransportId="";
this.TransportName="";
this.TransportType="";
this.Description="";

}

Transport.prototype.setTransport = function(TransportId_,TransportName_,TransportType_,Description_)
{
this.TransportId=TransportId_;
this.TransportName=TransportName_;
this.TransportType=TransportType_;
this.Description=Description_;

},

Transport.prototype.createTransportPacket = function()
{
	var packet = "";	
	packet += this.TransportId+";";
	packet += this.TransportName+";";
	packet += this.TransportType+";";
	packet += this.Description;

	return packet;
}


Transport.prototype.getTransportData = function()
{
	var packet = "";	
	packet += this.TransportId+";";
	packet += this.TransportName+";";
	packet += this.TransportType+";";
	packet += this.Description;

	return packet;
}

