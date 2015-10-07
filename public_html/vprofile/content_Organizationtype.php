<?php
require_once("BL/BL_manageOrganizationtype.php");

function loadOrganizationtype($_GET)
{
global $LANG;
 //$OrganizationTypeId = isset($_GET["OrganizationTypeId"]) ? $_GET["OrganizationTypeId"] : (isset($_SESSION["OrganizationTypeId"])?$_SESSION["OrganizationTypeId"] :1) ;	
//$_SESSION["OrganizationTypeId"] = $OrganizationTypeId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$OrganizationTypeId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddOrganizationtype\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Organizationtype</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Organizationtype</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="OrganizationtypeList" class="main_listviewul">
<?php

$result =BL_manageOrganizationtype::getOrganizationtypeList();

if($result->type ==1)
{
$arr_OrganizationtypeList = $result->data;
if(count($arr_OrganizationtypeList)>0)
{
 
 foreach($arr_OrganizationtypeList as $obj_Organizationtype)
 {

 		$html = "<li class=\"ListRow\" id=\"OrganizationtypeListRow_".$obj_Organizationtype->OrganizationTypeId."\">";
		$html .= "<div class=\"datarow\">".$obj_Organizationtype->OrganizationTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organizationtype->OrganizationTypeName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organizationtype->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Organizationtype_".$obj_Organizationtype->OrganizationTypeId."\" type = \"hidden\" value=\"".$obj_Organizationtype->getOrganizationtypeData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Organizationtype found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Organizationtype found... </div>";	
}

?>



</ul>
<div id="popOrganizationtypeform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_ORGANISATION_TYPE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Organizationtypeform">
<li><div class="label"><?php echo $LANG['ORGANIZATIONTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_OrganizationTypeId" name="Input_OrganizationTypeId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ORGANIZATIONTYPE'];?></div><div class="fromfield"><input type="text"  id="Input_OrganizationTypeName" name="Input_OrganizationTypeName" value="" class="form_area_textbox"></div></li>
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


