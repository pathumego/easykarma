<?php
require_once("BL/BL_manageVillage_traditionalknowledge.php");

function loadVillage_traditionalknowledge($_GET)
{
global $LANG;
$villageId = isset($_GET["villageid"]) ? $_GET["villageid"] 	 : -1 ;	

if($villageId == -1)
{
	echo "VillageId not found";	
}
 //$TblId = isset($_GET["TblId"]) ? $_GET["TblId"] : (isset($_SESSION["TblId"])?$_SESSION["TblId"] :1) ;	
//$_SESSION["TblId"] = $TblId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$TblId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_traditionalknowledge\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_traditionalknowledge</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_traditionalknowledge</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_traditionalknowledgeList" class="main_listviewul">
<?php

$result =BL_manageVillage_traditionalknowledge::getVillage_traditionalknowledgeList();

if($result->type ==1)
{
$arr_Village_traditionalknowledgeList = $result->data;
if(count($arr_Village_traditionalknowledgeList)>0)
{
 
 foreach($arr_Village_traditionalknowledgeList as $obj_Village_traditionalknowledge)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_traditionalknowledgeListRow_".$obj_Village_traditionalknowledge->TblId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_traditionalknowledge->TblId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_traditionalknowledge->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_traditionalknowledge->TraditionalKnowledgeCategoryID."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_traditionalknowledge->Discription."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_traditionalknowledge_".$obj_Village_traditionalknowledge->TblId."\" type = \"hidden\" value=\"".$obj_Village_traditionalknowledge->getVillage_traditionalknowledgeData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_traditionalknowledge found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_traditionalknowledge found... </div>";	
}

?>



</ul>
<div id="popVillage_traditionalknowledgeform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_TRADITIONAL_KNOWLADGE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_traditionalknowledgeform">
<li><div class="label"><?php echo $LANG['TBLID'];?></div><div class="fromfield"><input type="text"  id="Input_TblId" name="Input_TblId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_VillageId" name="Input_VillageId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['TRADITIONALKNOWLEDGECATEGORYID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_TraditionalKnowledgeCategoryID" name="Input_TraditionalKnowledgeCategoryID" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_TraditionalKnowledgeCategoryID" name="Dummy_Input_TraditionalKnowledgeCategoryID" value="" class="form_area_textbox">

</div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_Discription" name="Input_Discription" value="" class="form_area_textbox"></div></li>
     
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


