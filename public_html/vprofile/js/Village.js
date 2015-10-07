function Village()
{
this.VillageId="";
this.Name="";
this.VillageNumber="";
this.AgaDevision="";
this.District="";
this.Province="";
this.GeogrophyTypeId="";
this.ForestTypeId="";
this.ForestDescription="";
this.TraditionalKnowledge="";

}

Village.prototype.setVillage = function(VillageId_,Name_,VillageNumber_,AgaDevision_,District_,Province_,GeogrophyTypeId_,ForestTypeId_,ForestDescription_,TraditionalKnowledge_)
{
this.VillageId=VillageId_;
this.Name=Name_;
this.VillageNumber=VillageNumber_;
this.AgaDevision=AgaDevision_;
this.District=District_;
this.Province=Province_;
this.GeogrophyTypeId=GeogrophyTypeId_;
this.ForestTypeId=ForestTypeId_;
this.ForestDescription=ForestDescription_;
this.TraditionalKnowledge=TraditionalKnowledge_;

},

Village.prototype.createVillagePacket = function()
{
	var packet = "";	
	packet += this.VillageId+";";
	packet += this.Name+";";
	packet += this.VillageNumber+";";
	packet += this.AgaDevision+";";
	packet += this.District+";";
	packet += this.Province+";";
	packet += this.GeogrophyTypeId+";";
	packet += this.ForestTypeId+";";
	packet += this.ForestDescription+";";
	packet += this.TraditionalKnowledge;

	return packet;
}


Village.prototype.getVillageData = function()
{
	var packet = "";	
	packet += this.VillageId+";";
	packet += this.Name+";";
	packet += this.VillageNumber+";";
	packet += this.AgaDevision+";";
	packet += this.District+";";
	packet += this.Province+";";
	packet += this.GeogrophyTypeId+";";
	packet += this.ForestTypeId+";";
	packet += this.ForestDescription+";";
	packet += this.TraditionalKnowledge;

	return packet;
}

