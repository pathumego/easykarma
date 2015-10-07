function Businesstype()
{
this.BusinessTypeId="";
this.BusinessTypeName="";
this.Description="";

}

Businesstype.prototype.setBusinesstype = function(BusinessTypeId_,BusinessTypeName_,Description_)
{
this.BusinessTypeId=BusinessTypeId_;
this.BusinessTypeName=BusinessTypeName_;
this.Description=Description_;

},

Businesstype.prototype.createBusinesstypePacket = function()
{
	var packet = "";	
	packet += this.BusinessTypeId+";";
	packet += this.BusinessTypeName+";";
	packet += this.Description;

	return packet;
}


Businesstype.prototype.getBusinesstypeData = function()
{
	var packet = "";	
	packet += this.BusinessTypeId+";";
	packet += this.BusinessTypeName+";";
	packet += this.Description;

	return packet;
}

