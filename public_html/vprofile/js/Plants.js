function Plants()
{
this.PlantId="";
this.Name="";
this.Description="";
this.BioName="";

}

Plants.prototype.setPlants = function(PlantId_,Name_,Description_,BioName_)
{
this.PlantId=PlantId_;
this.Name=Name_;
this.Description=Description_;
this.BioName=BioName_;

},

Plants.prototype.createPlantsPacket = function()
{
	var packet = "";	
	packet += this.PlantId+";";
	packet += this.Name+";";
	packet += this.Description+";";
	packet += this.BioName;

	return packet;
}


Plants.prototype.getPlantsData = function()
{
	var packet = "";	
	packet += this.PlantId+";";
	packet += this.Name+";";
	packet += this.Description+";";
	packet += this.BioName;

	return packet;
}

