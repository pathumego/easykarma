<?php
require_once("BL/BL_manageVillage_trading.php");

function loadVillage_trading($_GET)
{
global $LANG;
$villageId = isset($_GET["villageid"]) ? $_GET["villageid"] 	 : -1 ;	

if($villageId == -1)
{
	echo "VillageId not found";	
}
 //$BusinessId = isset($_GET["BusinessId"]) ? $_GET["BusinessId"] : (isset($_SESSION["BusinessId"])?$_SESSION["BusinessId"] :1) ;	
//$_SESSION["BusinessId"] = $BusinessId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$BusinessId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_trading\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_trading</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_trading</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_tradingList" class="main_listviewul">
<?php

$result =BL_manageVillage_trading::getVillage_tradingList();

if($result->type ==1)
{
$arr_Village_tradingList = $result->data;
if(count($arr_Village_tradingList)>0)
{
 
 foreach($arr_Village_tradingList as $obj_Village_trading)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_tradingListRow_".$obj_Village_trading->BusinessId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_trading->TradingId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_trading->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_trading->BusinessId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_trading->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_trading_".$obj_Village_trading->BusinessId."\" type = \"hidden\" value=\"".$obj_Village_trading->getVillage_tradingData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_trading found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_trading found... </div>";	
}

?>



</ul>
<div id="popVillage_tradingform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_TRADING'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_tradingform">
<li><div class="label"><?php echo $LANG['TRADINGID'];?></div><div class="fromfield"><input type="text"  id="Input_TradingId" name="Input_TradingId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_VillageId" name="Input_VillageId" value="<?php echo $villageId; ?>" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['BUSINESSID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_BusinessId" name="Input_BusinessId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_BusinessId" name="Dummy_Input_BusinessId" value="" class="form_area_textbox">
</div></li>
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


