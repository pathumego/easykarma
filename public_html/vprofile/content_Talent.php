<?php
require_once("BL/BL_manageTalent.php");

function loadTalent($_GET)
{
global $LANG;
 //$TalentId = isset($_GET["TalentId"]) ? $_GET["TalentId"] : (isset($_SESSION["TalentId"])?$_SESSION["TalentId"] :1) ;	
//$_SESSION["TalentId"] = $TalentId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$TalentId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddTalent\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Talent</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Talent</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="TalentList" class="main_listviewul">
<?php

$result =BL_manageTalent::getTalentList();

if($result->type ==1)
{
$arr_TalentList = $result->data;
if(count($arr_TalentList)>0)
{
 
 foreach($arr_TalentList as $obj_Talent)
 {

 		$html = "<li class=\"ListRow\" id=\"TalentListRow_".$obj_Talent->TalentId."\">";
		$html .= "<div class=\"datarow\">".$obj_Talent->TalentId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Talent->TalentType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Talent->TalentField."</div>";
		$html .= "<div class=\"datarow\">".$obj_Talent->Description."</div>";
		$html .= "<div class=\"datarow\">".$obj_Talent->TalentName."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Talent_".$obj_Talent->TalentId."\" type = \"hidden\" value=\"".$obj_Talent->getTalentData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Talent found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Talent found... </div>";	
}

?>



</ul>
<div id="popTalentform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_TALENT'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Talentform">
<li><div class="label"><?php echo $LANG['TALENTID'];?></div><div class="fromfield"><input type="text"  id="Input_TalentId" name="Input_TalentId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TALENTTYPE'];?></div><div class="fromfield"><input type="text"  id="Input_TalentType" name="Input_TalentType" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TALENTFIELD'];?></div><div class="fromfield">
<input type="text"  id="hidden_TalentField" name="Input_TalentField" value="" class="form_area_textbox"> 
<input type="text"  id="Dummy_Input_TalentField" name="Dummy_Input_TalentField" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_Description" name="Input_Description" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TALENTNAME'];?></div><div class="fromfield"><input type="text"  id="Input_TalentName" name="Input_TalentName" value="" class="form_area_textbox"></div></li>
     
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


