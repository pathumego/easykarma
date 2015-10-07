<?php
class Business_product
{
		public $BusinessId;
		public $ProductId;


public function setBusiness_product($BusinessId_,$ProductId_)
{
		$this->BusinessId= $BusinessId_;
		$this->ProductId= $ProductId_;

}

public function wsGetBusiness_productData()
{
	return	array(	
		'BusinessId'=> $this->BusinessId,
		'ProductId'=> $this->ProductId

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getBusiness_productData()
 {
 	$packet = 	
		$this->BusinessId.";".
		$this->ProductId;

	return $packet;
 }
 
 
  public function getBusiness_productPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"Business_productData\" id=\"Business_productdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getBusiness_productData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewBusiness_product()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->BusinessId."</td>";
		$html .= "<td>".$this->ProductId."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>