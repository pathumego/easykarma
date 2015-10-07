<?php
require_once("BL/BL_manageTransport.php");

function loadTransport($_GET)
{
global $LANG;
 //$TransportId = isset($_GET["TransportId"]) ? $_GET["TransportId"] : (isset($_SESSION["TransportId"])?$_SESSION["TransportId"] :1) ;	
//$_SESSION["TransportId"] = $TransportId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$TransportId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddTransport\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Transport</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Transport</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="TransportList" class="main_listviewul">
<?php

$result =BL_manageTransport::getTransportList();

if($result->type ==1)
{
$arr_TransportList = $result->data;
if(count($arr_TransportList)>0)
{
 
 foreach($arr_TransportList as $obj_Transport)
 {

 		$html = "<li class=\"ListRow\" id=\"TransportListRow_".$obj_Transport->TransportId."\">";
		$html .= "<div class=\"datarow\">".$obj_Transport->TransportId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Transport->TransportName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Transport->TransportType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Transport->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Transport_".$obj_Transport->TransportId."\" type = \"hidden\" value=\"".$obj_Transport->getTransportData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Transport found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Transport found... </div>";	
}

?>



</ul>
<div id="popTransportform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_TRANSPORT'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Transportform">
<li><div class="label"><?php echo $LANG['TRANSPORTID'];?></div><div class="fromfield"><input type="text"  id="Input_TransportId" name="Input_TransportId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TRANSPORTNAME'];?></div><div class="fromfield"><input type="text"  id="Input_TransportName" name="Input_TransportName" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TRANSPORTTYPE'];?></div><div class="fromfield"><input type="text"  id="Input_TransportType" name="Input_TransportType" value="" class="form_area_textbox"></div></li>
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


