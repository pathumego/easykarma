<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageAutocomplete.php");


class BL_manageAutocomplete
{

//---------------------------------------------------------------------------------------------------------

public static function Autocomplete_Init($obj_mainpacket)
{
$SearchModuleNo =$obj_mainpacket->packet[0];
$GlobalAutoElemNo =$obj_mainpacket->packet[1];
$valuecoloumn = $obj_mainpacket->packet[2];
$primaryId = $obj_mainpacket->packet[3];

switch($SearchModuleNo)
    {	
case 2:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_agriculture","AgricultureId",$primaryId,$valuecoloumn);
 break;}
case 3:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_alsubjects","SubjectId",$primaryId,$valuecoloumn);
 break;}
case 4:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_business","BusinessId",$primaryId,$valuecoloumn);
 break;}
case 5:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_business_product","ProductId",$primaryId,$valuecoloumn);
 break;}
case 6:
{
$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_businesstype","BusinessTypeId",$primaryId,$valuecoloumn);
 break;}
case 7:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_foresttype","ForestTypeId",$primaryId,$valuecoloumn);
 break;}
case 8:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_geographytype","GeogrophyTypeId",$primaryId,$valuecoloumn);
 break;}
case 9:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_group","GroupId",$primaryId,$valuecoloumn);
 break;}
case 10:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_group_member","MemberId",$primaryId,$valuecoloumn);
 break;}
case 11:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_groupmissiontype","GroupMissionTypeId",$primaryId,$valuecoloumn);
 break;}
case 12:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_higherstudysubjects","SubjectId",$primaryId,$valuecoloumn);
 break;}
case 13:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_industrial","IndustrialId",$primaryId,$valuecoloumn);
 break;}
case 14:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_location","LocationId",$primaryId,$valuecoloumn);
 break;}
case 15:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_location_resources","ResourceId",$primaryId,$valuecoloumn);
 break;}
case 16:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_olsubjects","SubjectId",$primaryId,$valuecoloumn);
 break;}
case 17:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_organization","OrganizationId",$primaryId,$valuecoloumn);
 break;}
case 18:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_organization_subtype","OrganizationSubTypeId",$primaryId,$valuecoloumn);
 break;}
case 19:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_organizationtype","OrganizationTypeId",$primaryId,$valuecoloumn);
 break;}
case 20:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person","PersonId",$primaryId,$valuecoloumn);
 break;}
case 21:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_address","AddressId",$primaryId,$valuecoloumn);
 break;}
case 22:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_alresult","ALResultId",$primaryId,$valuecoloumn);
 break;}
case 23:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_educationlevel","EducationLevelId",$primaryId,$valuecoloumn);
 break;}
case 24:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_highereducation","ResultId",$primaryId,$valuecoloumn);
 break;}
case 25:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_languageskill","LangSkillId",$primaryId,$valuecoloumn);
 break;}
case 26:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_olresult","OLResultId",$primaryId,$valuecoloumn);
 break;}
case 27:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_property","PropertyId",$primaryId,$valuecoloumn);
 break;}
case 28:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_talent","TblId",$primaryId,$valuecoloumn);
 break;}
case 29:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_telephone","PhoneId",$primaryId,$valuecoloumn);
 break;}
case 30:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_vocationaltraining","VocationalTrainId",$primaryId,$valuecoloumn);
 break;}
case 31:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_person_workingexperiance","WorkExpId",$primaryId,$valuecoloumn);
 break;}
case 32:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_plants","PlantId",$primaryId,$valuecoloumn);
 break;}
case 33:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_primarygeolayertype","PrimaryGeoLayerTypeId",$primaryId,$valuecoloumn);
 break;}
case 34:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_product","ProductId",$primaryId,$valuecoloumn);
 break;}
case 35:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_service","ServiceId",$primaryId,$valuecoloumn);
 break;}
case 36:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_socierytype","SocieryTypeId",$primaryId,$valuecoloumn);
 break;}
case 37:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_society","SocietyId",$primaryId,$valuecoloumn);
 break;}
case 38:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_society_member","MemberId",$primaryId,$valuecoloumn);
 break;}
case 39:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_soiltype","TblId",$primaryId,$valuecoloumn);
 break;}
case 40:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_talent","TalentId",$primaryId,$valuecoloumn);
 break;}
case 41:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_town","TownId",$primaryId,$valuecoloumn);
 break;}
case 42:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_trading","tradingId",$primaryId,$valuecoloumn);
 break;}
case 43:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_traditionalknowledgecategory","CategoryId",$primaryId,$valuecoloumn);
 break;}
case 44:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_transport","TransportId",$primaryId,$valuecoloumn);
 break;}
case 45:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_user","userId",$primaryId,$valuecoloumn);
 break;}
case 46:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village","VillageId",$primaryId,$valuecoloumn);
 break;}
case 47:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_agriculture","BusinessId",$primaryId,$valuecoloumn);
 break;}
case 48:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_climate","ClimateId",$primaryId,$valuecoloumn);
 break;}
case 49:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_enterance","TblId",$primaryId,$valuecoloumn);
 break;}
case 50:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_geologicalvariation","TblId",$primaryId,$valuecoloumn);
 break;}
case 51:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_group","VillageId",$primaryId,$valuecoloumn);
 break;}
case 52:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_history","TblId",$primaryId,$valuecoloumn);
 break;}
case 53:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_image","PictureId",$primaryId,$valuecoloumn);
 break;}
case 54:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_industrial","BusinessId",$primaryId,$valuecoloumn);
 break;}
case 55:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_neartowns","TownId",$primaryId,$valuecoloumn);
 break;}
case 56:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_organization","VillageId",$primaryId,$valuecoloumn);
 break;}
case 57:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_othernames","VillageId",$primaryId,$valuecoloumn);
 break;}
case 58:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_plant","VillageId",$primaryId,$valuecoloumn);
 break;}
case 59:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_service","BusinessId",$primaryId,$valuecoloumn);
 break;}
case 60:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_society","VillageSocietyId",$primaryId,$valuecoloumn);
 break;}
case 61:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_trading","BusinessId",$primaryId,$valuecoloumn);
 break;}
case 62:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_traditionalknowledge","TblId",$primaryId,$valuecoloumn);
 break;}
case 63:
{$obj_retResult = DAL_manageAutocomplete::getPrimaryValue("tbl_village_transport","VillageId",$primaryId,$valuecoloumn);
 break;}

	}
	
	if ($obj_retResult->type ==1)
    {
	$main_retResult->type = 1;
    $main_retResult->msg = "Success";
	$main_retResult->data = $obj_retResult->data;
	}


$returnPacket = array ($main_retResult->type,$main_retResult->msg,$GlobalAutoElemNo,$main_retResult->data);
$obj_mainpacket->returnValues = $returnPacket;
$obj_mainpacket->main_setPacket();
}


public static function Autocomplete_search($obj_mainpacket)
{

//$dummyId = $obj_mainpacket->packet[0];
$SearchModuleNo =$obj_mainpacket->packet[0];
$GlobalAutoElemNo =$obj_mainpacket->packet[1];
$str_Searchcoloumns = $obj_mainpacket->packet[2];
$searchtext =  $obj_mainpacket->packet[3];



$arr_Searchcoloumns = explode("|",$str_Searchcoloumns); //multiple search coloumn can be set using |
$SearchTag = $arr_Searchcoloumns[0]; //get first coloumn as result selecting coloumn

$main_retResult = new returnResult();
$arr_data = array();

	$main_retResult->type = 0;
    $main_retResult->msg = "Failed";
	$main_retResult->data =$arr_data;


switch($SearchModuleNo)
    {	
case 2:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_agriculture",$arr_Searchcoloumns,"AgricultureId",$SearchTag,$searchtext);
 break;}
case 3:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_alsubjects",$arr_Searchcoloumns,"SubjectId",$SearchTag,$searchtext);
 break;}
case 4:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_business",$arr_Searchcoloumns,"BusinessId",$SearchTag,$searchtext);
 break;}
case 5:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_business_product",$arr_Searchcoloumns,"ProductId",$SearchTag,$searchtext);
 break;}
case 6:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_businesstype",$arr_Searchcoloumns,"BusinessTypeId",$SearchTag,$searchtext);
 break;}
case 7:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_foresttype",$arr_Searchcoloumns,"ForestTypeId",$SearchTag,$searchtext);
 break;}
case 8:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_geographytype",$arr_Searchcoloumns,"GeogrophyTypeId",$SearchTag,$searchtext);
 break;}
case 9:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_group",$arr_Searchcoloumns,"GroupId",$SearchTag,$searchtext);
 break;}
case 10:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_group_member",$arr_Searchcoloumns,"MemberId",$SearchTag,$searchtext);
 break;}
case 11:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_groupmissiontype",$arr_Searchcoloumns,"GroupMissionTypeId",$SearchTag,$searchtext);
 break;}
case 12:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_higherstudysubjects",$arr_Searchcoloumns,"SubjectId",$SearchTag,$searchtext);
 break;}
case 13:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_industrial",$arr_Searchcoloumns,"IndustrialId",$SearchTag,$searchtext);
 break;}
case 14:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_location",$arr_Searchcoloumns,"LocationId",$SearchTag,$searchtext);
 break;}
case 15:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_location_resources",$arr_Searchcoloumns,"ResourceId",$SearchTag,$searchtext);
 break;}
case 16:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_olsubjects",$arr_Searchcoloumns,"SubjectId",$SearchTag,$searchtext);
 break;}
case 17:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_organization",$arr_Searchcoloumns,"OrganizationId",$SearchTag,$searchtext);
 break;}
case 18:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_organization_subtype",$arr_Searchcoloumns,"OrganizationSubTypeId",$SearchTag,$searchtext);
 break;}
case 19:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_organizationtype",$arr_Searchcoloumns,"OrganizationTypeId",$SearchTag,$searchtext);
 break;}
case 20:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person",$arr_Searchcoloumns,"PersonId",$SearchTag,$searchtext);
 break;}
case 21:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_address",$arr_Searchcoloumns,"AddressId",$SearchTag,$searchtext);
 break;}
case 22:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_alresult",$arr_Searchcoloumns,"ALResultId",$SearchTag,$searchtext);
 break;}
case 23:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_educationlevel",$arr_Searchcoloumns,"EducationLevelId",$SearchTag,$searchtext);
 break;}
case 24:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_highereducation",$arr_Searchcoloumns,"ResultId",$SearchTag,$searchtext);
 break;}
case 25:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_languageskill",$arr_Searchcoloumns,"LangSkillId",$SearchTag,$searchtext);
 break;}
case 26:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_olresult",$arr_Searchcoloumns,"OLResultId",$SearchTag,$searchtext);
 break;}
case 27:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_property",$arr_Searchcoloumns,"PropertyId",$SearchTag,$searchtext);
 break;}
case 28:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_talent",$arr_Searchcoloumns,"TblId",$SearchTag,$searchtext);
 break;}
case 29:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_telephone",$arr_Searchcoloumns,"PhoneId",$SearchTag,$searchtext);
 break;}
case 30:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_vocationaltraining",$arr_Searchcoloumns,"VocationalTrainId",$SearchTag,$searchtext);
 break;}
case 31:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_person_workingexperiance",$arr_Searchcoloumns,"WorkExpId",$SearchTag,$searchtext);
 break;}
case 32:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_plants",$arr_Searchcoloumns,"PlantId",$SearchTag,$searchtext);
 break;}
case 33:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_primarygeolayertype",$arr_Searchcoloumns,"PrimaryGeoLayerTypeId",$SearchTag,$searchtext);
 break;}
case 34:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_product",$arr_Searchcoloumns,"ProductId",$SearchTag,$searchtext);
 break;}
case 35:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_service",$arr_Searchcoloumns,"ServiceId",$SearchTag,$searchtext);
 break;}
case 36:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_socierytype",$arr_Searchcoloumns,"SocieryTypeId",$SearchTag,$searchtext);
 break;}
case 37:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_society",$arr_Searchcoloumns,"SocietyId",$SearchTag,$searchtext);
 break;}
case 38:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_society_member",$arr_Searchcoloumns,"MemberId",$SearchTag,$searchtext);
 break;}
case 39:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_soiltype",$arr_Searchcoloumns,"TblId",$SearchTag,$searchtext);
 break;}
case 40:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_talent",$arr_Searchcoloumns,"TalentId",$SearchTag,$searchtext);
 break;}
case 41:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_town",$arr_Searchcoloumns,"TownId",$SearchTag,$searchtext);
 break;}
case 42:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_trading",$arr_Searchcoloumns,"tradingId",$SearchTag,$searchtext);
 break;}
case 43:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_traditionalknowledgecategory",$arr_Searchcoloumns,"CategoryId",$SearchTag,$searchtext);
 break;}
case 44:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_transport",$arr_Searchcoloumns,"TransportId",$SearchTag,$searchtext);
 break;}
case 45:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_user",$arr_Searchcoloumns,"userId",$SearchTag,$searchtext);
 break;}
case 46:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village",$arr_Searchcoloumns,"VillageId",$SearchTag,$searchtext);
 break;}
case 47:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_agriculture",$arr_Searchcoloumns,"BusinessId",$SearchTag,$searchtext);
 break;}
case 48:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_climate",$arr_Searchcoloumns,"ClimateId",$SearchTag,$searchtext);
 break;}
case 49:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_enterance",$arr_Searchcoloumns,"TblId",$SearchTag,$searchtext);
 break;}
case 50:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_geologicalvariation",$arr_Searchcoloumns,"TblId",$SearchTag,$searchtext);
 break;}
case 51:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_group",$arr_Searchcoloumns,"VillageId",$SearchTag,$searchtext);
 break;}
case 52:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_history",$arr_Searchcoloumns,"TblId",$SearchTag,$searchtext);
 break;}
case 53:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_image",$arr_Searchcoloumns,"PictureId",$SearchTag,$searchtext);
 break;}
case 54:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_industrial",$arr_Searchcoloumns,"BusinessId",$SearchTag,$searchtext);
 break;}
case 55:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_neartowns",$arr_Searchcoloumns,"TownId",$SearchTag,$searchtext);
 break;}
case 56:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_organization",$arr_Searchcoloumns,"VillageId",$SearchTag,$searchtext);
 break;}
case 57:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_othernames",$arr_Searchcoloumns,"VillageId",$SearchTag,$searchtext);
 break;}
case 58:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_plant",$arr_Searchcoloumns,"VillageId",$SearchTag,$searchtext);
 break;}
case 59:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_service",$arr_Searchcoloumns,"BusinessId",$SearchTag,$searchtext);
 break;}
case 60:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_society",$arr_Searchcoloumns,"VillageSocietyId",$SearchTag,$searchtext);
 break;}
case 61:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_trading",$arr_Searchcoloumns,"BusinessId",$SearchTag,$searchtext);
 break;}
case 62:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_traditionalknowledge",$arr_Searchcoloumns,"TblId",$SearchTag,$searchtext);
 break;}
case 63:
{$obj_retResult = DAL_manageAutocomplete::getSearchList("tbl_village_transport",$arr_Searchcoloumns,"VillageId",$SearchTag,$searchtext);
 break;}

	}

	if ($obj_retResult->type ==1)
    {
	$main_retResult->type = 1;
    $main_retResult->msg = "Success";
	$main_retResult->data = implode(",",$obj_retResult->data);
	}


$returnPacket = array ($main_retResult->type,$main_retResult->msg,$GlobalAutoElemNo,$main_retResult->data);
$obj_mainpacket->returnValues = $returnPacket;
$obj_mainpacket->main_setPacket();

}

	
}
?>