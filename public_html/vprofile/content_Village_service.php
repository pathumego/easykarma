<?php
require_once("BL/BL_manageVillage_service.php");

function loadVillage_service($_GET)
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
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_service\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_service</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_service</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_serviceList" class="main_listviewul">
<?php

$result =BL_manageVillage_service::getVillage_serviceList();

if($result->type ==1)
{
$arr_Village_serviceList = $result->data;
if(count($arr_Village_serviceList)>0)
{
 
 foreach($arr_Village_serviceList as $obj_Village_service)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_serviceListRow_".$obj_Village_service->BusinessId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_service->ServiceId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_service->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_service->BusinessId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_service->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_service_".$obj_Village_service->BusinessId."\" type = \"hidden\" value=\"".$obj_Village_service->getVillage_serviceData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_service found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_service found... </div>";	
}

?>



</ul>
<div id="popVillage_serviceform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_SERVICE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_serviceform">
<li><div class="label"><?php echo $LANG['SERVICEID'];?></div><div class="fromfield"><input type="text"  id="Input_ServiceId" name="Input_ServiceId" value="" class="form_area_textbox"></div></li>
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


