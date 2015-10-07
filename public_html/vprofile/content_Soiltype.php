<?php
require_once("BL/BL_manageSoiltype.php");

function loadSoiltype($_GET)
{
global $LANG;
 //$TblId = isset($_GET["TblId"]) ? $_GET["TblId"] : (isset($_SESSION["TblId"])?$_SESSION["TblId"] :1) ;	
//$_SESSION["TblId"] = $TblId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$TblId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddSoiltype\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Soiltype</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Soiltype</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="SoiltypeList" class="main_listviewul">
<?php

$result =BL_manageSoiltype::getSoiltypeList();

if($result->type ==1)
{
$arr_SoiltypeList = $result->data;
if(count($arr_SoiltypeList)>0)
{
 
 foreach($arr_SoiltypeList as $obj_Soiltype)
 {

 		$html = "<li class=\"ListRow\" id=\"SoiltypeListRow_".$obj_Soiltype->TblId."\">";
		$html .= "<div class=\"datarow\">".$obj_Soiltype->TblId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Soiltype->SoilTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Soiltype->SoilTypeName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Soiltype->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Soiltype_".$obj_Soiltype->TblId."\" type = \"hidden\" value=\"".$obj_Soiltype->getSoiltypeData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Soiltype found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Soiltype found... </div>";	
}

?>



</ul>
<div id="popSoiltypeform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_SOIL_TYPE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Soiltypeform">
<li><div class="label"><?php echo $LANG['TBLID'];?></div><div class="fromfield"><input type="text"  id="Input_TblId" name="Input_TblId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SOILTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_SoilTypeId" name="Input_SoilTypeId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SOILTYPENAME'];?></div><div class="fromfield"><input type="text"  id="Input_SoilTypeName" name="Input_SoilTypeName" value="" class="form_area_textbox"></div></li>
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


