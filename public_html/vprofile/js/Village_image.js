function Village_image()
{
this.PictureId="";
this.VillageId="";
this.PicturePath="";
this.Description="";

}

Village_image.prototype.setVillage_image = function(PictureId_,VillageId_,PicturePath_,Description_)
{
this.PictureId=PictureId_;
this.VillageId=VillageId_;
this.PicturePath=PicturePath_;
this.Description=Description_;

},

Village_image.prototype.createVillage_imagePacket = function()
{
	var packet = "";	
	packet += this.PictureId+";";
	packet += this.VillageId+";";
	packet += this.PicturePath+";";
	packet += this.Description;

	return packet;
}


Village_image.prototype.getVillage_imageData = function()
{
	var packet = "";	
	packet += this.PictureId+";";
	packet += this.VillageId+";";
	packet += this.PicturePath+";";
	packet += this.Description;

	return packet;
}

