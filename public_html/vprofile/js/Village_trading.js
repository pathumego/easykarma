function Village_trading()
{
this.TradingId="";
this.VillageId="";
this.BusinessId="";
this.Description="";

}

Village_trading.prototype.setVillage_trading = function(TradingId_,VillageId_,BusinessId_,Description_)
{
this.TradingId=TradingId_;
this.VillageId=VillageId_;
this.BusinessId=BusinessId_;
this.Description=Description_;

},

Village_trading.prototype.createVillage_tradingPacket = function()
{
	var packet = "";	
	packet += this.TradingId+";";
	packet += this.VillageId+";";
	packet += this.BusinessId+";";
	packet += this.Description;

	return packet;
}


Village_trading.prototype.getVillage_tradingData = function()
{
	var packet = "";	
	packet += this.TradingId+";";
	packet += this.VillageId+";";
	packet += this.BusinessId+";";
	packet += this.Description;

	return packet;
}

