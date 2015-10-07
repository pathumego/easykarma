<?php
require_once("BL/BL_managePerson_educationlevel.php");

function loadPerson_educationlevel($_GET)
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
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$EducationLevelId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson_educationlevel\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person_educationlevel</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user"><?PHP echo $LANG['TITLE_PERSON_EDUCATION_LEVEL'];?></div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Person_educationlevelList" class="main_listviewul">
<?php

$result =BL_managePerson_educationlevel::getPerson_educationlevelList();

if($result->type ==1)
{
$arr_Person_educationlevelList = $result->data;
if(count($arr_Person_educationlevelList)>0)
{
 
 foreach($arr_Person_educationlevelList as $obj_Person_educationlevel)
 {

 		$html = "<li class=\"ListRow\" id=\"Person_educationlevelListRow_".$obj_Person_educationlevel->EducationLevelId."\">";
		$html .= "<div class=\"datarow\">".$obj_Person_educationlevel->EducationLevelId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_educationlevel->SchoolId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_educationlevel->StartYear."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_educationlevel->StartClass."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_educationlevel->EndYear."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_educationlevel->EndClass."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_educationlevel->PersonId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Person_educationlevel_".$obj_Person_educationlevel->EducationLevelId."\" type = \"hidden\" value=\"".$obj_Person_educationlevel->getPerson_educationlevelData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person_educationlevel found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person_educationlevel found... </div>";	
}

?>



</ul>
<div id="popPerson_educationlevelform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_EDUCATION_LEVEL'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Person_educationlevelform">
<li><div class="label"><?php echo $LANG['EDUCATIONLEVELID'];?></div><div class="fromfield"><input type="text"  id="Input_EducationLevelId" name="Input_EducationLevelId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SCHOOLID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_SchoolId" name="Input_SchoolId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_SchoolId" name="Dummy_Input_SchoolId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['STARTYEAR'];?></div><div class="fromfield"><input type="text"  id="Input_StartYear" name="Input_StartYear" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['STARTCLASS'];?></div><div class="fromfield"><input type="text"  id="Input_StartClass" name="Input_StartClass" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ENDYEAR'];?></div><div class="fromfield"><input type="text"  id="Input_EndYear" name="Input_EndYear" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ENDCLASS'];?></div><div class="fromfield"><input type="text"  id="Input_EndClass" name="Input_EndClass" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PERSONID'];?></div><div class="fromfield"><input type="hidden"  id="Input_PersonId" name="Input_PersonId" value="<?php echo $PersonId; ?>" class="form_area_textbox"></div></li>
     
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