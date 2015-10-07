<?php
require_once("BL/BL_managePerson_vocationaltraining.php");

function loadPerson_vocationaltraining($_GET)
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
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$VocationalTrainId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson_vocationaltraining\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person_vocationaltraining</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user"><?PHP echo $LANG['TITLE_VOCATIONAL_TRAINING'];?></div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Person_vocationaltrainingList" class="main_listviewul">
<?php

$result =BL_managePerson_vocationaltraining::getPerson_vocationaltrainingList();

if($result->type ==1)
{
$arr_Person_vocationaltrainingList = $result->data;
if(count($arr_Person_vocationaltrainingList)>0)
{
 
 foreach($arr_Person_vocationaltrainingList as $obj_Person_vocationaltraining)
 {

 		$html = "<li class=\"ListRow\" id=\"Person_vocationaltrainingListRow_".$obj_Person_vocationaltraining->VocationalTrainId."\">";
		$html .= "<div class=\"datarow\">".$obj_Person_vocationaltraining->VocationalTrainId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_vocationaltraining->FieldName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_vocationaltraining->CourseName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_vocationaltraining->InstituteId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_vocationaltraining->StartDate."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_vocationaltraining->EndDate."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_vocationaltraining->CertificateType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_vocationaltraining->PersonId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Person_vocationaltraining_".$obj_Person_vocationaltraining->VocationalTrainId."\" type = \"hidden\" value=\"".$obj_Person_vocationaltraining->getPerson_vocationaltrainingData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person_vocationaltraining found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person_vocationaltraining found... </div>";	
}

?>



</ul>
<div id="popPerson_vocationaltrainingform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VOCATIONAL_TRAINING'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Person_vocationaltrainingform">
<li><div class="label"><?php echo $LANG['VOCATIONALTRAINID'];?></div><div class="fromfield"><input type="text"  id="Input_VocationalTrainId" name="Input_VocationalTrainId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['FIELDNAME'];?></div><div class="fromfield"><input type="text"  id="Input_FieldName" name="Input_FieldName" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['COURCENAME'];?></div><div class="fromfield"><input type="text"  id="Input_CourseName" name="Input_CourseName" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['INSTITUTEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_InstituteId" name="Input_InstituteId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_InstituteId" name="Dummy_Input_InstituteId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['STARTDATE'];?></div><div class="fromfield"><input type="text"  id="Input_StartDate" name="Input_StartDate" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ENDDATE'];?></div><div class="fromfield"><input type="text"  id="Input_EndDate" name="Input_EndDate" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['CERTIFICATETYPE'];?></div><div class="fromfield"><input type="text"  id="Input_CertificateType" name="Input_CertificateType" value="" class="form_area_textbox"></div></li>
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