<?php
require_once("BL/BL_manageLocation.php");

function loadLocation($_GET)
{
global $LANG;
 //$LocationId = isset($_GET["LocationId"]) ? $_GET["LocationId"] : (isset($_SESSION["LocationId"])?$_SESSION["LocationId"] :1) ;	
//$_SESSION["LocationId"] = $LocationId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$LocationId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddLocation\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Location</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Location</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="LocationList" class="main_listviewul">
<?php

$result =BL_manageLocation::getLocationList();

if($result->type ==1)
{
$arr_LocationList = $result->data;
if(count($arr_LocationList)>0)
{
 
 foreach($arr_LocationList as $obj_Location)
 {

 		$html = "<li class=\"ListRow\" id=\"LocationListRow_".$obj_Location->LocationId."\">";
		$html .= "<div class=\"datarow\">".$obj_Location->LocationId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Location->Name."</div>";
		$html .= "<div class=\"datarow\">".$obj_Location->LocationType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Location->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Location_".$obj_Location->LocationId."\" type = \"hidden\" value=\"".$obj_Location->getLocationData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Location found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Location found... </div>";	
}

?>



</ul>
<div id="popLocationform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_LOCATION'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Locationform">
<li><div class="label"><?php echo $LANG['LOCATIONID'];?></div><div class="fromfield"><input type="text"  id="Input_LocationId" name="Input_LocationId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NAME'];?></div><div class="fromfield"><input type="text"  id="Input_Name" name="Input_Name" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['LOCATIONTYPE'];?></div><div class="fromfield"><input type="text"  id="Input_LocationType" name="Input_LocationType" value="" class="form_area_textbox"></div></li>
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


