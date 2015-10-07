<?php
require_once("BL/BL_manageGroupmissiontype.php");

function loadGroupmissiontype($_GET)
{
global $LANG;
 //$GroupMissionTypeId = isset($_GET["GroupMissionTypeId"]) ? $_GET["GroupMissionTypeId"] : (isset($_SESSION["GroupMissionTypeId"])?$_SESSION["GroupMissionTypeId"] :1) ;	
//$_SESSION["GroupMissionTypeId"] = $GroupMissionTypeId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$GroupMissionTypeId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddGroupmissiontype\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Groupmissiontype</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Groupmissiontype</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="GroupmissiontypeList" class="main_listviewul">
<?php

$result =BL_manageGroupmissiontype::getGroupmissiontypeList();

if($result->type ==1)
{
$arr_GroupmissiontypeList = $result->data;
if(count($arr_GroupmissiontypeList)>0)
{
 
 foreach($arr_GroupmissiontypeList as $obj_Groupmissiontype)
 {

 		$html = "<li class=\"ListRow\" id=\"GroupmissiontypeListRow_".$obj_Groupmissiontype->GroupMissionTypeId."\">";
		$html .= "<div class=\"datarow\">".$obj_Groupmissiontype->GroupMissionTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Groupmissiontype->GroupMissionTypeName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Groupmissiontype->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Groupmissiontype_".$obj_Groupmissiontype->GroupMissionTypeId."\" type = \"hidden\" value=\"".$obj_Groupmissiontype->getGroupmissiontypeData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Groupmissiontype found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Groupmissiontype found... </div>";	
}

?>



</ul>
<div id="popGroupmissiontypeform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_GROUP_MISSION_TYPE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Groupmissiontypeform">
<li><div class="label"><?php echo $LANG['GROUPMISSIONTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_GroupMissionTypeId" name="Input_GroupMissionTypeId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['GROUPMISSIONTYPENAME'];?></div><div class="fromfield"><input type="text"  id="Input_GroupMissionTypeName" name="Input_GroupMissionTypeName" value="" class="form_area_textbox"></div></li>
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


