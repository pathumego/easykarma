<?php
require_once("BL/BL_manageService.php");

function loadService($_GET)
{
global $LANG;
 //$ServiceId = isset($_GET["ServiceId"]) ? $_GET["ServiceId"] : (isset($_SESSION["ServiceId"])?$_SESSION["ServiceId"] :1) ;	
//$_SESSION["ServiceId"] = $ServiceId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$ServiceId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddService\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Service</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Service</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="ServiceList" class="main_listviewul">
<?php

$result =BL_manageService::getServiceList();

if($result->type ==1)
{
$arr_ServiceList = $result->data;
if(count($arr_ServiceList)>0)
{
 
 foreach($arr_ServiceList as $obj_Service)
 {

 		$html = "<li class=\"ListRow\" id=\"ServiceListRow_".$obj_Service->ServiceId."\">";
		$html .= "<div class=\"datarow\">".$obj_Service->ServiceId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Service->ServiceName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Service->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Service_".$obj_Service->ServiceId."\" type = \"hidden\" value=\"".$obj_Service->getServiceData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Service found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Service found... </div>";	
}

?>



</ul>
<div id="popServiceform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_SERVICE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Serviceform">
<li><div class="label"><?php echo $LANG['SERVICEID'];?></div><div class="fromfield"><input type="text"  id="Input_ServiceId" name="Input_ServiceId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SERVICENAME'];?></div><div class="fromfield"><input type="text"  id="Input_ServiceName" name="Input_ServiceName" value="" class="form_area_textbox"></div></li>
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


