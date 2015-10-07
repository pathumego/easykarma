function Village_organization()
{
this.OrganizationId="";
this.VillageId="";

}

Village_organization.prototype.setVillage_organization = function(OrganizationId_,VillageId_)
{
this.OrganizationId=OrganizationId_;
this.VillageId=VillageId_;

},

Village_organization.prototype.createVillage_organizationPacket = function()
{
	var packet = "";	
	packet += this.OrganizationId+";";
	packet += this.VillageId;

	return packet;
}


Village_organization.prototype.getVillage_organizationData = function()
{
	var packet = "";	
	packet += this.OrganizationId+";";
	packet += this.VillageId;

	return packet;
}

