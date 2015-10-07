function Soiltype()
{
this.TblId="";
this.SoilTypeId="";
this.SoilTypeName="";
this.Description="";

}

Soiltype.prototype.setSoiltype = function(TblId_,SoilTypeId_,SoilTypeName_,Description_)
{
this.TblId=TblId_;
this.SoilTypeId=SoilTypeId_;
this.SoilTypeName=SoilTypeName_;
this.Description=Description_;

},

Soiltype.prototype.createSoiltypePacket = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.SoilTypeId+";";
	packet += this.SoilTypeName+";";
	packet += this.Description;

	return packet;
}


Soiltype.prototype.getSoiltypeData = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.SoilTypeId+";";
	packet += this.SoilTypeName+";";
	packet += this.Description;

	return packet;
}

