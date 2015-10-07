<?php
require_once("BL/BL_manageUser.php");

function loadUser($_GET)
{
 //$userId = isset($_GET["userId"]) ? $_GET["userId"] : (isset($_SESSION["userId"])?$_SESSION["userId"] :1) ;	
//$_SESSION["userId"] = $userId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$userId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddUser\" href=\"#\"><div class=\"doublearrow\">+</div>ADD User</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage User</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="UserList" class="main_listviewul">
<?php

$result =BL_manageUser::getUserList();

if($result->type ==1)
{
$arr_UserList = $result->data;
if(count($arr_UserList)>0)
{
 
 foreach($arr_UserList as $obj_User)
 {

 		$html = "<li class=\"ListRow\" id=\"UserListRow_".$obj_User->userId."\">";
		$html .= "<div class=\"datarow\">".$obj_User->userId."</div>";
		$html .= "<div class=\"datarow\">".$obj_User->userName."</div>";
		//$html .= "<div class=\"datarow\">".$obj_User->password."</div>";
		$html .= "<div class=\"datarow\">".$obj_User->personId."</div>";
		$html .= "<div class=\"datarow\">".$obj_User->userType."</div>";
		$html .= "<div class=\"datarow\">".$obj_User->userOptCode."</div>";
		$html .= "<div class=\"datarow\">".$obj_User->userMetadata."</div>";
		$html .= "<div class=\"datarow\">".$obj_User->userStatus."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"User_".$obj_User->userId."\" type = \"hidden\" value=\"".$obj_User->getUserData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No User found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No User found... </div>";	
}

?>



</ul>
<div id="popUserform" class="formPopup">
<div class="subheader">Fill the User details & click "Add" button.</div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Userform">
<li><div class="label">userId</div><div class="fromfield"><input type="text"  id="Input_userId" name="Input_userId" value="" class="form_area_textbox"></div></li>
<li><div class="label">userName</div><div class="fromfield"><input type="text"  id="Input_userName" name="Input_userName" value="" class="form_area_textbox"></div></li>
<li><div class="label">password</div><div class="fromfield"><input type="password"  id="Input_password" name="Input_password" value="" class="form_area_textbox"></div></li>
<li><div class="label">personId</div><div class="fromfield"><input type="text"  id="Input_personId" name="Input_personId" value="" class="form_area_textbox"></div></li>
<li><div class="label">userType</div><div class="fromfield"><input type="text"  id="Input_userType" name="Input_userType" value="" class="form_area_textbox"></div></li>
<li><div class="label">userOptCode</div><div class="fromfield"><input type="text"  id="Input_userOptCode" name="Input_userOptCode" value="" class="form_area_textbox"></div></li>
<li><div class="label">userMetadata</div><div class="fromfield"><input type="text"  id="Input_userMetadata" name="Input_userMetadata" value="" class="form_area_textbox"></div></li>
<li><div class="label">userStatus</div><div class="fromfield"><input type="text"  id="Input_userStatus" name="Input_userStatus" value="" class="form_area_textbox"></div></li>
     
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
