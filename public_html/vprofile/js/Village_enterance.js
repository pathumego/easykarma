function Village_enterance()
{
this.TblId="";
this.VillageId="";
this.Direction="";
this.Description="";

}

Village_enterance.prototype.setVillage_enterance = function(TblId_,VillageId_,Direction_,Description_)
{
this.TblId=TblId_;
this.VillageId=VillageId_;
this.Direction=Direction_;
this.Description=Description_;

},

Village_enterance.prototype.createVillage_enterancePacket = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.VillageId+";";
	packet += this.Direction+";";
	packet += this.Description;

	return packet;
}


Village_enterance.prototype.getVillage_enteranceData = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.VillageId+";";
	packet += this.Direction+";";
	packet += this.Description;

	return packet;
}

