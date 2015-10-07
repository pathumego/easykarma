function Organization()
{
this.OrganizationId="";
this.Name="";
this.Description="";
this.Address="";
this.telephone="";
this.fax="";
this.website="";
this.email="";
this.OrganizationTypeId="";
this.OrganizationSubTypeId="";

}

Organization.prototype.setOrganization = function(OrganizationId_,Name_,Description_,Address_,telephone_,fax_,website_,email_,OrganizationTypeId_,OrganizationSubTypeId_)
{
this.OrganizationId=OrganizationId_;
this.Name=Name_;
this.Description=Description_;
this.Address=Address_;
this.telephone=telephone_;
this.fax=fax_;
this.website=website_;
this.email=email_;
this.OrganizationTypeId=OrganizationTypeId_;
this.OrganizationSubTypeId=OrganizationSubTypeId_;

},

Organization.prototype.createOrganizationPacket = function()
{
	var packet = "";	
	packet += this.OrganizationId+";";
	packet += this.Name+";";
	packet += this.Description+";";
	packet += this.Address+";";
	packet += this.telephone+";";
	packet += this.fax+";";
	packet += this.website+";";
	packet += this.email+";";
	packet += this.OrganizationTypeId+";";
	packet += this.OrganizationSubTypeId;

	return packet;
}


Organization.prototype.getOrganizationData = function()
{
	var packet = "";	
	packet += this.OrganizationId+";";
	packet += this.Name+";";
	packet += this.Description+";";
	packet += this.Address+";";
	packet += this.telephone+";";
	packet += this.fax+";";
	packet += this.website+";";
	packet += this.email+";";
	packet += this.OrganizationTypeId+";";
	packet += this.OrganizationSubTypeId;

	return packet;
}

