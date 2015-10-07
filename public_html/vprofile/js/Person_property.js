function Person_property()
{
this.PropertyId="";
this.PropertyName="";
this.PropertyType="";
this.AssessValue="";
this.Description="";

}

Person_property.prototype.setPerson_property = function(PropertyId_,PropertyName_,PropertyType_,AssessValue_,Description_)
{
this.PropertyId=PropertyId_;
this.PropertyName=PropertyName_;
this.PropertyType=PropertyType_;
this.AssessValue=AssessValue_;
this.Description=Description_;

},

Person_property.prototype.createPerson_propertyPacket = function()
{
	var packet = "";	
	packet += this.PropertyId+";";
	packet += this.PropertyName+";";
	packet += this.PropertyType+";";
	packet += this.AssessValue+";";
	packet += this.Description;

	return packet;
}


Person_property.prototype.getPerson_propertyData = function()
{
	var packet = "";	
	packet += this.PropertyId+";";
	packet += this.PropertyName+";";
	packet += this.PropertyType+";";
	packet += this.AssessValue+";";
	packet += this.Description;

	return packet;
}

