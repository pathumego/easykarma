function Village_geologicalvariation()
{
this.TblId="";
this.VillageId="";
this.Variation="";
this.Description="";
this.PrimaryGeoLayerTypeId="";
this.SoilTypeId="";

}

Village_geologicalvariation.prototype.setVillage_geologicalvariation = function(TblId_,VillageId_,Variation_,Description_,PrimaryGeoLayerTypeId_,SoilTypeId_)
{
this.TblId=TblId_;
this.VillageId=VillageId_;
this.Variation=Variation_;
this.Description=Description_;
this.PrimaryGeoLayerTypeId=PrimaryGeoLayerTypeId_;
this.SoilTypeId=SoilTypeId_;

},

Village_geologicalvariation.prototype.createVillage_geologicalvariationPacket = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.VillageId+";";
	packet += this.Variation+";";
	packet += this.Description+";";
	packet += this.PrimaryGeoLayerTypeId+";";
	packet += this.SoilTypeId;

	return packet;
}


Village_geologicalvariation.prototype.getVillage_geologicalvariationData = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.VillageId+";";
	packet += this.Variation+";";
	packet += this.Description+";";
	packet += this.PrimaryGeoLayerTypeId+";";
	packet += this.SoilTypeId;

	return packet;
}

