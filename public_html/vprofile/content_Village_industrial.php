<?php
require_once("BL/BL_manageVillage_industrial.php");

function loadVillage_industrial($_GET)
{
global $LANG;
$villageId = isset($_GET["villageid"]) ? $_GET["villageid"] 	 : -1 ;	

if($villageId == -1)
{
	echo "VillageId not found";	
}
 //$BusinessId = isset($_GET["BusinessId"]) ? $_GET["BusinessId"] : (isset($_SESSION["BusinessId"])?$_SESSION["BusinessId"] :1) ;	
//$_SESSION["BusinessId"] = $BusinessId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$BusinessId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_industrial\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_industrial</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_industrial</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_industrialList" class="main_listviewul">
<?php

$result =BL_manageVillage_industrial::getVillage_industrialList();

if($result->type ==1)
{
$arr_Village_industrialList = $result->data;
if(count($arr_Village_industrialList)>0)
{
 
 foreach($arr_Village_industrialList as $obj_Village_industrial)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_industrialListRow_".$obj_Village_industrial->BusinessId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_industrial->IndustrialId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_industrial->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_industrial->BusinessId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_industrial->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_industrial_".$obj_Village_industrial->BusinessId."\" type = \"hidden\" value=\"".$obj_Village_industrial->getVillage_industrialData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_industrial found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_industrial found... </div>";	
}

?>



</ul>
<div id="popVillage_industrialform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_INDUSTRIAL'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_industrialform">
<li><div class="label"><?php echo $LANG['INDUSTRIALID'];?></div><div class="fromfield"><input type="text"  id="Input_IndustrialId" name="Input_IndustrialId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_VillageId" name="Input_VillageId" value="<?php echo $villageId; ?>" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['BUSINESSID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_BusinessId" name="Input_BusinessId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_BusinessId" name="Dummy_Input_BusinessId" value="" class="form_area_textbox">
</div></li>
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


