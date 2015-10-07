function Person_address()
{
this.AddressId="";
this.Address="";
this.AddressType="";
this.VillageId="";
this.PersonId="";

}

Person_address.prototype.setPerson_address = function(AddressId_,Address_,AddressType_,VillageId_,PersonId_)
{
this.AddressId=AddressId_;
this.Address=Address_;
this.AddressType=AddressType_;
this.VillageId=VillageId_;
this.PersonId=PersonId_;

},

Person_address.prototype.createPerson_addressPacket = function()
{
	var packet = "";	
	packet += this.AddressId+";";
	packet += this.Address+";";
	packet += this.AddressType+";";
	packet += this.VillageId+";";
	packet += this.PersonId;

	return packet;
}


Person_address.prototype.getPerson_addressData = function()
{
	var packet = "";	
	packet += this.AddressId+";";
	packet += this.Address+";";
	packet += this.AddressType+";";
	packet += this.VillageId+";";
	packet += this.PersonId;

	return packet;
}

