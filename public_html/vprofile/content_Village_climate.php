<?php
require_once("BL/BL_manageVillage_climate.php");

function loadVillage_climate($_GET)
{
global $LANG;
$villageId = isset($_GET["villageid"]) ? $_GET["villageid"] 	 : -1 ;	

if($villageId == -1)
{
	echo "VillageId not found";	
}

 //$ClimateId = isset($_GET["ClimateId"]) ? $_GET["ClimateId"] : (isset($_SESSION["ClimateId"])?$_SESSION["ClimateId"] :1) ;	
//$_SESSION["ClimateId"] = $ClimateId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$ClimateId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_climate\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_climate</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_climate</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_climateList" class="main_listviewul">
<?php

$result =BL_manageVillage_climate::getVillage_climateList();

if($result->type ==1)
{
$arr_Village_climateList = $result->data;
if(count($arr_Village_climateList)>0)
{
 
 foreach($arr_Village_climateList as $obj_Village_climate)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_climateListRow_".$obj_Village_climate->ClimateId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_climate->ClimateId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_climate->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_climate->ClimateReagion."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_climate->RainFall."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_climate->Temparature."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_climate->Humidity."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_climate_".$obj_Village_climate->ClimateId."\" type = \"hidden\" value=\"".$obj_Village_climate->getVillage_climateData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_climate found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_climate found... </div>";	
}

?>



</ul>
<div id="popVillage_climateform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_CLIMATE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_climateform">
<li><div class="label"><?php echo $LANG['CLIMATEID'];?></div><div class="fromfield"><input type="text"  id="Input_ClimateId" name="Input_ClimateId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_VillageId" name="Input_VillageId" value="<?php echo $villageId; ?>" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['CLIMATEREAGION'];?></div><div class="fromfield"><input type="text"  id="Input_ClimateReagion" name="Input_ClimateReagion" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['RAINFALL'];?></div><div class="fromfield"><input type="text"  id="Input_RainFall" name="Input_RainFall" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TEMPARATURE'];?></div><div class="fromfield"><input type="text"  id="Input_Temparature" name="Input_Temparature" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['HUMIDITY'];?></div><div class="fromfield"><input type="text"  id="Input_Humidity" name="Input_Humidity" value="" class="form_area_textbox"></div></li>
     
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


