<?php
require_once("BL/BL_managePerson_telephone.php");

function loadPerson_telephone($_GET)
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
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$PhoneId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson_telephone\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person_telephone</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Person_telephone</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Person_telephoneList" class="main_listviewul">
<?php

$result =BL_managePerson_telephone::getPerson_telephoneList();

if($result->type ==1)
{
$arr_Person_telephoneList = $result->data;
if(count($arr_Person_telephoneList)>0)
{
 
 foreach($arr_Person_telephoneList as $obj_Person_telephone)
 {

 		$html = "<li class=\"ListRow\" id=\"Person_telephoneListRow_".$obj_Person_telephone->PhoneId."\">";
		$html .= "<div class=\"datarow\">".$obj_Person_telephone->PhoneId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_telephone->PhoneNumber."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_telephone->Type."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_telephone->PersonId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Person_telephone_".$obj_Person_telephone->PhoneId."\" type = \"hidden\" value=\"".$obj_Person_telephone->getPerson_telephoneData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person_telephone found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person_telephone found... </div>";	
}

?>



</ul>
<div id="popPerson_telephoneform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_TELEPHONE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Person_telephoneform">
<li><div class="label"><?php echo $LANG['PHONEID'];?></div><div class="fromfield"><input type="text"  id="Input_PhoneId" name="Input_PhoneId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PHONENUMBER'];?></div><div class="fromfield"><input type="text"  id="Input_PhoneNumber" name="Input_PhoneNumber" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TYPE'];?></div><div class="fromfield"><input type="text"  id="Input_Type" name="Input_Type" value="" class="form_area_textbox"></div></li>
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


