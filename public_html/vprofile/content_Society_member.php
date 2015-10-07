<?php
require_once("BL/BL_manageSociety_member.php");

function loadSociety_member($_GET)
{
global $LANG;
 //$MemberId = isset($_GET["MemberId"]) ? $_GET["MemberId"] : (isset($_SESSION["MemberId"])?$_SESSION["MemberId"] :1) ;	
//$_SESSION["MemberId"] = $MemberId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$MemberId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddSociety_member\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Society_member</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Society_member</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Society_memberList" class="main_listviewul">
<?php

$result =BL_manageSociety_member::getSociety_memberList();

if($result->type ==1)
{
$arr_Society_memberList = $result->data;
if(count($arr_Society_memberList)>0)
{
 
 foreach($arr_Society_memberList as $obj_Society_member)
 {

 		$html = "<li class=\"ListRow\" id=\"Society_memberListRow_".$obj_Society_member->MemberId."\">";
		$html .= "<div class=\"datarow\">".$obj_Society_member->VillageSocietyId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Society_member->MemberId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Society_member->MemberType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Society_member->MemberDate."</div>";
		$html .= "<div class=\"datarow\">".$obj_Society_member->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Society_member_".$obj_Society_member->MemberId."\" type = \"hidden\" value=\"".$obj_Society_member->getSociety_memberData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Society_member found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Society_member found... </div>";	
}

?>



</ul>
<div id="popSociety_memberform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_SOCIETY_MEMBER'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Society_memberform">
<li><div class="label"><?php echo $LANG['VILLAGESOCIETYID'];?></div><div class="fromfield"><input type="text"  id="Input_VillageSocietyId" name="Input_VillageSocietyId" value="" class="form_area_textbox"></div></li>
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


