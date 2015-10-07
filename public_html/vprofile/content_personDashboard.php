<?php
require_once("BL/BL_manageUser.php");
require_once("BL/BL_managePerson.php");

function loadPersonDashboard($_GET)
{

global $LANG;
$personid = isset($_GET["personid"]) ? $_GET["personid"] : -1 ;	

if($personid == -1)
{
	echo "PersonId not found";	
exit();
}

$result =BL_managePerson::getPersonListByPersonId($personid);

if($result->type ==1)
{
$obj_Person = $result->data[0];
echo "<h3 class=\"dashboardtopic\">".$obj_Person->FullName."</h3>";
echo "<h5 class=\"dashboardtopic_sub\">".$obj_Person->Email."</h5>";
}

?>

<div class="common_body_content clearfix" >
<div class="home_main_content_outer">
<div class="common_block">
<ul>

<?php						


echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person&personid=".$personid."\">".$LANG['PERSON']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_address&personid=".$personid."\">".$LANG['PERSON_ADRESS']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_alresult&personid=".$personid."\">".$LANG['PERSON_ALRESULT']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_educationlevel&personid=".$personid."\">".$LANG['PERSON_EDUCATIONLEVEL']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_highereducation&personid=".$personid."\">".$LANG['PERSON_HIGHEREDUCATION']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_languageskill&personid=".$personid."\">".$LANG['PERSON_LANGUAGESKILL']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_olresult&personid=".$personid."\">".$LANG['PERSON_OLRESULT']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_property&personid=".$personid."\">".$LANG['PERSON_PROPERTY']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_talent&personid=".$personid."\">".$LANG['PERSON_TALENT']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_telephone&personid=".$personid."\">".$LANG['PERSON_TELEPHONE']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_vocationaltraining&personid=".$personid."\">".$LANG['PERSON_VOCATIONALTRAINING']."</a></li>";
echo "<li><a href=\"".$_SERVER['SCRIPT_NAME']."?page=Person_workingexperiance&personid=".$personid."\">".$LANG['PERSON_WORKINGEXPERIANCE']."</a></li>";

					
?>	
</ul>					
</div>
</div>
</div>
<?php 

}

?>