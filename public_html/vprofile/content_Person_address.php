<?php
require_once("BL/BL_managePerson_address.php");
require_once("config.php");

function loadPerson_address($_GET)
{
global $LANG;
$PersonId = isset($_GET["personid"] 	) ? $_GET["personid"] 	 : -1 ;	

if($PersonId == -1)
{
	echo "PersonId not found";	
}
		

?>
<div class="common_button2">
<ul>
	<?php
	//if(common::checkPermission(USERMANAGE_ADDUSER_ACTIONID_VIEW,$AddressId))
	//	{	
		echo "<li class=\"btnleft\"><a href=\"?page=Dashboard\" id=\"btnback\"><div class=\"doublearrow\">&laquo;</div>&nbsp;BACK</a></li>";
  		echo "<li class=\"btnright\"><a id=\"btnaddPerson_address\" href=\"#\"><div class=\"doublearrow\">+</div>ADD Person_address</a></li>";
	//	}
	?>
</ul>
</div>
<div class="common_body_content clearfix" >
<div class="main_content_outer">
<div class="main_content">
<div class="content_header">
<div class="title_user"><?PHP echo $LANG['TITLE_PERSON_ADRESS'];?></div>
<div class="title_searchbox"><input id="searchtextbox" class="searchtextbox" type="text" value="Search here..."></div>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%"><tr><td>
<div class="main_listview">

<ul id="Person_addressList" class="main_listviewul">
<?php

$result =BL_managePerson_address::getPerson_addressListByPersonId($PersonId);

if($result->type ==1)
{
$arr_Person_addressList = $result->data;
if(count($arr_Person_addressList)>0)
{
 
 foreach($arr_Person_addressList as $obj_Person_address)
 {

 		$html = "<li class=\"ListRow\" id=\"Person_addressListRow_".$obj_Person_address->AddressId."\">";
		$html .= "<div class=\"datarow\">".$obj_Person_address->AddressId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_address->Address."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_address->AddressType."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_address->VillageId."</div>";
		$html .= "<div class=\"datarow\">".$obj_Person_address->PersonId."</div>";
	  
		$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Edit</a></div>";
	  	$html .= "<div class=\"databtncell\"><a href=\"#\" class=\"rowbtn\">Delete</a></div>";
		$html .= "<input id=\"Person_address_".$obj_Person_address->AddressId."\" type = \"hidden\" value=\"".$obj_Person_address->getPerson_addressData()."\"></li>";
			
		echo $html;
 }
}
echo "<div id=\"contentError\" class=\"contenterror_hidden\">No Person_address found... </div>";	
}
else{
echo "<div id=\"contentError\" class=\"contenterror\">No Person_address found... </div>";	
}

?>



</ul>
<div id="popPerson_addressform" class="formPopup">
<div class="subheader"><?PHP echo $LANG['SUBHEADER_PERSON_ADRESS_FORM'];?></div>
<div class="formerror" id="formerror"></div>
<input type="hidden" id="FormMode" name="FormMode" value="add" >
<ul class="Person_addressform">
<li><div class="label"><?php echo $LANG['ADRESSID'];?></div><div class="fromfield"><input type="text"  id="Input_AddressId" name="Input_AddressId" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ADRESS'];?></div><div class="fromfield"><input type="text"  id="Input_Address" name="Input_Address" value="" class="form_area_textbox"></div></li>
<li><div class="label"><?php echo $LANG['ADRESSTYPE'];?></div><div class="fromfield">
<select  id="Input_AddressType" name="Input_AddressType" value="" class="form_area_dropdown">
<?php

$arr =config::dropdown_person_addresstype();
if(count($arr)>0)
{
$html = ""; 
 foreach($arr as $drpindex=>$drpitem)
 {
		$html .= "<option value=\"".$drpindex."\">";
		$html .= $drpitem;
		$html .= "</option>";
 }
echo $html;
}
else{
echo "<option>Please Select</option>";	
}
?>	</select>

</div></li>
<li><div class="label"><?php echo $LANG['VILLAGEID'];?></div><div class="fromfield">
<input type="hidden"  id="Input_VillageId" name="Input_VillageId" value="" class="form_area_textbox">
<input type="text"  id="Dummy_Input_VillageId" name="Dummy_Input_VillageId" value="" class="form_area_textbox">
</div></li>
<li><div class="label"><?php echo $LANG['PERSONID'];?></div><div class="fromfield"><input type="hidden"  id="Input_PersonId" name="Input_PersonId" value="<?php echo $PersonId; ?>" class="form_area_textbox"></div></li>
     
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