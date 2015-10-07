function Geographytype()
{
this.GeogrophyTypeId="";
this.Name="";
this.Description="";

}

Geographytype.prototype.setGeographytype = function(GeogrophyTypeId_,Name_,Description_)
{
this.GeogrophyTypeId=GeogrophyTypeId_;
this.Name=Name_;
this.Description=Description_;

},

Geographytype.prototype.createGeographytypePacket = function()
{
	var packet = "";	
	packet += this.GeogrophyTypeId+";";
	packet += this.Name+";";
	packet += this.Description;

	return packet;
}


Geographytype.prototype.getGeographytypeData = function()
{
	var packet = "";	
	packet += this.GeogrophyTypeId+";";
	packet += this.Name+";";
	packet += this.Description;

	return packet;
}

