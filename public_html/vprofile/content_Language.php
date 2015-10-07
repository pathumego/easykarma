<?php
require_once("BL/BL_manageLanguage.php");

function loadLanguage($_GET)
{
global $LANG;
 //$LangId = isset($_GET["LangId"]) ? $_GET["LangId"] : (isset($_SESSION["LangId"])?$_SESSION["LangId"] :1) ;	
//$_SESSION["LangId"] = $LangId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$LangId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddLanguage\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Language</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Language</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="LanguageList" class="main_listviewul">
<?php

$result =BL_manageLanguage::getLanguageList();

if($result->type ==1)
{
$arr_LanguageList = $result->data;
if(count($arr_LanguageList)>0)
{
 
 foreach($arr_LanguageList as $obj_Language)
 {

 		$html = "<li class=\"ListRow\" id=\"LanguageListRow_".$obj_Language->LangId."\">";
		$html .= "<div class=\"datarow\">".$obj_Language->LangId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Language->LangTag."</div>";
		$html .= "<div class=\"datarow\">".$obj_Language->English."</div>";
		$html .= "<div class=\"datarow\">".$obj_Language->Sinhala."</div>";
		$html .= "<div class=\"datarow\">".$obj_Language->Tamil."</div>";
		$html .= "<div class=\"datarow\">".$obj_Language->Bangla."</div>";
		$html .= "<div class=\"datarow\">".$obj_Language->Nepali."</div>";
		$html .= "<div class=\"datarow\">".$obj_Language->Lang1."</div>";
		$html .= "<div class=\"datarow\">".$obj_Language->Lang2."</div>";
		$html .= "<div class=\"datarow\">".$obj_Language->Lang3."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Language_".$obj_Language->LangId."\" type = \"hidden\" value=\"".$obj_Language->getLanguageData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Language found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Language found... </div>";	
}

?>



</ul>
<div id="popLanguageform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_LANGUAGE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Languageform">
<li><div class="label">LangId</div><div class="fromfield"><input type="text"  id="Input_LangId" name="Input_LangId" value="" class="form_area_textbox"></div></li>
<li><div class="label">LangTag</div><div class="fromfield"><input type="text"  id="Input_LangTag" name="Input_LangTag" value="" class="form_area_textbox"></div></li>
<li><div class="label">English</div><div class="fromfield"><input type="text"  id="Input_English" name="Input_English" value="" class="form_area_textbox"></div></li>
<li><div class="label">Sinhala</div><div class="fromfield"><input type="text"  id="Input_Sinhala" name="Input_Sinhala" value="" class="form_area_textbox"></div></li>
<li><div class="label">Tamil</div><div class="fromfield"><input type="text"  id="Input_Tamil" name="Input_Tamil" value="" class="form_area_textbox"></div></li>
<li><div class="label">Bangla</div><div class="fromfield"><input type="text"  id="Input_Bangla" name="Input_Bangla" value="" class="form_area_textbox"></div></li>
<li><div class="label">Nepali</div><div class="fromfield"><input type="text"  id="Input_Nepali" name="Input_Nepali" value="" class="form_area_textbox"></div></li>
<li><div class="label">Lang1</div><div class="fromfield"><input type="text"  id="Input_Lang1" name="Input_Lang1" value="" class="form_area_textbox"></div></li>
<li><div class="label">Lang2</div><div class="fromfield"><input type="text"  id="Input_Lang2" name="Input_Lang2" value="" class="form_area_textbox"></div></li>
<li><div class="label">Lang3</div><div class="fromfield"><input type="text"  id="Input_Lang3" name="Input_Lang3" value="" class="form_area_textbox"></div></li>
     
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