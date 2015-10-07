function Business()
{
this.BusinessId="";
this.Name="";
this.Description="";
this.Address="";
this.telephone="";
this.fax="";
this.website="";
this.email="";
this.BusinessTypeId="";
this.BusinessSubTypeId="";

}

Business.prototype.setBusiness = function(BusinessId_,Name_,Description_,Address_,telephone_,fax_,website_,email_,BusinessTypeId_,BusinessSubTypeId_)
{
this.BusinessId=BusinessId_;
this.Name=Name_;
this.Description=Description_;
this.Address=Address_;
this.telephone=telephone_;
this.fax=fax_;
this.website=website_;
this.email=email_;
this.BusinessTypeId=BusinessTypeId_;
this.BusinessSubTypeId=BusinessSubTypeId_;

},

Business.prototype.createBusinessPacket = function()
{
	var packet = "";	
	packet += this.BusinessId+";";
	packet += this.Name+";";
	packet += this.Description+";";
	packet += this.Address+";";
	packet += this.telephone+";";
	packet += this.fax+";";
	packet += this.website+";";
	packet += this.email+";";
	packet += this.BusinessTypeId+";";
	packet += this.BusinessSubTypeId;

	return packet;
}


Business.prototype.getBusinessData = function()
{
	var packet = "";	
	packet += this.BusinessId+";";
	packet += this.Name+";";
	packet += this.Description+";";
	packet += this.Address+";";
	packet += this.telephone+";";
	packet += this.fax+";";
	packet += this.website+";";
	packet += this.email+";";
	packet += this.BusinessTypeId+";";
	packet += this.BusinessSubTypeId;

	return packet;
}

