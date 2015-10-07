function Trading()
{
this.tradingId="";
this.tradingName="";
this.tradingType="";
this.Description="";

}

Trading.prototype.setTrading = function(tradingId_,tradingName_,tradingType_,Description_)
{
this.tradingId=tradingId_;
this.tradingName=tradingName_;
this.tradingType=tradingType_;
this.Description=Description_;

},

Trading.prototype.createTradingPacket = function()
{
	var packet = "";	
	packet += this.tradingId+";";
	packet += this.tradingName+";";
	packet += this.tradingType+";";
	packet += this.Description;

	return packet;
}


Trading.prototype.getTradingData = function()
{
	var packet = "";	
	packet += this.tradingId+";";
	packet += this.tradingName+";";
	packet += this.tradingType+";";
	packet += this.Description;

	return packet;
}

