function Business_product()
{
this.BusinessId="";
this.ProductId="";

}

Business_product.prototype.setBusiness_product = function(BusinessId_,ProductId_)
{
this.BusinessId=BusinessId_;
this.ProductId=ProductId_;

},

Business_product.prototype.createBusiness_productPacket = function()
{
	var packet = "";	
	packet += this.BusinessId+";";
	packet += this.ProductId;

	return packet;
}


Business_product.prototype.getBusiness_productData = function()
{
	var packet = "";	
	packet += this.BusinessId+";";
	packet += this.ProductId;

	return packet;
}

