<?php
require_once("BL/BL_manageVillage_geologicalvariation.php");

function loadVillage_geologicalvariation($_GET)
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
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_geologicalvariation\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_geologicalvariation</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_geologicalvariation</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_geologicalvariationList" class="main_listviewul">
<?php

$result =BL_manageVillage_geologicalvariation::getVillage_geologicalvariationList();

if($result->type ==1)
{
$arr_Village_geologicalvariationList = $result->data;
if(count($arr_Village_geologicalvariationList)>0)
{
 
 foreach($arr_Village_geologicalvariationList as $obj_Village_geologicalvariation)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_geologicalvariationListRow_".$obj_Village_geologicalvariation->TblId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_geologicalvariation->TblId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_geologicalvariation->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_geologicalvariation->Variation."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_geologicalvariation->Description."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_geologicalvariation->PrimaryGeoLayerTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_geologicalvariation->SoilTypeId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_geologicalvariation_".$obj_Village_geologicalvariation->TblId."\" type = \"hidden\" value=\"".$obj_Village_geologicalvariation->getVillage_geologicalvariationData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_geologicalvariation found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_geologicalvariation found... </div>";	
}

?>



</ul>
<div id="popVillage_geologicalvariationform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_GEOLOGICAL_VARIATIONS'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_geologicalvariationform">
<li><div class="label"><?php echo $LANG['TBLID'];?></div><div class="fromfield"><input type="text"  id="Input_TblId" name="Input_TblId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_VillageId" name="Input_VillageId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['VARIATION'];?></div><div class="fromfield"><input type="text"  id="Input_Variation" name="Input_Variation" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_Description" name="Input_Description" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PRIMARYGEOLAYERTYPEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_PrimaryGeoLayerTypeId" name="Input_PrimaryGeoLayerTypeId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_PrimaryGeoLayerTypeId" name="Dummy_Input_PrimaryGeoLayerTypeId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['SOILTYPEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_SoilTypeId" name="Input_SoilTypeId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_SoilTypeId" name="Dummy_Input_SoilTypeId" value="" class="form_area_textbox">
</div></li>
     
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


