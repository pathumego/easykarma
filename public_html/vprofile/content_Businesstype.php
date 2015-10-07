<?php
require_once("BL/BL_manageBusinesstype.php");

function loadBusinesstype($_GET)
{
global $LANG;
 //$BusinessTypeId = isset($_GET["BusinessTypeId"]) ? $_GET["BusinessTypeId"] : (isset($_SESSION["BusinessTypeId"])?$_SESSION["BusinessTypeId"] :1) ;	
//$_SESSION["BusinessTypeId"] = $BusinessTypeId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$BusinessTypeId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddBusinesstype\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Businesstype</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Businesstype</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="BusinesstypeList" class="main_listviewul">
<?php

$result =BL_manageBusinesstype::getBusinesstypeList();

if($result->type ==1)
{
$arr_BusinesstypeList = $result->data;
if(count($arr_BusinesstypeList)>0)
{
 
 foreach($arr_BusinesstypeList as $obj_Businesstype)
 {

 		$html = "<li class=\"ListRow\" id=\"BusinesstypeListRow_".$obj_Businesstype->BusinessTypeId."\">";
		$html .= "<div class=\"datarow\">".$obj_Businesstype->BusinessTypeId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Businesstype->BusinessTypeName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Businesstype->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Businesstype_".$obj_Businesstype->BusinessTypeId."\" type = \"hidden\" value=\"".$obj_Businesstype->getBusinesstypeData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Businesstype found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Businesstype found... </div>";	
}

?>



</ul>
<div id="popBusinesstypeform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_BUSINESS_TYPE_FORM'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Businesstypeform">
<li><div class="label"><?php echo $LANG['BUSINESSTYPEID'];?></div><div class="fromfield"><input type="text"  id="Input_BusinessTypeId" name="Input_BusinessTypeId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['BUSINESSTYPENAME'];?></div><div class="fromfield"><input type="text"  id="Input_BusinessTypeName" name="Input_BusinessTypeName" value="" class="form_area_textbox"></div></li>
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


