<?php
require_once("BL/BL_manageTown.php");

function loadTown($_GET)
{
global $LANG;
 //$TownId = isset($_GET["TownId"]) ? $_GET["TownId"] : (isset($_SESSION["TownId"])?$_SESSION["TownId"] :1) ;	
//$_SESSION["TownId"] = $TownId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$TownId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddTown\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Town</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Town</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="TownList" class="main_listviewul">
<?php

$result =BL_manageTown::getTownList();

if($result->type ==1)
{
$arr_TownList = $result->data;
if(count($arr_TownList)>0)
{
 
 foreach($arr_TownList as $obj_Town)
 {

 		$html = "<li class=\"ListRow\" id=\"TownListRow_".$obj_Town->TownId."\">";
		$html .= "<div class=\"datarow\">".$obj_Town->TownId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Town->TownName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Town->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Town_".$obj_Town->TownId."\" type = \"hidden\" value=\"".$obj_Town->getTownData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Town found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Town found... </div>";	
}

?>



</ul>
<div id="popTownform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_TOWN'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Townform">
<li><div class="label"><?php echo $LANG['TOWNID'];?></div><div class="fromfield"><input type="text"  id="Input_TownId" name="Input_TownId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TOWNNAME'];?></div><div class="fromfield"><input type="text"  id="Input_TownName" name="Input_TownName" value="" class="form_area_textbox"></div></li>
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


