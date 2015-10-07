<?php
require_once("BL/BL_manageTraditionalknowledgecategory.php");

function loadTraditionalknowledgecategory($_GET)
{
global $LANG;
 //$CategoryId = isset($_GET["CategoryId"]) ? $_GET["CategoryId"] : (isset($_SESSION["CategoryId"])?$_SESSION["CategoryId"] :1) ;	
//$_SESSION["CategoryId"] = $CategoryId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$CategoryId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddTraditionalknowledgecategory\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Traditionalknowledgecategory</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Traditionalknowledgecategory</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="TraditionalknowledgecategoryList" class="main_listviewul">
<?php

$result =BL_manageTraditionalknowledgecategory::getTraditionalknowledgecategoryList();

if($result->type ==1)
{
$arr_TraditionalknowledgecategoryList = $result->data;
if(count($arr_TraditionalknowledgecategoryList)>0)
{
 
 foreach($arr_TraditionalknowledgecategoryList as $obj_Traditionalknowledgecategory)
 {

 		$html = "<li class=\"ListRow\" id=\"TraditionalknowledgecategoryListRow_".$obj_Traditionalknowledgecategory->CategoryId."\">";
		$html .= "<div class=\"datarow\">".$obj_Traditionalknowledgecategory->CategoryId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Traditionalknowledgecategory->CategoryName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Traditionalknowledgecategory->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Traditionalknowledgecategory_".$obj_Traditionalknowledgecategory->CategoryId."\" type = \"hidden\" value=\"".$obj_Traditionalknowledgecategory->getTraditionalknowledgecategoryData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Traditionalknowledgecategory found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Traditionalknowledgecategory found... </div>";	
}

?>



</ul>
<div id="popTraditionalknowledgecategoryform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_TRADITIONAL_KNOWLADGE_CATEGORY'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Traditionalknowledgecategoryform">
<li><div class="label"><?php echo $LANG['CATEGORYID'];?></div><div class="fromfield"><input type="text"  id="Input_CategoryId" name="Input_CategoryId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['CATEGORYNAME'];?></div><div class="fromfield"><input type="text"  id="Input_CategoryName" name="Input_CategoryName" value="" class="form_area_textbox"></div></li>
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


