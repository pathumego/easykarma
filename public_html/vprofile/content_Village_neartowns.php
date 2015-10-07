<?php
require_once("BL/BL_manageVillage_neartowns.php");

function loadVillage_neartowns($_GET)
{
global $LANG;
$villageId = isset($_GET["villageid"]) ? $_GET["villageid"] 	 : -1 ;	

if($villageId == -1)
{
	echo "VillageId not found";	
}
 //$TownId = isset($_GET["TownId"]) ? $_GET["TownId"] : (isset($_SESSION["TownId"])?$_SESSION["TownId"] :1) ;	
//$_SESSION["TownId"] = $TownId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$TownId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_neartowns\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_neartowns</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_neartowns</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_neartownsList" class="main_listviewul">
<?php

$result =BL_manageVillage_neartowns::getVillage_neartownsList();

if($result->type ==1)
{
$arr_Village_neartownsList = $result->data;
if(count($arr_Village_neartownsList)>0)
{
 
 foreach($arr_Village_neartownsList as $obj_Village_neartowns)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_neartownsListRow_".$obj_Village_neartowns->TownId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_neartowns->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_neartowns->TownId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_neartowns->Distance."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_neartowns->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_neartowns_".$obj_Village_neartowns->TownId."\" type = \"hidden\" value=\"".$obj_Village_neartowns->getVillage_neartownsData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_neartowns found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_neartowns found... </div>";	
}

?>



</ul>
<div id="popVillage_neartownsform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_NEAR_TOWN'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_neartownsform">
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield"><input type="text"  id="Input_VillageId" name="Input_VillageId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TOWNID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_TownId" name="Input_TownId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['DISTANCE'];?></div><div class="fromfield"><input type="text"  id="Input_Distance" name="Input_Distance" value="" class="form_area_textbox"></div></li>
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


