<?php
require_once("BL/BL_manageGroup.php");

function loadGroup($_GET)
{
global $LANG;
 //$GroupId = isset($_GET["GroupId"]) ? $_GET["GroupId"] : (isset($_SESSION["GroupId"])?$_SESSION["GroupId"] :1) ;	
//$_SESSION["GroupId"] = $GroupId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$GroupId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddGroup\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Group</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Group</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="GroupList" class="main_listviewul">
<?php

$result =BL_manageGroup::getGroupList();

if($result->type ==1)
{
$arr_GroupList = $result->data;
if(count($arr_GroupList)>0)
{
 
 foreach($arr_GroupList as $obj_Group)
 {

 		$html = "<li class=\"ListRow\" id=\"GroupListRow_".$obj_Group->GroupId."\">";
		$html .= "<div class=\"datarow\">".$obj_Group->GroupId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Group->GroupName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Group->GroupPrimaryType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Group->GroupMissionTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Group->GroupAddress."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Group_member&groupid=".$obj_Group->GroupId."\" class=\"rowbtn\">Members</a></div>";
		$html .= "<input id=\"Group_".$obj_Group->GroupId."\" type = \"hidden\" value=\"".$obj_Group->getGroupData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Group found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Group found... </div>";	
}

?>



</ul>
<div id="popGroupform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_GROUP'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Groupform">
<li><div class="label"><?php echo $LANG['GROUPID'];?></div><div class="fromfield"><input type="text"  id="Input_GroupId" name="Input_GroupId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['GROUPNAME'];?></div><div class="fromfield"><input type="text"  id="Input_GroupName" name="Input_GroupName" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['GROUPTYPENAME'];?></div><div class="fromfield"><input type="text"  id="Input_GroupPrimaryType" name="Input_GroupPrimaryType" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['GROUPMISSIONTYPEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_GroupMissionTypeId" name="Input_GroupMissionTypeId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_GroupMissionTypeId" name="Dummy_Input_GroupMissionTypeId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['GROUPADRESS'];?></div><div class="fromfield"><input type="text"  id="Input_GroupAddress" name="Input_GroupAddress" value="" class="form_area_textbox"></div></li>
     
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


