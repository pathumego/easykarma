<?php
require_once("BL/BL_managePlants.php");

function loadPlants($_GET)
{
global $LANG;
 //$PlantId = isset($_GET["PlantId"]) ? $_GET["PlantId"] : (isset($_SESSION["PlantId"])?$_SESSION["PlantId"] :1) ;	
//$_SESSION["PlantId"] = $PlantId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$PlantId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPlants\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Plants</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Plants</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="PlantsList" class="main_listviewul">
<?php

$result =BL_managePlants::getPlantsList();

if($result->type ==1)
{
$arr_PlantsList = $result->data;
if(count($arr_PlantsList)>0)
{
 
 foreach($arr_PlantsList as $obj_Plants)
 {

 		$html = "<li class=\"ListRow\" id=\"PlantsListRow_".$obj_Plants->PlantId."\">";
		$html .= "<div class=\"datarow\">".$obj_Plants->PlantId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Plants->Name."</div>";
		$html .= "<div class=\"datarow\">".$obj_Plants->Description."</div>";
		$html .= "<div class=\"datarow\">".$obj_Plants->BioName."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Plants_".$obj_Plants->PlantId."\" type = \"hidden\" value=\"".$obj_Plants->getPlantsData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Plants found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Plants found... </div>";	
}

?>



</ul>
<div id="popPlantsform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_PLANT'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Plantsform">
<li><div class="label"><?php echo $LANG['PLANTID'];?></div><div class="fromfield"><input type="text"  id="Input_PlantId" name="Input_PlantId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NAME'];?></div><div class="fromfield"><input type="text"  id="Input_Name" name="Input_Name" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_Description" name="Input_Description" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['BIONAME'];?></div><div class="fromfield"><input type="text"  id="Input_BioName" name="Input_BioName" value="" class="form_area_textbox"></div></li>
     
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


