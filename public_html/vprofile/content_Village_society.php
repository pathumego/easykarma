<?php
require_once("BL/BL_manageVillage_society.php");

function loadVillage_society($_GET)
{
global $LANG;
$villageId = isset($_GET["villageid"]) ? $_GET["villageid"] 	 : -1 ;	

if($villageId == -1)
{
	echo "VillageId not found";	
}
 //$VillageSocietyId = isset($_GET["VillageSocietyId"]) ? $_GET["VillageSocietyId"] : (isset($_SESSION["VillageSocietyId"])?$_SESSION["VillageSocietyId"] :1) ;	
//$_SESSION["VillageSocietyId"] = $VillageSocietyId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$VillageSocietyId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_society\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_society</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_society</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_societyList" class="main_listviewul">
<?php

$result =BL_manageVillage_society::getVillage_societyList();

if($result->type ==1)
{
$arr_Village_societyList = $result->data;
if(count($arr_Village_societyList)>0)
{
 
 foreach($arr_Village_societyList as $obj_Village_society)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_societyListRow_".$obj_Village_society->VillageSocietyId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_society->SocietyId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_society->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_society->VillageSocietyId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_society_".$obj_Village_society->VillageSocietyId."\" type = \"hidden\" value=\"".$obj_Village_society->getVillage_societyData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_society found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_society found... </div>";	
}

?>



</ul>
<div id="popVillage_societyform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_SOCIETY'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_societyform">
<li><div class="label"><?php echo $LANG['SOCIETYID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_SocietyId" name="Input_SocietyId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_SocietyId" name="Dummy_Input_SocietyId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_VillageId" name="Input_VillageId" value="<?php echo $villageId; ?>" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['VILLAGESOCIETYID'];?></div><div class="fromfield"><input type="text"  id="Input_VillageSocietyId" name="Input_VillageSocietyId" value="" class="form_area_textbox"></div></li>
     
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


