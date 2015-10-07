<?php
require_once("BL/BL_manageSociety.php");

function loadSociety($_GET)
{
global $LANG;
$societyid = isset($_GET["societyid"] 	) ? $_GET["societyid"] 	 : -1 ;	
if($societyid == -1)
{
	echo "Societyid not found";	

}
 //$SocietyId = isset($_GET["SocietyId"]) ? $_GET["SocietyId"] : (isset($_SESSION["SocietyId"])?$_SESSION["SocietyId"] :1) ;	
//$_SESSION["SocietyId"] = $SocietyId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$SocietyId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddSociety\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Society</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Society</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="SocietyList" class="main_listviewul">
<?php

$result =BL_manageSociety::getSocietyList();

if($result->type ==1)
{
$arr_SocietyList = $result->data;
if(count($arr_SocietyList)>0)
{
 
 foreach($arr_SocietyList as $obj_Society)
 {

 		$html = "<li class=\"ListRow\" id=\"SocietyListRow_".$obj_Society->SocietyId."\">";
		$html .= "<div class=\"datarow\">".$obj_Society->SocietyId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Society->Name."</div>";
		$html .= "<div class=\"datarow\">".$obj_Society->Description."</div>";
		$html .= "<div class=\"datarow\">".$obj_Society->Mission."</div>";
		$html .= "<div class=\"datarow\">".$obj_Society->SocietyTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Society->SocietyAddress."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<div class=\"databtncell\"><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Society_member&societyid=".$obj_Society->SocietyId."\" class=\"rowbtn\">Members</a></div>";
		$html .= "<input id=\"Society_".$obj_Society->SocietyId."\" type = \"hidden\" value=\"".$obj_Society->getSocietyData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Society found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Society found... </div>";	
}

?>



</ul>
<div id="popSocietyform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_SOCIETY'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Societyform">
<li><div class="label"><?php echo $LANG['SOCIETYID'];?></div><div class="fromfield"><input type="text"  id="Input_SocietyId" name="Input_SocietyId" value="<?php echo $societyid; ?>" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NAME'];?></div><div class="fromfield"><input type="text"  id="Input_Name" name="Input_Name" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_Description" name="Input_Description" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['MISSION'];?></div><div class="fromfield"><input type="text"  id="Input_Mission" name="Input_Mission" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['SOCIETYTYPEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_SocietyTypeId" name="Input_SocietyTypeId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_SocietyTypeId" name="Dummy_SocietyTypeId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['SOCIETYADRESS'];?></div><div class="fromfield"><input type="text"  id="Input_SocietyAddress" name="Input_SocietyAddress" value="" class="form_area_textbox"></div></li>
     
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


