<?php
require_once("BL/BL_manageVillage_image.php");

function loadVillage_image($_GET)
{
global $LANG;
$villageId = isset($_GET["villageid"]) ? $_GET["villageid"] 	 : -1 ;	

if($villageId == -1)
{
	echo "VillageId not found";	
}
 //$PictureId = isset($_GET["PictureId"]) ? $_GET["PictureId"] : (isset($_SESSION["PictureId"])?$_SESSION["PictureId"] :1) ;	
//$_SESSION["PictureId"] = $PictureId;			

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$PictureId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddVillage_image\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Village_image</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user">Manage Village_image</div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Village_imageList" class="main_listviewul">
<?php

$result =BL_manageVillage_image::getVillage_imageList();

if($result->type ==1)
{
$arr_Village_imageList = $result->data;
if(count($arr_Village_imageList)>0)
{
 
 foreach($arr_Village_imageList as $obj_Village_image)
 {

 		$html = "<li class=\"ListRow\" id=\"Village_imageListRow_".$obj_Village_image->PictureId."\">";
		$html .= "<div class=\"datarow\">".$obj_Village_image->PictureId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_image->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_image->PicturePath."</div>";
		$html .= "<div class=\"datarow\">".$obj_Village_image->Description."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Village_image_".$obj_Village_image->PictureId."\" type = \"hidden\" value=\"".$obj_Village_image->getVillage_imageData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Village_image found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Village_image found... </div>";	
}

?>



</ul>
<div id="popVillage_imageform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_VILLAGE_IMAGE'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Village_imageform">
<li><div class="label"><?php echo $LANG['PICTUREID'];?></div><div class="fromfield"><input type="text"  id="Input_PictureId" name="Input_PictureId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_VillageId" name="Input_VillageId" value="<?php echo $villageId; ?>" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['PICTUREPARTH'];?></div><div class="fromfield"><input type="text"  id="Input_PicturePath" name="Input_PicturePath" value="" class="form_area_textbox"></div></li>
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


