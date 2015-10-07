function Village_history()
{
this.TblId="";
this.VillageId="";
this.DescriptionType="";
this.Description="";

}

Village_history.prototype.setVillage_history = function(TblId_,VillageId_,DescriptionType_,Description_)
{
this.TblId=TblId_;
this.VillageId=VillageId_;
this.DescriptionType=DescriptionType_;
this.Description=Description_;

},

Village_history.prototype.createVillage_historyPacket = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.VillageId+";";
	packet += this.DescriptionType+";";
	packet += this.Description;

	return packet;
}


Village_history.prototype.getVillage_historyData = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.VillageId+";";
	packet += this.DescriptionType+";";
	packet += this.Description;

	return packet;
}

