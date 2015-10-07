<?php
require_once("BL/BL_manageOrganization.php");

function loadOrganization($_GET)
{
global $LANG;
 //$OrganizationId = isset($_GET["OrganizationId"]) ? $_GET["OrganizationId"] : (isset($_SESSION["OrganizationId"])?$_SESSION["OrganizationId"] :1) ;	
//$_SESSION["OrganizationId"] = $OrganizationId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$OrganizationId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddOrganization\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Organization</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Organization</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="OrganizationList" class="main_listviewul">
<?php

$result =BL_manageOrganization::getOrganizationList();

if($result->type ==1)
{
$arr_OrganizationList = $result->data;
if(count($arr_OrganizationList)>0)
{
 
 foreach($arr_OrganizationList as $obj_Organization)
 {

 		$html = "<li class=\"ListRow\" id=\"OrganizationListRow_".$obj_Organization->OrganizationId."\">";
		$html .= "<div class=\"datarow\">".$obj_Organization->OrganizationId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization->Name."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization->Description."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization->Address."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization->telephone."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization->fax."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization->website."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization->email."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization->OrganizationTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Organization->OrganizationSubTypeId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Organization_".$obj_Organization->OrganizationId."\" type = \"hidden\" value=\"".$obj_Organization->getOrganizationData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Organization found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Organization found... </div>";	
}

?>



</ul>
<div id="popOrganizationform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_ORGANISATION_FORM'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Organizationform">
<li><div class="label"><?php echo $LANG['ORGANIZATIONID'];?></div><div class="fromfield"><input type="text"  id="Input_OrganizationId" name="Input_OrganizationId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NAME'];?></div><div class="fromfield"><input type="text"  id="Input_Name" name="Input_Name" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_Description" name="Input_Description" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NAME'];?></div><div class="fromfield"><input type="text"  id="Input_Address" name="Input_Address" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TELEPHONE'];?></div><div class="fromfield"><input type="text"  id="Input_telephone" name="Input_telephone" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['FAX'];?></div><div class="fromfield"><input type="text"  id="Input_fax" name="Input_fax" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['WEBSITE'];?></div><div class="fromfield"><input type="text"  id="Input_website" name="Input_website" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['EMAIL'];?></div><div class="fromfield"><input type="text"  id="Input_email" name="Input_email" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ORGANIZATIONTYPEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_OrganizationTypeId" name="Input_OrganizationTypeId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_OrganizationTypeId" name="Dummy_Input_OrganizationTypeId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['ORGANIZATIONSUBTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_OrganizationSubTypeId" name="Input_OrganizationSubTypeId" value="" class="form_area_textbox"></div></li>
     
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