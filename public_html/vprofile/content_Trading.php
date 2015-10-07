<?php
require_once("BL/BL_manageTrading.php");

function loadTrading($_GET)
{
global $LANG;
 //$tradingId = isset($_GET["tradingId"]) ? $_GET["tradingId"] : (isset($_SESSION["tradingId"])?$_SESSION["tradingId"] :1) ;	
//$_SESSION["tradingId"] = $tradingId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$tradingId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddTrading\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Trading</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Trading</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="TradingList" class="main_listviewul">
<?php

$result =BL_manageTrading::getTradingList();

if($result->type ==1)
{
$arr_TradingList = $result->data;
if(count($arr_TradingList)>0)
{
 
 foreach($arr_TradingList as $obj_Trading)
 {

 		$html = "<li class=\"ListRow\" id=\"TradingListRow_".$obj_Trading->tradingId."\">";
		$html .= "<div class=\"datarow\">".$obj_Trading->tradingId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Trading->tradingName."</div>";
		$html .= "<div class=\"datarow\">".$obj_Trading->tradingType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Trading->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Trading_".$obj_Trading->tradingId."\" type = \"hidden\" value=\"".$obj_Trading->getTradingData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Trading found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Trading found... </div>";	
}

?>



</ul>
<div id="popTradingform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_TRADING'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Tradingform">
<li><div class="label"><?php echo $LANG['TRADINGID'];?></div><div class="fromfield"><input type="text"  id="Input_tradingId" name="Input_tradingId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TRADINGNAME'];?></div><div class="fromfield"><input type="text"  id="Input_tradingName" name="Input_tradingName" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['TRADINGTYPE'];?></div><div class="fromfield"><input type="text"  id="Input_tradingType" name="Input_tradingType" value="" class="form_area_textbox"></div></li>
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


