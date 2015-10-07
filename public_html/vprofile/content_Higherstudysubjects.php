<?php
require_once("BL/BL_manageHigherstudysubjects.php");

function loadHigherstudysubjects($_GET)
{
global $LANG;
 //$SubjectId = isset($_GET["SubjectId"]) ? $_GET["SubjectId"] : (isset($_SESSION["SubjectId"])?$_SESSION["SubjectId"] :1) ;	
//$_SESSION["SubjectId"] = $SubjectId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$SubjectId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddHigherstudysubjects\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Higherstudysubjects</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Higherstudysubjects</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="HigherstudysubjectsList" class="main_listviewul">
<?php

$result =BL_manageHigherstudysubjects::getHigherstudysubjectsList();

if($result->type ==1)
{
$arr_HigherstudysubjectsList = $result->data;
if(count($arr_HigherstudysubjectsList)>0)
{
 
 foreach($arr_HigherstudysubjectsList as $obj_Higherstudysubjects)
 {

 		$html = "<li class=\"ListRow\" id=\"HigherstudysubjectsListRow_".$obj_Higherstudysubjects->SubjectId."\">";
		$html .= "<div class=\"datarow\">".$obj_Higherstudysubjects->SubjectId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Higherstudysubjects->SubjectName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Higherstudysubjects->SubjectNumber."</div>";
		$html .= "<div class=\"datarow\">".$obj_Higherstudysubjects->SubjectField."</div>";
		$html .= "<div class=\"datarow\">".$obj_Higherstudysubjects->Level."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Higherstudysubjects_".$obj_Higherstudysubjects->SubjectId."\" type = \"hidden\" value=\"".$obj_Higherstudysubjects->getHigherstudysubjectsData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Higherstudysubjects found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Higherstudysubjects found... </div>";	
}

?>



</ul>
<div id="popHigherstudysubjectsform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_HIGHER_STUDY_SUBJECT'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Higherstudysubjectsform">
<li><div class="label"><?php echo $LANG['SUBJECTID'];?></div><div class="fromfield"><input type="text"  id="Input_SubjectId" name="Input_SubjectId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SUBJECTNAME'];?></div><div class="fromfield"><input type="text"  id="Input_SubjectName" name="Input_SubjectName" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SUBJECTNUMBER'];?></div><div class="fromfield"><input type="text"  id="Input_SubjectNumber" name="Input_SubjectNumber" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SUBJECTFIELD'];?></div><div class="fromfield"><input type="text"  id="Input_SubjectField" name="Input_SubjectField" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['LEVEL'];?></div><div class="fromfield"><input type="text"  id="Input_Level" name="Input_Level" value="" class="form_area_textbox"></div></li>
     
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


