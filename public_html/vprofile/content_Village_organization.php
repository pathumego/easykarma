﻿<?php
require_once("BL/BL_manageVillage_organization.php");

function loadVillage_organization($_GET)
{
global $LANG;
$villageId = isset($_GET["villageid"]) ? $_GET["villageid"] 	 : -1 ;	

if($villageId == -1)
{
	echo "VillageId not found";	
}
 //$VillageId = isset($_GET["VillageId"]) ? $_GET["VillageId"] : (isset($_SESSION["VillageId"])?$_SESSION["VillageId"] :1) ;	
//$_SESSION["VillageId"] = $VillageId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$VillageId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_organization\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_organization</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_organization</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_organizationList" class="main_listviewul">
<?php

$result =BL_manageVillage_organization::getVillage_organizationList();

if($result->type ==1)
{
$arr_Village_organizationList = $result->data;
if(count($arr_Village_organizationList)>0)
{
 
 foreach($arr_Village_organizationList as $obj_Village_organization)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_organizationListRow_".$obj_Village_organization->VillageId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_organization->OrganizationId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_organization->VillageId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_organization_".$obj_Village_organization->VillageId."\" type = \"hidden\" value=\"".$obj_Village_organization->getVillage_organizationData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_organization found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_organization found... </div>";	
}

?>



</ul>
<div id="popVillage_organizationform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_ORGANIZATION'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_organizationform">
<li><div class="label"><?php echo $LANG['ORGANIZATIONID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_OrganizationId" name="Input_OrganizationId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_OrganizationId" name="Dummy_Input_OrganizationId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_VillageId" name="Input_VillageId" value="<?php echo $villageId; ?>" class="form_area_textbox">
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


