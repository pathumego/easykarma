<?php

require_once("BL/BL_manageUser.php");
require_once("BL/BL_manageVillage.php");

function loadVillageDashboard($_GET)
{
global $LANG;
$villageid = isset($_GET["villageid"]) ? $_GET["villageid"] : -1 ;	

if($villageid == -1)
{
	echo "PersonId not found";	
	exit();

}
$result =BL_manageVillage::getVillageListByVillageId($villageid);

if($result->type ==1)
{
$obj_Village = $result->data[0];
echo "<h3 class=\"dashboardtopic\">".$obj_Village->Name."</h3>";
echo "<h5 class=\"dashboardtopic_sub\">".$obj_Village->District."</h5>";
}
?>

<div class="common_body_content clearfix" >
<div class="home_main_content_outer">
<div class="common_block">
<ul>

<?php						


echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village&villageid=".$villageid."\">".$LANG['VILLAGE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_agriculture&villageid=".$villageid."\">".$LANG['VILLAGE_AGRICULTURE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_climate&villageid=".$villageid."\">".$LANG['VILLAGE_CLIMATE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_enterance&villageid=".$villageid."\">".$LANG['VILLAGE_ENTERANCE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_geologicalvariation&villageid=".$villageid."\">".$LANG['VILLAGE_GEOLOGICALVARIATION']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_group&villageid=".$villageid."\">".$LANG['VILLAGE_GROUP']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_history&villageid=".$villageid."\">".$LANG['VILLAGE_HISTORY']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_image&villageid=".$villageid."\">".$LANG['VILLAGE_IMAGE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_industrial&villageid=".$villageid."\">".$LANG['VILLAGE_INDUSTRIAL']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_neartowns&villageid=".$villageid."\">".$LANG['VILLAGE_NEARTOWNS']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_organization&villageid=".$villageid."\">".$LANG['VILLAGE_ORGANIZATION']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_othernames&villageid=".$villageid."\">".$LANG['VILLAGE_OTHERNAMES']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_plant&villageid=".$villageid."\">".$LANG['VILLAGE_PLANT']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_service&villageid=".$villageid."\">".$LANG['VILLAGE_SERVICE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_society&villageid=".$villageid."\">".$LANG['VILLAGE_SOCIETY']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_trading&villageid=".$villageid."\">".$LANG['VILLAGE_TRADING']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_traditionalknowledge&villageid=".$villageid."\">".$LANG['VILLAGE_TRADITIONALKNOLEDGE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village_transport&villageid=".$villageid."\">".$LANG['VILLAGE_TRANSPORT']."</a></li>";

					
?>	
</ul>					
</div>
</div>
</div>
<?php 
}

?>