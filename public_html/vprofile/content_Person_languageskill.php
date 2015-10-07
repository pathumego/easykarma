<?php
require_once("BL/BL_managePerson_languageskill.php");

function loadPerson_languageskill($_GET)
{
global $LANG;

$PersonId = isset($_GET["personid"] 	) ? $_GET["personid"] 	 : -1 ;	

if($PersonId == -1)
{
	echo "PersonId not found";	

}

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$LangSkillId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson_languageskill\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person_languageskill</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Person_languageskill</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Person_languageskillList" class="main_listviewul">
<?php

$result =BL_managePerson_languageskill::getPerson_languageskillList();

if($result->type ==1)
{
$arr_Person_languageskillList = $result->data;
if(count($arr_Person_languageskillList)>0)
{
 
 foreach($arr_Person_languageskillList as $obj_Person_languageskill)
 {

 		$html = "<li class=\"ListRow\" id=\"Person_languageskillListRow_".$obj_Person_languageskill->LangSkillId."\">";
		$html .= "<div class=\"datarow\">".$obj_Person_languageskill->LangSkillId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_languageskill->PersonId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_languageskill->Language."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_languageskill->SkillType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_languageskill->Grade."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Person_languageskill_".$obj_Person_languageskill->LangSkillId."\" type = \"hidden\" value=\"".$obj_Person_languageskill->getPerson_languageskillData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person_languageskill found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person_languageskill found... </div>";	
}

?>



</ul>
<div id="popPerson_languageskillform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_LANGUAGE_SKILL'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Person_languageskillform">
<li><div class="label"><?php echo $LANG['LANGUAGESKILLID'];?></div><div class="fromfield"><input type="text"  id="Input_LangSkillId" name="Input_LangSkillId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PERSONID'];?></div><div class="fromfield"><input type="hidden"  id="Input_PersonId" name="Input_PersonId" value="<?php echo $PersonId; ?>" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['LANGUAGE'];?></div><div class="fromfield"><input type="text"  id="Input_Language" name="Input_Language" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SKILLTYPE'];?></div><div class="fromfield"><input type="text"  id="Input_SkillType" name="Input_SkillType" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['GRADE'];?></div><div class="fromfield"><input type="text"  id="Input_Grade" name="Input_Grade" value="" class="form_area_textbox"></div></li>
     
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


