<?php
require_once("BL/BL_manageIndustrial.php");

function loadIndustrial($_GET)
{
global $LANG;
 //$IndustrialId = isset($_GET["IndustrialId"]) ? $_GET["IndustrialId"] : (isset($_SESSION["IndustrialId"])?$_SESSION["IndustrialId"] :1) ;	
//$_SESSION["IndustrialId"] = $IndustrialId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$IndustrialId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddIndustrial\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Industrial</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Industrial</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="IndustrialList" class="main_listviewul">
<?php

$result =BL_manageIndustrial::getIndustrialList();

if($result->type ==1)
{
$arr_IndustrialList = $result->data;
if(count($arr_IndustrialList)>0)
{
 
 foreach($arr_IndustrialList as $obj_Industrial)
 {

 		$html = "<li class=\"ListRow\" id=\"IndustrialListRow_".$obj_Industrial->IndustrialId."\">";
		$html .= "<div class=\"datarow\">".$obj_Industrial->IndustrialId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Industrial->IndustrialName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Industrial->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Industrial_".$obj_Industrial->IndustrialId."\" type = \"hidden\" value=\"".$obj_Industrial->getIndustrialData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Industrial found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Industrial found... </div>";	
}

?>



</ul>
<div id="popIndustrialform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_INDUSTRIAL'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Industrialform">
<li><div class="label"><?php echo $LANG['INDUSTRIALID'];?></div><div class="fromfield"><input type="text"  id="Input_IndustrialId" name="Input_IndustrialId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['INDUSTRIALNAME'];?></div><div class="fromfield"><input type="text"  id="Input_IndustrialName" name="Input_IndustrialName" value="" class="form_area_textbox"></div></li>
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


