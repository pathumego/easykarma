<?php
class Village_image
{
		public $PictureId;
		public $VillageId;
		public $PicturePath;
		public $Description;


public function setVillage_image($PictureId_,$VillageId_,$PicturePath_,$Description_)
{
		$this->PictureId= $PictureId_;
		$this->VillageId= $VillageId_;
		$this->PicturePath= $PicturePath_;
		$this->Description= $Description_;

}

public function wsGetVillage_imageData()
{
	return	array(	
		'PictureId'=> $this->PictureId,
		'VillageId'=> $this->VillageId,
		'PicturePath'=> $this->PicturePath,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getVillage_imageData()
 {
 	$packet = 	
		$this->PictureId.";".
		$this->VillageId.";".
		$this->PicturePath.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getVillage_imagePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Village_imageData\" id=\"Village_imagedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getVillage_imageData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewVillage_image()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->PictureId."</td>";
		$html .= "<td>".$this->VillageId."</td>";
		$html .= "<td>".$this->PicturePath."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>