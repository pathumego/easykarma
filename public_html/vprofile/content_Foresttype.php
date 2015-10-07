<?php
require_once("BL/BL_manageForesttype.php");

function loadForesttype($_GET)
{
global $LANG;
 //$ForestTypeId = isset($_GET["ForestTypeId"]) ? $_GET["ForestTypeId"] : (isset($_SESSION["ForestTypeId"])?$_SESSION["ForestTypeId"] :1) ;	
//$_SESSION["ForestTypeId"] = $ForestTypeId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$ForestTypeId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddForesttype\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Foresttype</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Foresttype</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="ForesttypeList" class="main_listviewul">
<?php

$result =BL_manageForesttype::getForesttypeList();

if($result->type ==1)
{
$arr_ForesttypeList = $result->data;
if(count($arr_ForesttypeList)>0)
{
 
 foreach($arr_ForesttypeList as $obj_Foresttype)
 {

 		$html = "<li class=\"ListRow\" id=\"ForesttypeListRow_".$obj_Foresttype->ForestTypeId."\">";
		$html .= "<div class=\"datarow\">".$obj_Foresttype->ForestTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Foresttype->Name."</div>";
		$html .= "<div class=\"datarow\">".$obj_Foresttype->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Foresttype_".$obj_Foresttype->ForestTypeId."\" type = \"hidden\" value=\"".$obj_Foresttype->getForesttypeData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Foresttype found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Foresttype found... </div>";	
}

?>



</ul>
<div id="popForesttypeform" class="formPopup">
<div class="subheader"><?php echo $LANG['SUBHEADER_FOREST_TYPE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Foresttypeform">
<li><div class="label"><?php echo $LANG['FORESTTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_ForestTypeId" name="Input_ForestTypeId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NAME'];?></div><div class="fromfield"><input type="text"  id="Input_Name" name="Input_Name" value="" class="form_area_textbox"></div></li>
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


