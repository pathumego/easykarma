function Society()
{
this.SocietyId="";
this.Name="";
this.Description="";
this.Mission="";
this.SocietyTypeId="";
this.SocietyAddress="";

}

Society.prototype.setSociety = function(SocietyId_,Name_,Description_,Mission_,SocietyTypeId_,SocietyAddress_)
{
this.SocietyId=SocietyId_;
this.Name=Name_;
this.Description=Description_;
this.Mission=Mission_;
this.SocietyTypeId=SocietyTypeId_;
this.SocietyAddress=SocietyAddress_;

},

Society.prototype.createSocietyPacket = function()
{
	var packet = "";	
	packet += this.SocietyId+";";
	packet += this.Name+";";
	packet += this.Description+";";
	packet += this.Mission+";";
	packet += this.SocietyTypeId+";";
	packet += this.SocietyAddress;

	return packet;
}


Society.prototype.getSocietyData = function()
{
	var packet = "";	
	packet += this.SocietyId+";";
	packet += this.Name+";";
	packet += this.Description+";";
	packet += this.Mission+";";
	packet += this.SocietyTypeId+";";
	packet += this.SocietyAddress;

	return packet;
}

