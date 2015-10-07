<?php
require_once("BL/BL_manageGeographytype.php");

function loadGeographytype($_GET)
{
global $LANG;
 //$GeogrophyTypeId = isset($_GET["GeogrophyTypeId"]) ? $_GET["GeogrophyTypeId"] : (isset($_SESSION["GeogrophyTypeId"])?$_SESSION["GeogrophyTypeId"] :1) ;	
//$_SESSION["GeogrophyTypeId"] = $GeogrophyTypeId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$GeogrophyTypeId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddGeographytype\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Geographytype</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Geographytype</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="GeographytypeList" class="main_listviewul">
<?php

$result =BL_manageGeographytype::getGeographytypeList();

if($result->type ==1)
{
$arr_GeographytypeList = $result->data;
if(count($arr_GeographytypeList)>0)
{
 
 foreach($arr_GeographytypeList as $obj_Geographytype)
 {

 		$html = "<li class=\"ListRow\" id=\"GeographytypeListRow_".$obj_Geographytype->GeogrophyTypeId."\">";
		$html .= "<div class=\"datarow\">".$obj_Geographytype->GeogrophyTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Geographytype->Name."</div>";
		$html .= "<div class=\"datarow\">".$obj_Geographytype->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Geographytype_".$obj_Geographytype->GeogrophyTypeId."\" type = \"hidden\" value=\"".$obj_Geographytype->getGeographytypeData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Geographytype found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Geographytype found... </div>";	
}

?>



</ul>
<div id="popGeographytypeform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_GEOGRAPHY_TYPE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Geographytypeform">
<li><div class="label"><?php echo $LANG['GEOGRAPHYTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_GeogrophyTypeId" name="Input_GeogrophyTypeId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NAME'];?></div><div class="fromfield"><input type="text"  id="Input_Name" name="Input_Name" value="" class="form_area_textbox"></div></li>
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


