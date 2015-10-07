<?php
require_once("BL/BL_manageOrganization_subtype.php");

function loadOrganization_subtype($_GET)
{
global $LANG;
 //$OrganizationSubTypeId = isset($_GET["OrganizationSubTypeId"]) ? $_GET["OrganizationSubTypeId"] : (isset($_SESSION["OrganizationSubTypeId"])?$_SESSION["OrganizationSubTypeId"] :1) ;	
//$_SESSION["OrganizationSubTypeId"] = $OrganizationSubTypeId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$OrganizationSubTypeId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddOrganization_subtype\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Organization_subtype</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Organization_subtype</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Organization_subtypeList" class="main_listviewul">
<?php

$result =BL_manageOrganization_subtype::getOrganization_subtypeList();

if($result->type ==1)
{
$arr_Organization_subtypeList = $result->data;
if(count($arr_Organization_subtypeList)>0)
{
 
 foreach($arr_Organization_subtypeList as $obj_Organization_subtype)
 {

 		$html = "<li class=\"ListRow\" id=\"Organization_subtypeListRow_".$obj_Organization_subtype->OrganizationSubTypeId."\">";
		$html .= "<div class=\"datarow\">".$obj_Organization_subtype->OrganizationSubTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization_subtype->OrganizationSubTypeName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization_subtype->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Organization_subtype_".$obj_Organization_subtype->OrganizationSubTypeId."\" type = \"hidden\" value=\"".$obj_Organization_subtype->getOrganization_subtypeData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Organization_subtype found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Organization_subtype found... </div>";	
}

?>



</ul>
<div id="popOrganization_subtypeform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_ORGANISATIONAL_SUB_TYPE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Organization_subtypeform">
<li><div class="label"><?php echo $LANG['ORGANIZATIONSUBTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_OrganizationSubTypeId" name="Input_OrganizationSubTypeId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ORGANIZATIONSUBTYPENAME'];?></div><div class="fromfield"><input type="text"  id="Input_OrganizationSubTypeName" name="Input_OrganizationSubTypeName" value="" class="form_area_textbox"></div></li>
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


