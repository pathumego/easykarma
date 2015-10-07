<?php
require_once("BL/BL_managePerson_property.php");

function loadPerson_property($_GET)
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
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$PropertyId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson_property\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person_property</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user"><?PHP echo $LANG['TITLE_PROPERTY'];?></div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Person_propertyList" class="main_listviewul">
<?php

$result =BL_managePerson_property::getPerson_propertyList();

if($result->type ==1)
{
$arr_Person_propertyList = $result->data;
if(count($arr_Person_propertyList)>0)
{
 
 foreach($arr_Person_propertyList as $obj_Person_property)
 {

 		$html = "<li class=\"ListRow\" id=\"Person_propertyListRow_".$obj_Person_property->PropertyId."\">";
		$html .= "<div class=\"datarow\">".$obj_Person_property->PropertyId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_property->PropertyName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_property->PropertyType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_property->AssessValue."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_property->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Person_property_".$obj_Person_property->PropertyId."\" type = \"hidden\" value=\"".$obj_Person_property->getPerson_propertyData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person_property found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person_property found... </div>";	
}

?>



</ul>
<div id="popPerson_propertyform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_PERSON_PROPERTY'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Person_propertyform">
<li><div class="label"><?php echo $LANG['PROPERTYID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_PropertyId" name="Input_PropertyId" value="" class="form_area_textbox"> 
<input type="text"  id="Dummy_Input_PropertyId" name="Dummy_Input_PropertyId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['PROPERTYNAME'];?></div><div class="fromfield"><input type="text"  id="Input_PropertyName" name="Input_PropertyName" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PROPERTYTYPE'];?></div><div class="fromfield"><input type="text"  id="Input_PropertyType" name="Input_PropertyType" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ASSESSVALUE'];?></div><div class="fromfield"><input type="text"  id="Input_AssessValue" name="Input_AssessValue" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_Description" name="Input_Description" value="" class="form_area_textbox"></div></li>
     
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