function Foresttype()
{
this.ForestTypeId="";
this.Name="";
this.Description="";

}

Foresttype.prototype.setForesttype = function(ForestTypeId_,Name_,Description_)
{
this.ForestTypeId=ForestTypeId_;
this.Name=Name_;
this.Description=Description_;

},

Foresttype.prototype.createForesttypePacket = function()
{
	var packet = "";	
	packet += this.ForestTypeId+";";
	packet += this.Name+";";
	packet += this.Description;

	return packet;
}


Foresttype.prototype.getForesttypeData = function()
{
	var packet = "";	
	packet += this.ForestTypeId+";";
	packet += this.Name+";";
	packet += this.Description;

	return packet;
}

