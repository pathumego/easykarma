<?php
require_once("BL/BL_manageAgriculture.php");

function loadAgriculture($_GET)
{
 global $LANG;
 //$AgricultureId = isset($_GET["AgricultureId"]) ? $_GET["AgricultureId"] : (isset($_SESSION["AgricultureId"])?$_SESSION["AgricultureId"] :1) ;	
//$_SESSION["AgricultureId"] = $AgricultureId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$AgricultureId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddAgriculture\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Agriculture</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Agriculture</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="AgricultureList" class="main_listviewul">
<?php

$result =BL_manageAgriculture::getAgricultureList();

if($result->type ==1)
{
$arr_AgricultureList = $result->data;
if(count($arr_AgricultureList)>0)
{
 
 foreach($arr_AgricultureList as $obj_Agriculture)
 {

 		$html = "<li class=\"ListRow\" id=\"AgricultureListRow_".$obj_Agriculture->AgricultureId."\">";
		$html .= "<div class=\"datarow\">".$obj_Agriculture->AgricultureId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Agriculture->AgricultureName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Agriculture->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Agriculture_".$obj_Agriculture->AgricultureId."\" type = \"hidden\" value=\"".$obj_Agriculture->getAgricultureData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Agriculture found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Agriculture found... </div>";	
}

?>



</ul>
<div id="popAgricultureform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_AGRICULTURE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Agricultureform">
<li><div class="label"><?php echo $LANG['AGRICULTUREID'];?></div><div class="fromfield"><input type="text"  id="Input_AgricultureId" name="Input_AgricultureId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['AGRICULTURENAME'];?></div><div class="fromfield"><input type="text"  id="Input_AgricultureName" name="Input_AgricultureName" value="" class="form_area_textbox"></div></li>
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