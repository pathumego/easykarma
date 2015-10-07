<?php
require_once("BL/BL_manageSocierytype.php");

function loadSocierytype($_GET)
{
global $LANG;
 //$SocieryTypeId = isset($_GET["SocieryTypeId"]) ? $_GET["SocieryTypeId"] : (isset($_SESSION["SocieryTypeId"])?$_SESSION["SocieryTypeId"] :1) ;	
//$_SESSION["SocieryTypeId"] = $SocieryTypeId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$SocieryTypeId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddSocierytype\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Socierytype</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Socierytype</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="SocierytypeList" class="main_listviewul">
<?php

$result =BL_manageSocierytype::getSocierytypeList();

if($result->type ==1)
{
$arr_SocierytypeList = $result->data;
if(count($arr_SocierytypeList)>0)
{
 
 foreach($arr_SocierytypeList as $obj_Socierytype)
 {

 		$html = "<li class=\"ListRow\" id=\"SocierytypeListRow_".$obj_Socierytype->SocieryTypeId."\">";
		$html .= "<div class=\"datarow\">".$obj_Socierytype->SocieryTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Socierytype->SocieryTypeName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Socierytype->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Socierytype_".$obj_Socierytype->SocieryTypeId."\" type = \"hidden\" value=\"".$obj_Socierytype->getSocierytypeData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Socierytype found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Socierytype found... </div>";	
}

?>



</ul>
<div id="popSocierytypeform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_SOCIETY_TYPE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Socierytypeform">
<li><div class="label"><?php echo $LANG['SOCIETYTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_SocieryTypeId" name="Input_SocieryTypeId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SOCIETYTYPENAME'];?></div><div class="fromfield"><input type="text"  id="Input_SocieryTypeName" name="Input_SocieryTypeName" value="" class="form_area_textbox"></div></li>
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


