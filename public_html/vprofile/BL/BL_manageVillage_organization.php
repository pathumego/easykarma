<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_organization.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_organization.php");


class BL_manageVillage_organization
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_organization::addVillage_organization($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_organization::deleteVillage_organization($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_organization::updateVillage_organization($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_organization($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_organization = new Village_organization();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_organization->OrganizationId = $packet[1];
		$obj_newVillage_organization->VillageId = $packet[2];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_organization = DAL_manageVillage_organization::addVillage_organization($obj_newVillage_organization);
            if ($obj_retResult_Village_organization->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_organization->data->wsGetVillage_organizationData();
            }
            else
            {
                $obj_retResult->type = 0;
                $obj_retResult->msg = "Failed";
				
            }

       // }
       // else
       // {
       //     $obj_retResult->type = 0;
       //     $obj_retResult->msg = "Sorry! User already exist";
       // }
       
		}
		$returnPacket = array ($obj_retResult->type,$obj_retResult->msg,$dummyId);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
	}
    //---------------------------------------------------------------------------------------------------------

    public static function addVillage_organization2($OrganizationId,$VillageId)
    {   	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_organization = new Village_organization();
		
		$obj_newuser->setVillage_organization($OrganizationId,$VillageId);
       // $isExist = BL_manageVillage_organization::isExist($obj_newVillage_organization->id);

        if (!$isExist)
        {
            $obj_retResult_Village_organization = DAL_manageVillage_organization::addVillage_organization($obj_newVillage_organization);
            if ($obj_retResult_Village_organization->type ==1)
            {            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_organization->data;
            }
            else
            {
                $obj_retResult->type = 0;
                $obj_retResult->msg = "Failed";
				
            }
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Sorry! Village_organization already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_organization($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_organization = new Village_organization();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_organization->OrganizationId = $packet[0];
		$obj_Village_organization->VillageId = $packet[1];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_organization = DAL_manageVillage_organization::update($obj_Village_organization);

        if ($obj_retResult_Village_organization->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_organization updation is Success";
			$retrunUserpacket = $obj_retResult_Village_organization->data->wsGetVillage_organizationData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_organization updation is Failed";
			$result_Village_organization = DAL_manageVillage_organization::getVillage_organizationByVillageId($obj_Village_organization->VillageId);
			if($result_Village_organization->type ==1)
			{
			$retrunUserpacket = $result_Village_organization->data->wsGetVillage_organizationData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_organization2($OrganizationId,$VillageId)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_organization = new Village_organization();
	
		$obj_newVillage_organization->OrganizationId=$OrganizationId;
		$obj_newVillage_organization->VillageId=$VillageId;

	   
        $issuccess = DAL_manageVillage_organization::updateVillage_organization($obj_newVillage_organization);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_organization::getVillage_organizationByVillageId($obj_newVillage_organization->VillageId);
            $obj_retResult->msg = "Village_organization updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_organization updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_organizationList()
    {
        $obj_retResult = DAL_manageVillage_organization::getVillage_organizationList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_organizationList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_organization::getAllVillage_organization($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_organization::searchVillage_organizationByVillageId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_organization List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>OrganizationId</th>";
		$html .= "<th>VillageId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_organizationList as $obj_Village_organization)
            {               

                    $html .= $obj_Village_organization->drawTableViewVillage_organization(); 
                
            }
		$html .= "</table></div>";
        }
        else
        {
            $html = "No user found";

        }
        return $html;
    }
	
    //---------------------------------------------------------------------------------------------------------  

	public static function deleteVillage_organization($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$VillageId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_VillageId =0;
			
			$retResult = BL_manageVillage_organization::getVillage_organizationListByVillageId($VillageId);
			if($retResult->type ==1)
			{
			
			$obj_Village_organization = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_organization::deleteVillage_organization($obj_Village_organization->VillageId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_VillageId = $obj_Village_organization->VillageId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_organization";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_organization you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_organization->VillageId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_organizationListByVillageId($VillageId)
    {
        $obj_retResult = DAL_manageVillage_organization::getVillage_organizationListByVillageId($VillageId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_organization($VillageId,$ChildVillageId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_organization::getVillage_organizationListByVillageId($ChildVillageId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_organizationList = $obj_retResult->data;
				$obj_Village_organization = $arr_Village_organizationList[0];
				
				$arrParentIds = explode(",",$obj_Village_organization->Url);
				
				foreach($arrParentIds as $Village_organizationParentId)
				{
					if($Village_organizationParentId == $VillageId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>