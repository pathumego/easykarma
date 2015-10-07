<?php
require_once("BL/BL_manageProduct.php");

function loadProduct($_GET)
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
  		echo "<li class=\"btnright\"><a id=\"btnaddProduct\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Product</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Product</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="ProductList" class="main_listviewul">
<?php

$result =BL_manageProduct::getProductList();

if($result->type ==1)
{
$arr_ProductList = $result->data;
if(count($arr_ProductList)>0)
{
 
 foreach($arr_ProductList as $obj_Product)
 {

 		$html = "<li class=\"ListRow\" id=\"ProductListRow_".$obj_Product->ProductId."\">";
		$html .= "<div class=\"datarow\">".$obj_Product->ProductId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Product->ProductName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Product->ExpireDuration."</div>";
		$html .= "<div class=\"datarow\">".$obj_Product->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Product_".$obj_Product->ProductId."\" type = \"hidden\" value=\"".$obj_Product->getProductData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Product found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Product found... </div>";	
}

?>



</ul>
<div id="popProductform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_PRODUCT'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Productform">
<li><div class="label"><?php echo $LANG['PRODUCTID'];?></div><div class="fromfield"><input type="text"  id="Input_ProductId" name="Input_ProductId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PRODUCTNAME'];?></div><div class="fromfield"><input type="text"  id="Input_ProductName" name="Input_ProductName" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['EXPIREDURATION'];?></div><div class="fromfield"><input type="text"  id="Input_ExpireDuration" name="Input_ExpireDuration" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_Description" name="Input_Description" value="" class="form_area_textbox"></div></li>
     
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


