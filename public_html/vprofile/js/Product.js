function Product()
{
this.ProductId="";
this.ProductName="";
this.ExpireDuration="";
this.Description="";

}

Product.prototype.setProduct = function(ProductId_,ProductName_,ExpireDuration_,Description_)
{
this.ProductId=ProductId_;
this.ProductName=ProductName_;
this.ExpireDuration=ExpireDuration_;
this.Description=Description_;

},

Product.prototype.createProductPacket = function()
{
	var packet = "";	
	packet += this.ProductId+";";
	packet += this.ProductName+";";
	packet += this.ExpireDuration+";";
	packet += this.Description;

	return packet;
}


Product.prototype.getProductData = function()
{
	var packet = "";	
	packet += this.ProductId+";";
	packet += this.ProductName+";";
	packet += this.ExpireDuration+";";
	packet += this.Description;

	return packet;
}

