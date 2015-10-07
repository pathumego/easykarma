function Person_telephone()
{
this.PhoneId="";
this.PhoneNumber="";
this.Type="";
this.PersonId="";

}

Person_telephone.prototype.setPerson_telephone = function(PhoneId_,PhoneNumber_,Type_,PersonId_)
{
this.PhoneId=PhoneId_;
this.PhoneNumber=PhoneNumber_;
this.Type=Type_;
this.PersonId=PersonId_;

},

Person_telephone.prototype.createPerson_telephonePacket = function()
{
	var packet = "";	
	packet += this.PhoneId+";";
	packet += this.PhoneNumber+";";
	packet += this.Type+";";
	packet += this.PersonId;

	return packet;
}


Person_telephone.prototype.getPerson_telephoneData = function()
{
	var packet = "";	
	packet += this.PhoneId+";";
	packet += this.PhoneNumber+";";
	packet += this.Type+";";
	packet += this.PersonId;

	return packet;
}

