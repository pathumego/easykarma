<?php
require_once("BL/BL_managePerson_talent.php");

function loadPerson_talent($_GET)
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
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$TblId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson_talent\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person_talent</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user"><?PHP echo $LANG['TITLE_TALENT'];?></div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Person_talentList" class="main_listviewul">
<?php

$result =BL_managePerson_talent::getPerson_talentList();

if($result->type ==1)
{
$arr_Person_talentList = $result->data;
if(count($arr_Person_talentList)>0)
{
 
 foreach($arr_Person_talentList as $obj_Person_talent)
 {

 		$html = "<li class=\"ListRow\" id=\"Person_talentListRow_".$obj_Person_talent->TblId."\">";
		$html .= "<div class=\"datarow\">".$obj_Person_talent->TblId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_talent->PersonId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_talent->TalentId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Person_talent_".$obj_Person_talent->TblId."\" type = \"hidden\" value=\"".$obj_Person_talent->getPerson_talentData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person_talent found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person_talent found... </div>";	
}

?>



</ul>
<div id="popPerson_talentform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_PERSON_TALENT'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Person_talentform">
<li><div class="label"><?php echo $LANG['TBLID'];?></div><div class="fromfield"><input type="text"  id="Input_TblId" name="Input_TblId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PERSONID'];?></div><div class="fromfield"><input type="hidden"  id="Input_PersonId" name="Input_PersonId" value="<?php echo $PersonId; ?>" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TALENTID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_TalentId" name="Input_TalentId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_TalentId" name="Dummy_Input_TalentId" value="" class="form_area_textbox">

</div></li>
     
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