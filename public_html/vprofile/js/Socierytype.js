function Socierytype()
{
this.SocieryTypeId="";
this.SocieryTypeName="";
this.Description="";

}

Socierytype.prototype.setSocierytype = function(SocieryTypeId_,SocieryTypeName_,Description_)
{
this.SocieryTypeId=SocieryTypeId_;
this.SocieryTypeName=SocieryTypeName_;
this.Description=Description_;

},

Socierytype.prototype.createSocierytypePacket = function()
{
	var packet = "";	
	packet += this.SocieryTypeId+";";
	packet += this.SocieryTypeName+";";
	packet += this.Description;

	return packet;
}


Socierytype.prototype.getSocierytypeData = function()
{
	var packet = "";	
	packet += this.SocieryTypeId+";";
	packet += this.SocieryTypeName+";";
	packet += this.Description;

	return packet;
}

