function Primarygeolayertype()
{
this.PrimaryGeoLayerTypeId="";
this.PrimaryGeoLayerName="";
this.Description="";

}

Primarygeolayertype.prototype.setPrimarygeolayertype = function(PrimaryGeoLayerTypeId_,PrimaryGeoLayerName_,Description_)
{
this.PrimaryGeoLayerTypeId=PrimaryGeoLayerTypeId_;
this.PrimaryGeoLayerName=PrimaryGeoLayerName_;
this.Description=Description_;

},

Primarygeolayertype.prototype.createPrimarygeolayertypePacket = function()
{
	var packet = "";	
	packet += this.PrimaryGeoLayerTypeId+";";
	packet += this.PrimaryGeoLayerName+";";
	packet += this.Description;

	return packet;
}


Primarygeolayertype.prototype.getPrimarygeolayertypeData = function()
{
	var packet = "";	
	packet += this.PrimaryGeoLayerTypeId+";";
	packet += this.PrimaryGeoLayerName+";";
	packet += this.Description;

	return packet;
}

