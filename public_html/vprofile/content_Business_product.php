<?php
require_once("BL/BL_manageBusiness_product.php");

function loadBusiness_product($_GET)
{
global $LANG;
 //$ProductId = isset($_GET["ProductId"]) ? $_GET["ProductId"] : (isset($_SESSION["ProductId"])?$_SESSION["ProductId"] :1) ;	
//$_SESSION["ProductId"] = $ProductId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$ProductId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddBusiness_product\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Business_product</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Business_product</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Business_productList" class="main_listviewul">
<?php

$result =BL_manageBusiness_product::getBusiness_productList();

if($result->type ==1)
{
$arr_Business_productList = $result->data;
if(count($arr_Business_productList)>0)
{
 
 foreach($arr_Business_productList as $obj_Business_product)
 {

 		$html = "<li class=\"ListRow\" id=\"Business_productListRow_".$obj_Business_product->ProductId."\">";
		$html .= "<div class=\"datarow\">".$obj_Business_product->BusinessId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Business_product->ProductId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Business_product_".$obj_Business_product->ProductId."\" type = \"hidden\" value=\"".$obj_Business_product->getBusiness_productData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Business_product found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Business_product found... </div>";	
}

?>



</ul>
<div id="popBusiness_productform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_BUSINESS_PRODUCT'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Business_productform">
<li><div class="label"><?php echo $LANG['BUSINESSID'];?></div><div class="fromfield"><input type="text"  id="Input_BusinessId" name="Input_BusinessId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PRODUCTID'];?></div><div class="fromfield"><input type="text"  id="Input_ProductId" name="Input_ProductId" value="" class="form_area_textbox"></div></li>
     
<li><div class="label"></div><div class="fromfield"><br/><br/><input id="form_addbtn" class="common_button" type="button" ></div></li>
</ul>
</div>
</div>
</td></tr></table>
<div class="main_content_footer"></div>
</div>
</div>
</div>
<?php 
}

?>


