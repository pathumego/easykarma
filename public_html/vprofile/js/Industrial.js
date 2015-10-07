function Industrial()
{
this.IndustrialId="";
this.IndustrialName="";
this.Description="";

}

Industrial.prototype.setIndustrial = function(IndustrialId_,IndustrialName_,Description_)
{
this.IndustrialId=IndustrialId_;
this.IndustrialName=IndustrialName_;
this.Description=Description_;

},

Industrial.prototype.createIndustrialPacket = function()
{
	var packet = "";	
	packet += this.IndustrialId+";";
	packet += this.IndustrialName+";";
	packet += this.Description;

	return packet;
}


Industrial.prototype.getIndustrialData = function()
{
	var packet = "";	
	packet += this.IndustrialId+";";
	packet += this.IndustrialName+";";
	packet += this.Description;

	return packet;
}

