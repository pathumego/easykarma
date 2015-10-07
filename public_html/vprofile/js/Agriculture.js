function Agriculture()
{
this.AgricultureId="";
this.AgricultureName="";
this.Description="";

}

Agriculture.prototype.setAgriculture = function(AgricultureId_,AgricultureName_,Description_)
{
this.AgricultureId=AgricultureId_;
this.AgricultureName=AgricultureName_;
this.Description=Description_;

},

Agriculture.prototype.createAgriculturePacket = function()
{
	var packet = "";	
	packet += this.AgricultureId+";";
	packet += this.AgricultureName+";";
	packet += this.Description;

	return packet;
}


Agriculture.prototype.getAgricultureData = function()
{
	var packet = "";	
	packet += this.AgricultureId+";";
	packet += this.AgricultureName+";";
	packet += this.Description;

	return packet;
}

