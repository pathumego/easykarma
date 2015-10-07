function Traditionalknowledgecategory()
{
this.CategoryId="";
this.CategoryName="";
this.Description="";

}

Traditionalknowledgecategory.prototype.setTraditionalknowledgecategory = function(CategoryId_,CategoryName_,Description_)
{
this.CategoryId=CategoryId_;
this.CategoryName=CategoryName_;
this.Description=Description_;

},

Traditionalknowledgecategory.prototype.createTraditionalknowledgecategoryPacket = function()
{
	var packet = "";	
	packet += this.CategoryId+";";
	packet += this.CategoryName+";";
	packet += this.Description;

	return packet;
}


Traditionalknowledgecategory.prototype.getTraditionalknowledgecategoryData = function()
{
	var packet = "";	
	packet += this.CategoryId+";";
	packet += this.CategoryName+";";
	packet += this.Description;

	return packet;
}

