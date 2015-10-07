<?php
require_once("BL/BL_managePerson_workingexperiance.php");

function loadPerson_workingexperiance($_GET)
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
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$WorkExpId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson_workingexperiance\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person_workingexperiance</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user"><?PHP echo $LANG['TITLE_WORKING_EXPIRIANCE'];?></div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Person_workingexperianceList" class="main_listviewul">
<?php

$result =BL_managePerson_workingexperiance::getPerson_workingexperianceList();

if($result->type ==1)
{
$arr_Person_workingexperianceList = $result->data;
if(count($arr_Person_workingexperianceList)>0)
{
 
 foreach($arr_Person_workingexperianceList as $obj_Person_workingexperiance)
 {

 		$html = "<li class=\"ListRow\" id=\"Person_workingexperianceListRow_".$obj_Person_workingexperiance->WorkExpId."\">";
		$html .= "<div class=\"datarow\">".$obj_Person_workingexperiance->WorkExpId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_workingexperiance->CompanyId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_workingexperiance->StartDate."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_workingexperiance->EndDate."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_workingexperiance->Position."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_workingexperiance->PersonId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Person_workingexperiance_".$obj_Person_workingexperiance->WorkExpId."\" type = \"hidden\" value=\"".$obj_Person_workingexperiance->getPerson_workingexperianceData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person_workingexperiance found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person_workingexperiance found... </div>";	
}

?>



</ul>
<div id="popPerson_workingexperianceform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_WORKING_EXPERIANCE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Person_workingexperianceform">
<li><div class="label"><?php echo $LANG['WORKEXPID'];?></div><div class="fromfield"><input type="text"  id="Input_WorkExpId" name="Input_WorkExpId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['COMPANYID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_CompanyId" name="Input_CompanyId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_CompanyId" name="Dummy_Input_CompanyId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['STARTDATE'];?></div><div class="fromfield"><input type="text"  id="Input_StartDate" name="Input_StartDate" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ENDDATE'];?></div><div class="fromfield"><input type="text"  id="Input_EndDate" name="Input_EndDate" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['POSITION'];?></div><div class="fromfield"><input type="text"  id="Input_Position" name="Input_Position" value="" class="form_area_textbox"></div></li>
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