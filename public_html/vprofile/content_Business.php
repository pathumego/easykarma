<?php
require_once("BL/BL_manageBusiness.php");

function loadBusiness($_GET)
{
global $LANG;
 //$BusinessId = isset($_GET["BusinessId"]) ? $_GET["BusinessId"] : (isset($_SESSION["BusinessId"])?$_SESSION["BusinessId"] :1) ;	
//$_SESSION["BusinessId"] = $BusinessId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$BusinessId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddBusiness\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Business</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Business</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="BusinessList" class="main_listviewul">
<?php

$result =BL_manageBusiness::getBusinessList();

if($result->type ==1)
{
$arr_BusinessList = $result->data;
if(count($arr_BusinessList)>0)
{
 
 foreach($arr_BusinessList as $obj_Business)
 {

 		$html = "<li class=\"ListRow\" id=\"BusinessListRow_".$obj_Business->BusinessId."\">";
		$html .= "<div class=\"datarow\">".$obj_Business->BusinessId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Business->Name."</div>";
		$html .= "<div class=\"datarow\">".$obj_Business->Description."</div>";
		$html .= "<div class=\"datarow\">".$obj_Business->Address."</div>";
		$html .= "<div class=\"datarow\">".$obj_Business->telephone."</div>";
		$html .= "<div class=\"datarow\">".$obj_Business->fax."</div>";
		$html .= "<div class=\"datarow\">".$obj_Business->website."</div>";
		$html .= "<div class=\"datarow\">".$obj_Business->email."</div>";
		$html .= "<div class=\"datarow\">".$obj_Business->BusinessTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Business->BusinessSubTypeId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Business_".$obj_Business->BusinessId."\" type = \"hidden\" value=\"".$obj_Business->getBusinessData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Business found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Business found... </div>";	
}

?>



</ul>
<div id="popBusinessform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_BUSINESS_FORM'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Businessform">
<li><div class="label"><?php echo $LANG['BUSINESSID'];?></div><div class="fromfield"><input type="text"  id="Input_BusinessId" name="Input_BusinessId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['NAME'];?></div><div class="fromfield"><input type="text"  id="Input_Name" name="Input_Name" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['DESCRIPTION'];?></div><div class="fromfield"><input type="text"  id="Input_Description" name="Input_Description" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ADRESS'];?></div><div class="fromfield"><input type="text"  id="Input_Address" name="Input_Address" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TELEPHONE'];?></div><div class="fromfield"><input type="text"  id="Input_telephone" name="Input_telephone" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['FAX'];?></div><div class="fromfield"><input type="text"  id="Input_fax" name="Input_fax" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['WEBSITE'];?></div><div class="fromfield"><input type="text"  id="Input_website" name="Input_website" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['EMAIL'];?></div><div class="fromfield"><input type="text"  id="Input_email" name="Input_email" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['BUSINESSTYPEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_BusinessTypeId" name="Input_BusinessTypeId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_BusinessTypeId" name="Dummy_Input_BusinessTypeId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['BUSINESSSUBTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_BusinessSubTypeId" name="Input_BusinessSubTypeId" value="" class="form_area_textbox"></div></li>
  
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


