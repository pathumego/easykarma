<?php
require_once("BL/BL_managePerson_alresult.php");
require_once("BL/BL_manageAlsubjects.php");

function loadPerson_alresult($_GET)
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
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$ALResultId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson_alresult\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person_alresult</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user"><?PHP echo $LANG['TITLE_A_L_RESULT'];?></div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Person_alresultList" class="main_listviewul">
<?php

$result =BL_managePerson_alresult::getPerson_alresultList();

if($result->type ==1)
{
$arr_Person_alresultList = $result->data;
if(count($arr_Person_alresultList)>0)
{
 
 foreach($arr_Person_alresultList as $obj_Person_alresult)
 {

 		$html = "<li class=\"ListRow\" id=\"Person_alresultListRow_".$obj_Person_alresult->ALResultId."\">";
		$html .= "<div class=\"datarow\">".$obj_Person_alresult->ALResultId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_alresult->SubjectId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_alresult->SchoolId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_alresult->Grade."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_alresult->Language."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_alresult->DateTime."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_alresult->PersonId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Person_alresult_".$obj_Person_alresult->ALResultId."\" type = \"hidden\" value=\"".$obj_Person_alresult->getPerson_alresultData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person_alresult found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person_alresult found... </div>";	
}

?>



</ul>
<div id="popPerson_alresultform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_A_L_RESULT_FORM'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Person_alresultform">
<li><div class="label"><?php echo $LANG['ALRESULTID'];?></div><div class="fromfield">
<input type="text"  id="Input_ALResultId" name="Input_ALResultId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SUBJECTID'];?></div>
<div class="fromfield">
<input type="hidden"  id="Input_SubjectId" name="Input_SubjectId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_SubjectId" name="Dummy_Input_SubjectId" value="" class="form_area_textbox">
</div>
</li>
<li>
	<div class="label">SchoolId</div><div class="fromfield">
	<input type="hidden"  id="Input_SchoolId" name="Input_SchoolId" value="" class="form_area_textbox">
	<input type="text"  id="Dummy_Input_SchoolId" name="Dummy_Input_SchoolId" value="" class="form_area_textbox">
	</div>	
</li>

<li><div class="label"><?php echo $LANG['GRADE'];?></div><div class="fromfield"><input type="text"  id="Input_Grade" name="Input_Grade" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['LANGUAGE'];?></div><div class="fromfield"><input type="text"  id="Input_Language" name="Input_Language" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DATETIME'];?></div><div class="fromfield"><input type="text"  id="Input_DateTime" name="Input_DateTime" value="" class="form_area_textbox"></div></li>
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


