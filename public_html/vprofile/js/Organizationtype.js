function Organizationtype()
{
this.OrganizationTypeId="";
this.OrganizationTypeName="";
this.Description="";

}

Organizationtype.prototype.setOrganizationtype = function(OrganizationTypeId_,OrganizationTypeName_,Description_)
{
this.OrganizationTypeId=OrganizationTypeId_;
this.OrganizationTypeName=OrganizationTypeName_;
this.Description=Description_;

},

Organizationtype.prototype.createOrganizationtypePacket = function()
{
	var packet = "";	
	packet += this.OrganizationTypeId+";";
	packet += this.OrganizationTypeName+";";
	packet += this.Description;

	return packet;
}


Organizationtype.prototype.getOrganizationtypeData = function()
{
	var packet = "";	
	packet += this.OrganizationTypeId+";";
	packet += this.OrganizationTypeName+";";
	packet += this.Description;

	return packet;
}

