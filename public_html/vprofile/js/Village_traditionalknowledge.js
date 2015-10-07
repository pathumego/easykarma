function Village_traditionalknowledge()
{
this.TblId="";
this.VillageId="";
this.TraditionalKnowledgeCategoryID="";
this.Discription="";

}

Village_traditionalknowledge.prototype.setVillage_traditionalknowledge = function(TblId_,VillageId_,TraditionalKnowledgeCategoryID_,Discription_)
{
this.TblId=TblId_;
this.VillageId=VillageId_;
this.TraditionalKnowledgeCategoryID=TraditionalKnowledgeCategoryID_;
this.Discription=Discription_;

},

Village_traditionalknowledge.prototype.createVillage_traditionalknowledgePacket = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.VillageId+";";
	packet += this.TraditionalKnowledgeCategoryID+";";
	packet += this.Discription;

	return packet;
}


Village_traditionalknowledge.prototype.getVillage_traditionalknowledgeData = function()
{
	var packet = "";	
	packet += this.TblId+";";
	packet += this.VillageId+";";
	packet += this.TraditionalKnowledgeCategoryID+";";
	packet += this.Discription;

	return packet;
}

