<?php
class Product
{
		public $ProductId;
		public $ProductName;
		public $ExpireDuration;
		public $Description;


public function setProduct($ProductId_,$ProductName_,$ExpireDuration_,$Description_)
{
		$this->ProductId= $ProductId_;
		$this->ProductName= $ProductName_;
		$this->ExpireDuration= $ExpireDuration_;
		$this->Description= $Description_;

}

public function wsGetProductData()
{
	return	array(	
		'ProductId'=> $this->ProductId,
		'ProductName'=> $this->ProductName,
		'ExpireDuration'=> $this->ExpireDuration,
		'Description'=> $this->Description

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getProductData()
 {
 	$packet = 	
		$this->ProductId.";".
		$this->ProductName.";".
		$this->ExpireDuration.";".
		$this->Description;

	return $packet;
 }
 
 
  public function getProductPacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"ProductData\" id=\"Productdata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getProductData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewProduct()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->ProductId."</td>";
		$html .= "<td>".$this->ProductName."</td>";
		$html .= "<td>".$this->ExpireDuration."</td>";
		$html .= "<td>".$this->Description."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>