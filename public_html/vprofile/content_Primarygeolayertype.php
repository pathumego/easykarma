<?php
require_once("BL/BL_managePrimarygeolayertype.php");

function loadPrimarygeolayertype($_GET)
{
global $LANG;
 //$PrimaryGeoLayerTypeId = isset($_GET["PrimaryGeoLayerTypeId"]) ? $_GET["PrimaryGeoLayerTypeId"] : (isset($_SESSION["PrimaryGeoLayerTypeId"])?$_SESSION["PrimaryGeoLayerTypeId"] :1) ;	
//$_SESSION["PrimaryGeoLayerTypeId"] = $PrimaryGeoLayerTypeId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$PrimaryGeoLayerTypeId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPrimarygeolayertype\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Primarygeolayertype</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Primarygeolayertype</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="PrimarygeolayertypeList" class="main_listviewul">
<?php

$result =BL_managePrimarygeolayertype::getPrimarygeolayertypeList();

if($result->type ==1)
{
$arr_PrimarygeolayertypeList = $result->data;
if(count($arr_PrimarygeolayertypeList)>0)
{
 
 foreach($arr_PrimarygeolayertypeList as $obj_Primarygeolayertype)
 {

 		$html = "<li class=\"ListRow\" id=\"PrimarygeolayertypeListRow_".$obj_Primarygeolayertype->PrimaryGeoLayerTypeId."\">";
		$html .= "<div class=\"datarow\">".$obj_Primarygeolayertype->PrimaryGeoLayerTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Primarygeolayertype->PrimaryGeoLayerName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Primarygeolayertype->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Primarygeolayertype_".$obj_Primarygeolayertype->PrimaryGeoLayerTypeId."\" type = \"hidden\" value=\"".$obj_Primarygeolayertype->getPrimarygeolayertypeData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Primarygeolayertype found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Primarygeolayertype found... </div>";	
}

?>



</ul>
<div id="popPrimarygeolayertypeform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_PRIMARY_GEO_LAYER_TYPE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Primarygeolayertypeform">
<li><div class="label"><?php echo $LANG['PRIMARYGEOLAYERTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_PrimaryGeoLayerTypeId" name="Input_PrimaryGeoLayerTypeId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['PRIMARYGEOLAYERNAME'];?></div><div class="fromfield"><input type="text"  id="Input_PrimaryGeoLayerName" name="Input_PrimaryGeoLayerName" value="" class="form_area_textbox"></div></li>
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


