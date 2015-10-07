<?php
require_once("BL/BL_manageVillage.php");

function loadVillage($_GET)
{
global $LANG;
 //$VillageId = isset($_GET["VillageId"]) ? $_GET["VillageId"] : (isset($_SESSION["VillageId"])?$_SESSION["VillageId"] :1) ;	
//$_SESSION["VillageId"] = $VillageId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$VillageId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">
<ul class="main_listviewulheader">
<li class="HeaderListRow">
<div class="headerdatarow datarow_village_personid">#</div>
<div class="headerdatarow datarow_village_name">Name</div>
<div class="headerdatarow datarow_village_number">Number</div>
<div class="headerdatarow datarow_village_district">District</div>
</li>
</ul>
<ul id="VillageList" class="main_listviewul">
<?php

$result =BL_manageVillage::getVillageList();

if($result->type ==1)
{
$arr_VillageList = $result->data;
if(count($arr_VillageList)>0)
{
 
 foreach($arr_VillageList as $obj_Village)
 {

 		$html = "<li class=\"ListRow\" id=\"VillageListRow_".$obj_Village->VillageId."\">";
		$html .= "<div class=\"datarow datarow_village_personid\">".$obj_Village->VillageId."</div>";
		$html .= "<div class=\"datarow datarow_village_name\">".$obj_Village->Name."</div>";
		$html .= "<div class=\"datarow datarow_village_number\">".$obj_Village->VillageNumber."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Village->AgaDevision."</div>";
		$html .= "<div class=\"datarow datarow_village_district\">".$obj_Village->District."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Village->Province."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Village->GeogrophyTypeId."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Village->ForestTypeId."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Village->ForestDescription."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Village->TraditionalKnowledge."</div>";
	  	
		$html .= "<div class=\"databtncell\"><a href=\"".$_SERVER['SCRIPT_NAME']."?page=villagedashboard&villageid=".$obj_Village->VillageId."\" class=\"rowbtn\">Select</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_".$obj_Village->VillageId."\" type = \"hidden\" value=\"".$obj_Village->getVillageData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village found... </div>";	
}

?>



</ul>
<div id="popVillageform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Villageform">
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield"><input type="text"  id="Input_VillageId" name="Input_VillageId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NAME'];?></div><div class="fromfield"><input type="text"  id="Input_Name" name="Input_Name" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['VILLAGENUMBER'];?></div><div class="fromfield"><input type="text"  id="Input_VillageNumber" name="Input_VillageNumber" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['AGADIVISION'];?></div><div class="fromfield"><input type="text"  id="Input_AgaDevision" name="Input_AgaDevision" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DISTRICT'];?></div><div class="fromfield"><input type="text"  id="Input_District" name="Input_District" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PROVINCE'];?></div><div class="fromfield"><input type="text"  id="Input_Province" name="Input_Province" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['GEOGRAPHYTYPEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_GeogrophyTypeId" name="Input_GeogrophyTypeId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_GeogrophyTypeId" name="Dummy_Input_GeogrophyTypeId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['FORESTTYPEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_ForestTypeId" name="Input_ForestTypeId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_ForestTypeId" name="Dummy_Input_ForestTypeId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['FORESTDESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_ForestDescription" name="Input_ForestDescription" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TRADITIONALKNOWLEDGE'];?></div><div class="fromfield"><input type="text"  id="Input_TraditionalKnowledge" name="Input_TraditionalKnowledge" value="" class="form_area_textbox"></div></li>
     
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


