<?php
ini_set("display_errors","Off");
session_start();
//ini_set("error_reporting","E_ALL & ~E_NOTICE | E_STRICT");
require_once("main_packet.php");
require_once("package_packet.php");
require_once ("include/Agriculture.php");
require_once ("include/Alsubjects.php");
require_once ("include/Business.php");
require_once ("include/Business_product.php");
require_once ("include/Businesstype.php");
require_once ("include/Foresttype.php");
require_once ("include/Geographytype.php");
require_once ("include/Group.php");
require_once ("include/Group_member.php");
require_once ("include/Groupmissiontype.php");
require_once ("include/Higherstudysubjects.php");
require_once ("include/Industrial.php");
require_once ("include/Language.php");
require_once ("include/Location.php");
require_once ("include/Location_resources.php");
require_once ("include/Olsubjects.php");
require_once ("include/Organization.php");
require_once ("include/Organization_subtype.php");
require_once ("include/Organizationtype.php");
require_once ("include/Person.php");
require_once ("include/Person_address.php");
require_once ("include/Person_alresult.php");
require_once ("include/Person_educationlevel.php");
require_once ("include/Person_highereducation.php");
require_once ("include/Person_languageskill.php");
require_once ("include/Person_olresult.php");
require_once ("include/Person_property.php");
require_once ("include/Person_talent.php");
require_once ("include/Person_telephone.php");
require_once ("include/Person_vocationaltraining.php");
require_once ("include/Person_workingexperiance.php");
require_once ("include/Plants.php");
require_once ("include/Primarygeolayertype.php");
require_once ("include/Product.php");
require_once ("include/Service.php");
require_once ("include/Socierytype.php");
require_once ("include/Society.php");
require_once ("include/Society_member.php");
require_once ("include/Soiltype.php");
require_once ("include/Talent.php");
require_once ("include/Town.php");
require_once ("include/Trading.php");
require_once ("include/Traditionalknowledgecategory.php");
require_once ("include/Transport.php");
require_once ("include/User.php");
require_once ("include/Village.php");
require_once ("include/Village_agriculture.php");
require_once ("include/Village_climate.php");
require_once ("include/Village_enterance.php");
require_once ("include/Village_geologicalvariation.php");
require_once ("include/Village_group.php");
require_once ("include/Village_history.php");
require_once ("include/Village_image.php");
require_once ("include/Village_industrial.php");
require_once ("include/Village_neartowns.php");
require_once ("include/Village_organization.php");
require_once ("include/Village_othernames.php");
require_once ("include/Village_plant.php");
require_once ("include/Village_service.php");
require_once ("include/Village_society.php");
require_once ("include/Village_trading.php");
require_once ("include/Village_traditionalknowledge.php");
require_once ("include/Village_transport.php");

require_once ("BL/BL_manageAgriculture.php");
require_once ("BL/BL_manageAlsubjects.php");
require_once ("BL/BL_manageBusiness.php");
require_once ("BL/BL_manageBusiness_product.php");
require_once ("BL/BL_manageBusinesstype.php");
require_once ("BL/BL_manageForesttype.php");
require_once ("BL/BL_manageGeographytype.php");
require_once ("BL/BL_manageGroup.php");
require_once ("BL/BL_manageGroup_member.php");
require_once ("BL/BL_manageGroupmissiontype.php");
require_once ("BL/BL_manageHigherstudysubjects.php");
require_once ("BL/BL_manageIndustrial.php");
require_once ("BL/BL_manageLanguage.php");
require_once ("BL/BL_manageLocation.php");
require_once ("BL/BL_manageLocation_resources.php");
require_once ("BL/BL_manageOlsubjects.php");
require_once ("BL/BL_manageOrganization.php");
require_once ("BL/BL_manageOrganization_subtype.php");
require_once ("BL/BL_manageOrganizationtype.php");
require_once ("BL/BL_managePerson.php");
require_once ("BL/BL_managePerson_address.php");
require_once ("BL/BL_managePerson_alresult.php");
require_once ("BL/BL_managePerson_educationlevel.php");
require_once ("BL/BL_managePerson_highereducation.php");
require_once ("BL/BL_managePerson_languageskill.php");
require_once ("BL/BL_managePerson_olresult.php");
require_once ("BL/BL_managePerson_property.php");
require_once ("BL/BL_managePerson_talent.php");
require_once ("BL/BL_managePerson_telephone.php");
require_once ("BL/BL_managePerson_vocationaltraining.php");
require_once ("BL/BL_managePerson_workingexperiance.php");
require_once ("BL/BL_managePlants.php");
require_once ("BL/BL_managePrimarygeolayertype.php");
require_once ("BL/BL_manageProduct.php");
require_once ("BL/BL_manageService.php");
require_once ("BL/BL_manageSocierytype.php");
require_once ("BL/BL_manageSociety.php");
require_once ("BL/BL_manageSociety_member.php");
require_once ("BL/BL_manageSoiltype.php");
require_once ("BL/BL_manageTalent.php");
require_once ("BL/BL_manageTown.php");
require_once ("BL/BL_manageTrading.php");
require_once ("BL/BL_manageTraditionalknowledgecategory.php");
require_once ("BL/BL_manageTransport.php");
require_once ("BL/BL_manageUser.php");
require_once ("BL/BL_manageVillage.php");
require_once ("BL/BL_manageVillage_agriculture.php");
require_once ("BL/BL_manageVillage_climate.php");
require_once ("BL/BL_manageVillage_enterance.php");
require_once ("BL/BL_manageVillage_geologicalvariation.php");
require_once ("BL/BL_manageVillage_group.php");
require_once ("BL/BL_manageVillage_history.php");
require_once ("BL/BL_manageVillage_image.php");
require_once ("BL/BL_manageVillage_industrial.php");
require_once ("BL/BL_manageVillage_neartowns.php");
require_once ("BL/BL_manageVillage_organization.php");
require_once ("BL/BL_manageVillage_othernames.php");
require_once ("BL/BL_manageVillage_plant.php");
require_once ("BL/BL_manageVillage_service.php");
require_once ("BL/BL_manageVillage_society.php");
require_once ("BL/BL_manageVillage_trading.php");
require_once ("BL/BL_manageVillage_traditionalknowledge.php");
require_once ("BL/BL_manageVillage_transport.php");
require_once ("BL/BL_manageAutocomplete.php");

handleRequest(readBody());

//-------------------------------------------------------------------------------------

function readBody()
{
    $body = "";
    $putData = fopen("php://input", "r");
    while ($block = fread($putData, 1024))
    {
        $body = $body.$block;
    }
    fclose($putData);
    return $body;
}

//-------------------------------------------------------------------------------------

function handleRequest($packagePacketText)
{
	
	$obj_packagepacket = new packagepacket();
	$obj_packagepacket->set_InPackagePacket($packagePacketText);
	$obj_me = unserialize($_SESSION["user"]);
	
	foreach($obj_packagepacket->mainpacketList as $obj_mainpacket)
	{
	

    switch($obj_mainpacket->moduleId)
    {
	
	    case 1:
            {
                onIncommingMessage($obj_mainpacket);
                break;
            }

		case 2:
			{
				BL_manageAgriculture::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 3:
			{
				BL_manageAlsubjects::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 4:
			{
				BL_manageBusiness::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 5:
			{
				BL_manageBusiness_product::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 6:
			{
				BL_manageBusinesstype::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 7:
			{
				BL_manageForesttype::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 8:
			{
				BL_manageGeographytype::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 9:
			{
				BL_manageGroup::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 10:
			{
				BL_manageGroup_member::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 11:
			{
				BL_manageGroupmissiontype::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 12:
			{
				BL_manageHigherstudysubjects::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 13:
			{
				BL_manageIndustrial::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 14:
			{
				BL_manageLocation::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 15:
			{
				BL_manageLocation_resources::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 16:
			{
				BL_manageOlsubjects::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 17:
			{
				BL_manageOrganization::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 18:
			{
				BL_manageOrganization_subtype::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 19:
			{
				BL_manageOrganizationtype::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 20:
			{
				BL_managePerson::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 21:
			{
				BL_managePerson_address::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 22:
			{
				BL_managePerson_alresult::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 23:
			{
				BL_managePerson_educationlevel::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 24:
			{
				BL_managePerson_highereducation::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 25:
			{
				BL_managePerson_languageskill::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 26:
			{
				BL_managePerson_olresult::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 27:
			{
				BL_managePerson_property::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 28:
			{
				BL_managePerson_talent::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 29:
			{
				BL_managePerson_telephone::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 30:
			{
				BL_managePerson_vocationaltraining::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 31:
			{
				BL_managePerson_workingexperiance::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 32:
			{
				BL_managePlants::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 33:
			{
				BL_managePrimarygeolayertype::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 34:
			{
				BL_manageProduct::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 35:
			{
				BL_manageService::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 36:
			{
				BL_manageSocierytype::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 37:
			{
				BL_manageSociety::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 38:
			{
				BL_manageSociety_member::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 39:
			{
				BL_manageSoiltype::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 40:
			{
				BL_manageTalent::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 41:
			{
				BL_manageTown::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 42:
			{
				BL_manageTrading::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 43:
			{
				BL_manageTraditionalknowledgecategory::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 44:
			{
				BL_manageTransport::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 45:
			{
				BL_manageUser::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 46:
			{
				BL_manageVillage::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 47:
			{
				BL_manageVillage_agriculture::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 48:
			{
				BL_manageVillage_climate::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 49:
			{
				BL_manageVillage_enterance::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 50:
			{
				BL_manageVillage_geologicalvariation::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 51:
			{
				BL_manageVillage_group::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 52:
			{
				BL_manageVillage_history::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 53:
			{
				BL_manageVillage_image::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 54:
			{
				BL_manageVillage_industrial::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 55:
			{
				BL_manageVillage_neartowns::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 56:
			{
				BL_manageVillage_organization::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 57:
			{
				BL_manageVillage_othernames::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 58:
			{
				BL_manageVillage_plant::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 59:
			{
				BL_manageVillage_service::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 60:
			{
				BL_manageVillage_society::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 61:
			{
				BL_manageVillage_trading::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 62:
			{
				BL_manageVillage_traditionalknowledge::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 63:
			{
				BL_manageVillage_transport::onIncommingMessage($obj_mainpacket);
				break;
			}
		case 64:
			{
				BL_manageLanguage::onIncommingMessage($obj_mainpacket);
				break;
			}



    }
	}
   echo $obj_packagepacket->get_OutPackagePacket();

}

//-------------------------------------------------------------------------------------

function onIncommingMessage($obj_mainpacket)
{

switch($obj_mainpacket->actionId)
    {
    	 case 101:
            {
                BL_manageAutocomplete::Autocomplete_Init($obj_mainpacket);
                break;
            }
        case 100:
            {
                BL_manageAutocomplete::Autocomplete_search($obj_mainpacket);
                break;
            }
			
	}
	/*
switch($obj_mainpacket->actionId)
    {
    	 case 100:
            {
                getProfilePage($obj_mainpacket->packet);
                break;
            }
        case 101:
            {
                getProfile($obj_mainpacket->packet);
                break;
            }
        case 102:
            {
                addProfileField($obj_mainpacket->packet);
                break;
            }
        case 103:
            {
                addProfileFiledData($obj_mainpacket->packet);
                break;
            }
        case 104:
            {
                addProfileCategory($obj_mainpacket->packet);
                break;
            }

    }
	*/
}





?>
