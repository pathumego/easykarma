function Organization_subtype()
{
this.OrganizationSubTypeId="";
this.OrganizationSubTypeName="";
this.Description="";

}

Organization_subtype.prototype.setOrganization_subtype = function(OrganizationSubTypeId_,OrganizationSubTypeName_,Description_)
{
this.OrganizationSubTypeId=OrganizationSubTypeId_;
this.OrganizationSubTypeName=OrganizationSubTypeName_;
this.Description=Description_;

},

Organization_subtype.prototype.createOrganization_subtypePacket = function()
{
	var packet = "";	
	packet += this.OrganizationSubTypeId+";";
	packet += this.OrganizationSubTypeName+";";
	packet += this.Description;

	return packet;
}


Organization_subtype.prototype.getOrganization_subtypeData = function()
{
	var packet = "";	
	packet += this.OrganizationSubTypeId+";";
	packet += this.OrganizationSubTypeName+";";
	packet += this.Description;

	return packet;
}

