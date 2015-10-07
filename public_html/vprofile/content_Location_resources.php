<?php
require_once("BL/BL_manageLocation_resources.php");

function loadLocation_resources($_GET)
{
global $LANG;
 //$ResourceId = isset($_GET["ResourceId"]) ? $_GET["ResourceId"] : (isset($_SESSION["ResourceId"])?$_SESSION["ResourceId"] :1) ;	
//$_SESSION["ResourceId"] = $ResourceId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$ResourceId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddLocation_resources\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Location_resources</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Location_resources</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Location_resourcesList" class="main_listviewul">
<?php

$result =BL_manageLocation_resources::getLocation_resourcesList();

if($result->type ==1)
{
$arr_Location_resourcesList = $result->data;
if(count($arr_Location_resourcesList)>0)
{
 
 foreach($arr_Location_resourcesList as $obj_Location_resources)
 {

 		$html = "<li class=\"ListRow\" id=\"Location_resourcesListRow_".$obj_Location_resources->ResourceId."\">";
		$html .= "<div class=\"datarow\">".$obj_Location_resources->ResourceId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Location_resources->LocationId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Location_resources->ResourceType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Location_resources->ResourcePath."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Location_resources_".$obj_Location_resources->ResourceId."\" type = \"hidden\" value=\"".$obj_Location_resources->getLocation_resourcesData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Location_resources found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Location_resources found... </div>";	
}

?>



</ul>
<div id="popLocation_resourcesform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_LOCATION_RESOURCES'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Location_resourcesform">
<li><div class="label"><?php echo $LANG['RESOURCEID'];?></div><div class="fromfield"><input type="text"  id="Input_ResourceId" name="Input_ResourceId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['LOCATIONID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_LocationId" name="Input_LocationId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_LocationId" name="Dummy_Input_LocationId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['RESOURCETYPE'];?></div><div class="fromfield"><input type="text"  id="Input_ResourceType" name="Input_ResourceType" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['RESOURCEPATH'];?></div><div class="fromfield"><input type="text"  id="Input_ResourcePath" name="Input_ResourcePath" value="" class="form_area_textbox"></div></li>
     
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


