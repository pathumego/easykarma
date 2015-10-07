<?php
require_once("BL/BL_managePerson_olresult.php");
require_once("BL/BL_manageOlsubjects.php");

function loadPerson_olresult($_GET)
{
global $LANG;

$PersonId = isset($_GET["personid"]) ? $_GET["personid"] 	 : -1 ;	
if($PersonId == -1)
{
	echo "PersonId not found";	
}

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$OLResultId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson_olresult\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person_olresult</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user"><?PHP echo $LANG['TITLE_O_L_RESULT'];?></div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Person_olresultList" class="main_listviewul">
<?php

$result =BL_managePerson_olresult::getPerson_olresultList();

if($result->type ==1)
{
$arr_Person_olresultList = $result->data;
if(count($arr_Person_olresultList)>0)
{
 
 foreach($arr_Person_olresultList as $obj_Person_olresult)
 {

 		$html = "<li class=\"ListRow\" id=\"Person_olresultListRow_".$obj_Person_olresult->OLResultId."\">";
		$html .= "<div class=\"datarow\">".$obj_Person_olresult->OLResultId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_olresult->SubjectId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_olresult->SchoolId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_olresult->Grade."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_olresult->Language."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_olresult->DateTime."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_olresult->PersonId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Person_olresult_".$obj_Person_olresult->OLResultId."\" type = \"hidden\" value=\"".$obj_Person_olresult->getPerson_olresultData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person_olresult found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person_olresult found... </div>";	
}

?>



</ul>
<div id="popPerson_olresultform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_O_L_RESULT'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Person_olresultform">
<li><div class="label"><?php echo $LANG['OLRESULTID'];?></div><div class="fromfield"><input type="text"  id="Input_OLResultId" name="Input_OLResultId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SUBJECTID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_SubjectId" name="Input_SubjectId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_SubjectId" name="Dummy_Input_SubjectId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['SCHOOLID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_SchoolId" name="Input_SchoolId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_SchoolId" name="Dummy_Input_SchoolId" value="" class="form_area_textbox">
</div></li>
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