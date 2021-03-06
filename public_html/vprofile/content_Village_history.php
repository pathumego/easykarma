﻿<?php
require_once("BL/BL_manageVillage_history.php");

function loadVillage_history($_GET)
{
global $LANG;
$villageId = isset($_GET["villageid"]) ? $_GET["villageid"] 	 : -1 ;	

if($villageId == -1)
{
	echo "VillageId not found";	
}
 //$TblId = isset($_GET["TblId"]) ? $_GET["TblId"] : (isset($_SESSION["TblId"])?$_SESSION["TblId"] :1) ;	
//$_SESSION["TblId"] = $TblId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$TblId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_history\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_history</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_history</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_historyList" class="main_listviewul">
<?php

$result =BL_manageVillage_history::getVillage_historyList();

if($result->type ==1)
{
$arr_Village_historyList = $result->data;
if(count($arr_Village_historyList)>0)
{
 
 foreach($arr_Village_historyList as $obj_Village_history)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_historyListRow_".$obj_Village_history->TblId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_history->TblId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_history->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_history->DescriptionType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_history->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_history_".$obj_Village_history->TblId."\" type = \"hidden\" value=\"".$obj_Village_history->getVillage_historyData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_history found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_history found... </div>";	
}

?>



</ul>
<div id="popVillage_historyform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_HISTORY'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_historyform">
<li><div class="label"><?php echo $LANG['TBLID'];?></div><div class="fromfield"><input type="text"  id="Input_TblId" name="Input_TblId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_VillageId" name="Input_VillageId" value="<?php echo $villageId; ?>" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTIONTYPE'];?></div><div class="fromfield"><input type="text"  id="Input_DescriptionType" name="Input_DescriptionType" value="" class="form_area_textbox"></div></li>
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


