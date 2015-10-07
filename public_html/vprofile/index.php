<?php
ini_set("display_errors","Off");
session_start();
session_register("login");
session_register("user");
session_register("lang");

//ini_set("error_reporting","E_ALL & ~E_NOTICE | E_STRICT");

//require_once ("content_Dashboard.php");
//require_once ("content_Dashboard.php");
//require_once ("content_Login.php");
require_once ("content_Loadbasis.php");

require_once ("content_Dashboard.php");
require_once ("include/common.php");
require_once ("content_Agriculture.php");
require_once ("content_Alsubjects.php");
require_once ("content_Business.php");
require_once ("content_Business_product.php");
require_once ("content_Businesstype.php");
require_once ("content_Foresttype.php");
require_once ("content_Geographytype.php");
require_once ("content_Group.php");
require_once ("content_Group_member.php");
require_once ("content_Groupmissiontype.php");
require_once ("content_Higherstudysubjects.php");
require_once ("content_Industrial.php");
require_once ("content_Location.php");
require_once ("content_Location_resources.php");
require_once ("content_Olsubjects.php");
require_once ("content_Organization.php");
require_once ("content_Organization_subtype.php");
require_once ("content_Organizationtype.php");
require_once ("content_Person.php");
require_once ("content_Person_address.php");
require_once ("content_Person_alresult.php");
require_once ("content_Person_educationlevel.php");
require_once ("content_Person_highereducation.php");
require_once ("content_Person_languageskill.php");
require_once ("content_Person_olresult.php");
require_once ("content_Person_property.php");
require_once ("content_Person_talent.php");
require_once ("content_Person_telephone.php");
require_once ("content_Person_vocationaltraining.php");
require_once ("content_Person_workingexperiance.php");
require_once ("content_Plants.php");
require_once ("content_Primarygeolayertype.php");
require_once ("content_Product.php");
require_once ("content_Service.php");
require_once ("content_Socierytype.php");
require_once ("content_Society.php");
require_once ("content_Society_member.php");
require_once ("content_Soiltype.php");
require_once ("content_Talent.php");
require_once ("content_Town.php");
require_once ("content_Trading.php");
require_once ("content_Traditionalknowledgecategory.php");
require_once ("content_Transport.php");
require_once ("content_User.php");
require_once ("content_Village.php");
require_once ("content_Village_agriculture.php");
require_once ("content_Village_climate.php");
require_once ("content_Village_enterance.php");
require_once ("content_Village_geologicalvariation.php");
require_once ("content_Village_group.php");
require_once ("content_Village_history.php");
require_once ("content_Village_image.php");
require_once ("content_Village_industrial.php");
require_once ("content_Village_neartowns.php");
require_once ("content_Village_organization.php");
require_once ("content_Village_othernames.php");
require_once ("content_Village_plant.php");
require_once ("content_Village_service.php");
require_once ("content_Village_society.php");
require_once ("content_Village_trading.php");
require_once ("content_Village_traditionalknowledge.php");
require_once ("content_Village_transport.php");
require_once ("content_Login.php");
require_once ("system_login.php");
require_once ("content_personDashboard.php");
require_once ("content_villageDashboard.php");

require_once ("content_Language.php");
require_once ("BL/BL_manageLanguage.php");

if ( isset ($_GET["page"]) || !is_null($_GET["page"]))
{
    $reqPage = $_GET["page"];
}
else
{
    $reqPage = $_SESSION["currentpage"];
}

//---------------------------------------------
/*system login / logout*/
 
if($reqPage == "login")
        { 
		
          login($_POST,$_GET);
		  if ($_SESSION["login"] == 1)
		  {
		   $reqPage = $_SESSION["currentpage"]="dashboard"; 
		  }

        }
		
if($reqPage == "logout")
        { 
          logout($_POST);  
		  $reqPage = "login";
        }		



//---------------------------------------------

$arr_redirectpage = array("help");
  if ($_SESSION["login"] != 1)
    {
    	if(! in_array($reqPage, $arr_redirectpage))
		{
			$reqPage = "login";
		}
				
	}
		
//---------------------------------------------
  //set language
 global $LANG;
 $LANG= array();
 $reqlanguage = "English";
 if ( isset ($_GET["lang"]) || !is_null($_GET["lang"]))
{
$_SESSION["lang"] = $reqlanguage = $_GET["lang"];
}
else if($_SESSION["lang"] !="")
{
$reqlanguage = $_SESSION["lang"];
}

$LANG = BL_manageLanguage::getLanguageListByName($reqlanguage);

$arrFilesForLoad = array ();
switch($reqPage)
{
    

	case "Agriculture":
		{
			$_SESSION["currentpage"] = "Agriculture";
			$arrScriptFiles = array ("script", "Agriculture.js","manage_Agriculture.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Agriculture.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadAgriculture($_GET,$LANG);
			break;
		}
	case "Alsubjects":
		{
			$_SESSION["currentpage"] = "Alsubjects";
			$arrScriptFiles = array ("script", "Alsubjects.js","manage_Alsubjects.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Alsubjects.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadAlsubjects($_GET);
			break;
		}
	case "Business":
		{
			$_SESSION["currentpage"] = "Business";
			$arrScriptFiles = array ("script", "Business.js","manage_Business.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Business.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadBusiness($_GET);
			break;
		}
	case "Business_product":
		{
			$_SESSION["currentpage"] = "Business_product";
			$arrScriptFiles = array ("script", "Business_product.js","manage_Business_product.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Business_product.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadBusiness_product($_GET);
			break;
		}
	case "Businesstype":
		{
			$_SESSION["currentpage"] = "Businesstype";
			$arrScriptFiles = array ("script", "Businesstype.js","manage_Businesstype.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Businesstype.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadBusinesstype($_GET);
			break;
		}
	case "Foresttype":
		{
			$_SESSION["currentpage"] = "Foresttype";
			$arrScriptFiles = array ("script", "Foresttype.js","manage_Foresttype.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Foresttype.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadForesttype($_GET);
			break;
		}
	case "Geographytype":
		{
			$_SESSION["currentpage"] = "Geographytype";
			$arrScriptFiles = array ("script", "Geographytype.js","manage_Geographytype.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Geographytype.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadGeographytype($_GET);
			break;
		}
	case "Group":
		{
			$_SESSION["currentpage"] = "Group";
			$arrScriptFiles = array ("script", "Group.js","manage_Group.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Group.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadGroup($_GET);
			break;
		}
	case "Group_member":
		{
			$_SESSION["currentpage"] = "Group_member";
			$arrScriptFiles = array ("script", "Group_member.js","manage_Group_member.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Group_member.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadGroup_member($_GET);
			break;
		}
	case "Groupmissiontype":
		{
			$_SESSION["currentpage"] = "Groupmissiontype";
			$arrScriptFiles = array ("script", "Groupmissiontype.js","manage_Groupmissiontype.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Groupmissiontype.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadGroupmissiontype($_GET);
			break;
		}
	case "Higherstudysubjects":
		{
			$_SESSION["currentpage"] = "Higherstudysubjects";
			$arrScriptFiles = array ("script", "Higherstudysubjects.js","manage_Higherstudysubjects.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Higherstudysubjects.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadHigherstudysubjects($_GET);
			break;
		}
	case "Industrial":
		{
			$_SESSION["currentpage"] = "Industrial";
			$arrScriptFiles = array ("script", "Industrial.js","manage_Industrial.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Industrial.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadIndustrial($_GET);
			break;
		}
	case "Location":
		{
			$_SESSION["currentpage"] = "Location";
			$arrScriptFiles = array ("script", "Location.js","manage_Location.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Location.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadLocation($_GET);
			break;
		}
	case "Location_resources":
		{
			$_SESSION["currentpage"] = "Location_resources";
			$arrScriptFiles = array ("script", "Location_resources.js","manage_Location_resources.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Location_resources.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadLocation_resources($_GET);
			break;
		}
	case "Language":
		{
			$_SESSION["currentpage"] = "Language";
			$arrScriptFiles = array ("script", "Language.js","manage_Language.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Language.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadLanguage($_GET);
			break;
		}
	case "Olsubjects":
		{
			$_SESSION["currentpage"] = "Olsubjects";
			$arrScriptFiles = array ("script", "Olsubjects.js","manage_Olsubjects.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Olsubjects.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadOlsubjects($_GET);
			break;
		}
	case "Organization":
		{
			$_SESSION["currentpage"] = "Organization";
			$arrScriptFiles = array ("script", "Organization.js","manage_Organization.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Organization.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadOrganization($_GET);
			break;
		}
	case "Organization_subtype":
		{
			$_SESSION["currentpage"] = "Organization_subtype";
			$arrScriptFiles = array ("script", "Organization_subtype.js","manage_Organization_subtype.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Organization_subtype.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadOrganization_subtype($_GET);
			break;
		}
	case "Organizationtype":
		{
			$_SESSION["currentpage"] = "Organizationtype";
			$arrScriptFiles = array ("script", "Organizationtype.js","manage_Organizationtype.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Organizationtype.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadOrganizationtype($_GET);
			break;
		}
	case "Person":
		{
			$_SESSION["currentpage"] = "Person";
			$arrScriptFiles = array ("script", "Person.js","manage_Person.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson($_GET);
			break;
		}
	case "Person_address":
		{
			$_SESSION["currentpage"] = "Person_address";
			$arrScriptFiles = array ("script", "Person_address.js","manage_Person_address.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_address.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_address($_GET);
			break;
		}
	case "Person_alresult":
		{
			$_SESSION["currentpage"] = "Person_alresult";
			$arrScriptFiles = array ("script", "Person_alresult.js","manage_Person_alresult.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_alresult.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_alresult($_GET);
			break;
		}
	case "Person_educationlevel":
		{
			$_SESSION["currentpage"] = "Person_educationlevel";
			$arrScriptFiles = array ("script", "Person_educationlevel.js","manage_Person_educationlevel.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_educationlevel.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_educationlevel($_GET);
			break;
		}
	case "Person_highereducation":
		{
			$_SESSION["currentpage"] = "Person_highereducation";
			$arrScriptFiles = array ("script", "Person_highereducation.js","manage_Person_highereducation.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_highereducation.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_highereducation($_GET);
			break;
		}
	case "Person_languageskill":
		{
			$_SESSION["currentpage"] = "Person_languageskill";
			$arrScriptFiles = array ("script", "Person_languageskill.js","manage_Person_languageskill.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_languageskill.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_languageskill($_GET);
			break;
		}
	case "Person_olresult":
		{
			$_SESSION["currentpage"] = "Person_olresult";
			$arrScriptFiles = array ("script", "Person_olresult.js","manage_Person_olresult.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_olresult.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_olresult($_GET);
			break;
		}
	case "Person_property":
		{
			$_SESSION["currentpage"] = "Person_property";
			$arrScriptFiles = array ("script", "Person_property.js","manage_Person_property.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_property.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_property($_GET);
			break;
		}
	case "Person_talent":
		{
			$_SESSION["currentpage"] = "Person_talent";
			$arrScriptFiles = array ("script", "Person_talent.js","manage_Person_talent.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_talent.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_talent($_GET);
			break;
		}
	case "Person_telephone":
		{
			$_SESSION["currentpage"] = "Person_telephone";
			$arrScriptFiles = array ("script", "Person_telephone.js","manage_Person_telephone.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_telephone.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_telephone($_GET);
			break;
		}
	case "Person_vocationaltraining":
		{
			$_SESSION["currentpage"] = "Person_vocationaltraining";
			$arrScriptFiles = array ("script", "Person_vocationaltraining.js","manage_Person_vocationaltraining.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_vocationaltraining.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_vocationaltraining($_GET);
			break;
		}
	case "Person_workingexperiance":
		{
			$_SESSION["currentpage"] = "Person_workingexperiance";
			$arrScriptFiles = array ("script", "Person_workingexperiance.js","manage_Person_workingexperiance.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Person_workingexperiance.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPerson_workingexperiance($_GET);
			break;
		}
	case "Plants":
		{
			$_SESSION["currentpage"] = "Plants";
			$arrScriptFiles = array ("script", "Plants.js","manage_Plants.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Plants.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPlants($_GET);
			break;
		}
	case "Primarygeolayertype":
		{
			$_SESSION["currentpage"] = "Primarygeolayertype";
			$arrScriptFiles = array ("script", "Primarygeolayertype.js","manage_Primarygeolayertype.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Primarygeolayertype.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadPrimarygeolayertype($_GET);
			break;
		}
	case "Product":
		{
			$_SESSION["currentpage"] = "Product";
			$arrScriptFiles = array ("script", "Product.js","manage_Product.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Product.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadProduct($_GET);
			break;
		}
	case "Service":
		{
			$_SESSION["currentpage"] = "Service";
			$arrScriptFiles = array ("script", "Service.js","manage_Service.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Service.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadService($_GET);
			break;
		}
	case "Socierytype":
		{
			$_SESSION["currentpage"] = "Socierytype";
			$arrScriptFiles = array ("script", "Socierytype.js","manage_Socierytype.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Socierytype.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadSocierytype($_GET);
			break;
		}
	case "Society":
		{
			$_SESSION["currentpage"] = "Society";
			$arrScriptFiles = array ("script", "Society.js","manage_Society.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Society.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadSociety($_GET);
			break;
		}
	case "Society_member":
		{
			$_SESSION["currentpage"] = "Society_member";
			$arrScriptFiles = array ("script", "Society_member.js","manage_Society_member.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Society_member.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadSociety_member($_GET);
			break;
		}
	case "Soiltype":
		{
			$_SESSION["currentpage"] = "Soiltype";
			$arrScriptFiles = array ("script", "Soiltype.js","manage_Soiltype.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Soiltype.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadSoiltype($_GET);
			break;
		}
	case "Talent":
		{
			$_SESSION["currentpage"] = "Talent";
			$arrScriptFiles = array ("script", "Talent.js","manage_Talent.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Talent.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadTalent($_GET);
			break;
		}
	case "Town":
		{
			$_SESSION["currentpage"] = "Town";
			$arrScriptFiles = array ("script", "Town.js","manage_Town.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Town.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadTown($_GET);
			break;
		}
	case "Trading":
		{
			$_SESSION["currentpage"] = "Trading";
			$arrScriptFiles = array ("script", "Trading.js","manage_Trading.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Trading.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadTrading($_GET);
			break;
		}
	case "Traditionalknowledgecategory":
		{
			$_SESSION["currentpage"] = "Traditionalknowledgecategory";
			$arrScriptFiles = array ("script", "Traditionalknowledgecategory.js","manage_Traditionalknowledgecategory.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Traditionalknowledgecategory.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadTraditionalknowledgecategory($_GET);
			break;
		}
	case "Transport":
		{
			$_SESSION["currentpage"] = "Transport";
			$arrScriptFiles = array ("script", "Transport.js","manage_Transport.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Transport.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadTransport($_GET);
			break;
		}
	case "User":
		{
			$_SESSION["currentpage"] = "User";
			$arrScriptFiles = array ("script", "User.js","manage_User.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","User.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadUser($_GET);
			break;
		}
	case "Village":
		{
			$_SESSION["currentpage"] = "Village";
			$arrScriptFiles = array ("script", "Village.js","manage_Village.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage($_GET);
			break;
		}
	case "Village_agriculture":
		{
			$_SESSION["currentpage"] = "Village_agriculture";
			$arrScriptFiles = array ("script", "Village_agriculture.js","manage_Village_agriculture.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_agriculture.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_agriculture($_GET);
			break;
		}
	case "Village_climate":
		{
			$_SESSION["currentpage"] = "Village_climate";
			$arrScriptFiles = array ("script", "Village_climate.js","manage_Village_climate.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_climate.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_climate($_GET);
			break;
		}
	case "Village_enterance":
		{
			$_SESSION["currentpage"] = "Village_enterance";
			$arrScriptFiles = array ("script", "Village_enterance.js","manage_Village_enterance.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_enterance.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_enterance($_GET);
			break;
		}
	case "Village_geologicalvariation":
		{
			$_SESSION["currentpage"] = "Village_geologicalvariation";
			$arrScriptFiles = array ("script", "Village_geologicalvariation.js","manage_Village_geologicalvariation.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_geologicalvariation.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_geologicalvariation($_GET);
			break;
		}
	case "Village_group":
		{
			$_SESSION["currentpage"] = "Village_group";
			$arrScriptFiles = array ("script", "Village_group.js","manage_Village_group.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_group.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_group($_GET);
			break;
		}
	case "Village_history":
		{
			$_SESSION["currentpage"] = "Village_history";
			$arrScriptFiles = array ("script", "Village_history.js","manage_Village_history.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_history.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_history($_GET);
			break;
		}
	case "Village_image":
		{
			$_SESSION["currentpage"] = "Village_image";
			$arrScriptFiles = array ("script", "Village_image.js","manage_Village_image.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_image.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_image($_GET);
			break;
		}
	case "Village_industrial":
		{
			$_SESSION["currentpage"] = "Village_industrial";
			$arrScriptFiles = array ("script", "Village_industrial.js","manage_Village_industrial.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_industrial.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_industrial($_GET);
			break;
		}
	case "Village_neartowns":
		{
			$_SESSION["currentpage"] = "Village_neartowns";
			$arrScriptFiles = array ("script", "Village_neartowns.js","manage_Village_neartowns.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_neartowns.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_neartowns($_GET);
			break;
		}
	case "Village_organization":
		{
			$_SESSION["currentpage"] = "Village_organization";
			$arrScriptFiles = array ("script", "Village_organization.js","manage_Village_organization.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_organization.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_organization($_GET);
			break;
		}
	case "Village_othernames":
		{
			$_SESSION["currentpage"] = "Village_othernames";
			$arrScriptFiles = array ("script", "Village_othernames.js","manage_Village_othernames.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_othernames.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_othernames($_GET);
			break;
		}
	case "Village_plant":
		{
			$_SESSION["currentpage"] = "Village_plant";
			$arrScriptFiles = array ("script", "Village_plant.js","manage_Village_plant.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_plant.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_plant($_GET);
			break;
		}
	case "Village_service":
		{
			$_SESSION["currentpage"] = "Village_service";
			$arrScriptFiles = array ("script", "Village_service.js","manage_Village_service.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_service.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_service($_GET);
			break;
		}
	case "Village_society":
		{
			$_SESSION["currentpage"] = "Village_society";
			$arrScriptFiles = array ("script", "Village_society.js","manage_Village_society.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_society.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_society($_GET);
			break;
		}
	case "Village_trading":
		{
			$_SESSION["currentpage"] = "Village_trading";
			$arrScriptFiles = array ("script", "Village_trading.js","manage_Village_trading.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_trading.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_trading($_GET);
			break;
		}
	case "Village_traditionalknowledge":
		{
			$_SESSION["currentpage"] = "Village_traditionalknowledge";
			$arrScriptFiles = array ("script", "Village_traditionalknowledge.js","manage_Village_traditionalknowledge.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_traditionalknowledge.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_traditionalknowledge($_GET);
			break;
		}
	case "Village_transport":
		{
			$_SESSION["currentpage"] = "Village_transport";
			$arrScriptFiles = array ("script", "Village_transport.js","manage_Village_transport.js","AutoComplete.js","baseConnection.js","msgPopup.js","formPopup.js","manage_Cookie.js");
			$arrStyleFiles = array ("style", "styles.css","Village_transport.css");
			array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
			loadHeader($arrFilesForLoad);
			loadVillage_transport($_GET);
			break;
		}
      case "login":
        {
            $_SESSION["currentpage"] = "login";
			$arrScriptFiles = array ("script", "loginValidator.js","manage_profile.js","event_manage_profile.js","AutoComplete.js","baseConnection.js","msgPopup.js","manage_Cookie.js");
            $arrStyleFiles = array ("style", "styles.css","profile.css");
            array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
            loadHeader($arrFilesForLoad);
            loadLogin();
            break;
        }
      case "persondashboard":
        {
			$_SESSION["currentpage"] = "persondashboard";
			$arrScriptFiles = array ("script", "baseConnection.js","msgPopup.js","manage_Cookie.js");
            $arrStyleFiles = array ("style", "styles.css");
            array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
            loadHeader($arrFilesForLoad);
            loadPersonDashboard($_GET);
            break;
        }
		case "villagedashboard":
        {
			$_SESSION["currentpage"] = "villagedashboard";
			$arrScriptFiles = array ("script", "baseConnection.js","msgPopup.js","manage_Cookie.js");
            $arrStyleFiles = array ("style", "styles.css");
            array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
            loadHeader($arrFilesForLoad);
            loadVillageDashboard($_GET);
            break;
        }
    default:
        {
			$_SESSION["currentpage"] = "dashboard";
			$arrScriptFiles = array ("script", "baseConnection.js","msgPopup.js","manage_Cookie.js");
            $arrStyleFiles = array ("style", "styles.css");
            array_push($arrFilesForLoad, $arrStyleFiles);
			array_push($arrFilesForLoad, $arrScriptFiles);
            loadHeader($arrFilesForLoad);
            loadDashboard($_GET);
            break;
        }
}
loadfooter();
?>
