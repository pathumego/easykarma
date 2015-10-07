<?php

require_once("BL/BL_manageUser.php");

function loadDashboard($_GET)
{
global $LANG;
?>

<div class="common_body_content clearfix" >
<div class="home_main_content_outer">
<div class="common_block">
<ul>

<?php						
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person\">".$LANG['PERSON']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Village\"> ".$LANG['VILLAGE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Language\">".$LANG['LANGUAGE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Agriculture\">".$LANG['AGRICULTURE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Alsubjects\"> ".$LANG['ALSUBJECTS']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Business\">".$LANG['BUSINESS']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Business_product\">".$LANG['BUSINESS_PRODUCT']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Businesstype\">".$LANG['BUSINESSTYPE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Foresttype\">".$LANG['FORESTTYPE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Geographytype\">".$LANG['GEOGRAPHYTYPE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Group\">".$LANG['GROUP']."</a></li>";
//echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Group_member\">".$LANG['GROUP_MEMBER']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Groupmissiontype\">".$LANG['GROUPMISSIONTYPE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Higherstudysubjects\">".$LANG['HIGHERSTUDYSUBJECTS']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Industrial\">".$LANG['INDUSTRIAL']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Location\">".$LANG['LOCATION']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Location_resources\">".$LANG['LOCATION_RESOURCES']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Olsubjects\">".$LANG['OLSUBJECTS']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Organization\">".$LANG['ORGANIZATION']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Organization_subtype\">".$LANG['ORGANIZATION_SUBTYPE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Organizationtype\">".$LANG['ORGANIZATIONTYPE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Plants\">".$LANG['PLANTS']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Primarygeolayertype\">".$LANG['PRIMARYGEOLAYERTYPE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Product\">".$LANG['PRODUCT']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Service\">".$LANG['SERVICE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Socierytype\">".$LANG['SOCIERYTYPE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Society\">".$LANG['SOCIETY']."</a></li>";
//echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Society_member\">".$LANG['SOCIETY_MEMBER']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Soiltype\">".$LANG['SOILTYPE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Talent\">".$LANG['TALENT']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Town\">".$LANG['TOWN']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Trading\">".$LANG['TRADING']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Traditionalknowledgecategory\">".$LANG['TRADITIONALKNOWLEDGECATEGORY']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Transport\">".$LANG['TRANSPORT']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=User\">".$LANG['USER']."</a></li>";

					
?>	
</ul>					
</div>
</div>
</div>
<?php 
}

?>