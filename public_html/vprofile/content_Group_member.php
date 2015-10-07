<?php
require_once("BL/BL_manageGroup_member.php");

function loadGroup_member($_GET)
{
global $LANG;

$groupId = isset($_GET["groupid"] 	) ? $_GET["groupid"] 	 : -1 ;	
if($groupId == -1)
{
	echo "GroupId not found";	

}
 //$MemberId = isset($_GET["MemberId"]) ? $_GET["MemberId"] : (isset($_SESSION["MemberId"])?$_SESSION["MemberId"] :1) ;	
//$_SESSION["MemberId"] = $MemberId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$MemberId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddGroup_member\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Group_member</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Group_member</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Group_memberList" class="main_listviewul">
<?php

$result =BL_manageGroup_member::getGroup_memberList();

if($result->type ==1)
{
$arr_Group_memberList = $result->data;
if(count($arr_Group_memberList)>0)
{
 
 foreach($arr_Group_memberList as $obj_Group_member)
 {

 		$html = "<li class=\"ListRow\" id=\"Group_memberListRow_".$obj_Group_member->MemberId."\">";
		$html .= "<div class=\"datarow\">".$obj_Group_member->GroupId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Group_member->MemberId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Group_member->MemberType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Group_member->MemberDate."</div>";
		$html .= "<div class=\"datarow\">".$obj_Group_member->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Group_member_".$obj_Group_member->MemberId."\" type = \"hidden\" value=\"".$obj_Group_member->getGroup_memberData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Group_member found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Group_member found... </div>";	
}

?>



</ul>
<div id="popGroup_memberform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_GROUP_MEMBER'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Group_memberform">
<li><div class="label"><?php echo $LANG['GROUPID'];?></div><div class="fromfield"><input type="hidden"  id="Input_GroupId" name="Input_GroupId" value="<?php echo $groupId;?>" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['MEMBERID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_MemberId" name="Input_MemberId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_MemberId" name="Dummy_Input_MemberId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['MEMBERTYPE'];?></div><div class="fromfield"><input type="text"  id="Input_MemberType" name="Input_MemberType" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['MEMBERDATE'];?></div><div class="fromfield"><input type="text"  id="Input_MemberDate" name="Input_MemberDate" value="" class="form_area_textbox"></div></li>
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


