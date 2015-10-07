<?php
require_once("BL/BL_managePerson.php");
require_once("config.php");
function loadPerson($_GET)
{
global $LANG;
 //$PersonId = isset($_GET["personid"] 	) ? $_GET["personid"] 	 : (isset($_SESSION["PersonId"])?$_SESSION["PersonId"] :1) ;	
//$_SESSION["PersonId"] = $PersonId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$PersonId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Person</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">
<ul class="main_listviewulheader">
<li class="HeaderListRow">
<div class="headerdatarow datarow_person_personid">#</div>
<div class="headerdatarow datarow_person_fullname">FullName</div>
<div class="headerdatarow datarow_person_nickname">NickName</div>
<div class="headerdatarow datarow_person_email">Email</div>
</li>
</ul>
<ul id="PersonList" class="main_listviewul">
<?php

$result =BL_managePerson::getPersonList();

if($result->type ==1)
{
$arr_PersonList = $result->data;
if(count($arr_PersonList)>0)
{
 
 foreach($arr_PersonList as $obj_Person)
 {

 		$html = "<li class=\"ListRow\" id=\"PersonListRow_".$obj_Person->PersonId."\">";
		$html .= "<div class=\"datarow datarow_person_personid\">".$obj_Person->PersonId."</div>";
		$html .= "<div class=\"datarow datarow_person_fullname\">".$obj_Person->FullName."</div>";
		$html .= "<div class=\"datarow datarow_person_nickname\">".$obj_Person->NickName."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Person->OtherNames."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Person->DrivingLicenceNo."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Person->PassportNo."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Person->PermanentAddress."</div>";
		$html .= "<div class=\"datarow datarow_person_email\">".$obj_Person->Email."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Person->Website."</div>";
	//	$html .= "<div class=\"datarow datarow_person_description\">".$obj_Person->Description."</div>";
	//	$html .= "<div class=\"datarow\">".$obj_Person->Gender."</div>";
	/*	$html .= "<div class=\"datarow\">".$obj_Person->DOB."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->Height."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->Weight."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->HairColor."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->EyeColor."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->BloodType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->Occupation."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->MonthlyIncome."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->FutureTargets."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->FutureNeeds."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->DOD."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->Picture."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->NIC."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person->Status."</div>";
	*/  
		$html .= "<div class=\"databtncell\"><a href=\"".$_SERVER['SCRIPT_NAME']."?page=persondashboard&personid=".$obj_Person->PersonId."\" class=\"rowbtn\">Select</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		/*$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Address</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">AL</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">OL</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Lang-Skill</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Property</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Talents</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">TP</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Vocational-Training</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Work-Experiance</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Education-Level</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">HigherEducation</a></div>";
		*/
		$html .= "<input id=\"Person_".$obj_Person->PersonId."\" type = \"hidden\" value=\"".$obj_Person->getPersonData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person found... </div>";	
}

?>



</ul>
<div id="popPersonform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_PERSON_FORM'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Personform">
<li><div class="label"><?php echo $LANG['PERSONID'];?></div><div class="fromfield"><input type="text"  id="Input_PersonId" name="Input_PersonId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['FULLNAME'];?></div><div class="fromfield"><input type="text"  id="Input_FullName" name="Input_FullName" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NICKNAME'];?></div><div class="fromfield"><input type="text"  id="Input_NickName" name="Input_NickName" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['OTHERNAME'];?></div><div class="fromfield"><input type="text"  id="Input_OtherNames" name="Input_OtherNames" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DRIVINGLICENENUMBER'];?></div><div class="fromfield"><input type="text"  id="Input_DrivingLicenceNo" name="Input_DrivingLicenceNo" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PASSPORTNUMBER'];?></div><div class="fromfield"><input type="text"  id="Input_PassportNo" name="Input_PassportNo" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PERMENENTADRESS'];?></div><div class="fromfield"><input type="text"  id="Input_PermanentAddress" name="Input_PermanentAddress" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['EMAIL'];?></div><div class="fromfield"><input type="text"  id="Input_Email" name="Input_Email" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['WEBSITE'];?></div><div class="fromfield"><input type="text"  id="Input_Website" name="Input_Website" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_Description" name="Input_Description" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['GENDER'];?></div><div class="fromfield">
<select  id="Input_Gender" name="Input_Gender" value="" class="form_area_dropdown">
<?php

$arr =config::dropdown_person_gender();

if(count($arr)>0)
{
$html = ""; 
 foreach($arr as $drpindex=>$drpitem)
 {
		$html .= "<option value=\"".$drpindex."\">";
		$html .= $drpitem;
		$html .= "</option>";
 }
echo $html;
}
else{
echo "<option>Please Select</option>";	
}
?>	</select>
</div></li>
<li><div class="label"><?php echo $LANG['DOB'];?></div><div class="fromfield"><input type="text"  id="Input_DOB" name="Input_DOB" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['HEIGHT'];?></div><div class="fromfield"><input type="text"  id="Input_Height" name="Input_Height" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['WEIGHT'];?></div><div class="fromfield"><input type="text"  id="Input_Weight" name="Input_Weight" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['HAIRCOLOR'];?></div><div class="fromfield"><input type="text"  id="Input_HairColor" name="Input_HairColor" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['EYECOLOR'];?></div><div class="fromfield"><input type="text"  id="Input_EyeColor" name="Input_EyeColor" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['BLOODTYPE'];?></div><div class="fromfield">
<select  id="Input_BloodType" name="Input_BloodType" value="" class="form_area_dropdown">
<?php

$arr =config::dropdown_person_bloodtype();
if(count($arr)>0)
{
$html = ""; 
 foreach($arr as $drpindex=>$drpitem)
 {
		$html .= "<option value=\"".$drpindex."\">";
		$html .= $drpitem;
		$html .= "</option>";
 }
echo $html;
}
else{
echo "<option>Please Select</option>";	
}
?>	</select>

</div></li>
<li><div class="label"><?php echo $LANG['OCCUPATION'];?></div><div class="fromfield"><input type="text"  id="Input_Occupation" name="Input_Occupation" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['MONTHLYINCOME'];?></div><div class="fromfield"><input type="text"  id="Input_MonthlyIncome" name="Input_MonthlyIncome" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['FUTURETARGETS'];?></div><div class="fromfield"><input type="text"  id="Input_FutureTargets" name="Input_FutureTargets" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['FUTURENEEDS'];?></div><div class="fromfield"><input type="text"  id="Input_FutureNeeds" name="Input_FutureNeeds" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DOD'];?></div><div class="fromfield"><input type="text"  id="Input_DOD" name="Input_DOD" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PICTURE'];?></div><div class="fromfield"><input type="text"  id="Input_Picture" name="Input_Picture" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NIC'];?></div><div class="fromfield"><input type="text"  id="Input_NIC" name="Input_NIC" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['STATUS'];?></div><div class="fromfield"><input type="text"  id="Input_Status" name="Input_Status" value="" class="form_area_textbox"></div></li>
     
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


