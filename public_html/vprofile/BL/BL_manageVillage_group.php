<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_group.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_group.php");


class BL_manageVillage_group
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_group::addVillage_group($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_group::deleteVillage_group($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_group::updateVillage_group($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_group($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_group = new Village_group();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_group->GroupId = $packet[1];
		$obj_newVillage_group->VillageId = $packet[2];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_group = DAL_manageVillage_group::addVillage_group($obj_newVillage_group);
            if ($obj_retResult_Village_group->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_group->data->wsGetVillage_groupData();
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

    public static function addVillage_group2($GroupId,$VillageId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_group = new Village_group();
		
		$obj_newuser->setVillage_group($GroupId,$VillageId);
       // $isExist = BL_manageVillage_group::isExist($obj_newVillage_group->id);

        if (!$isExist)
        {
            $obj_retResult_Village_group = DAL_manageVillage_group::addVillage_group($obj_newVillage_group);
            if ($obj_retResult_Village_group->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_group->data;
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
            $obj_retResult->msg = "Sorry! Village_group already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_group($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_group = new Village_group();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_group->GroupId = $packet[0];
		$obj_Village_group->VillageId = $packet[1];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_group = DAL_manageVillage_group::update($obj_Village_group);

        if ($obj_retResult_Village_group->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_group updation is Success";
			$retrunUserpacket = $obj_retResult_Village_group->data->wsGetVillage_groupData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_group updation is Failed";
			$result_Village_group = DAL_manageVillage_group::getVillage_groupByVillageId($obj_Village_group->VillageId);
			if($result_Village_group->type ==1)
			{
			$retrunUserpacket = $result_Village_group->data->wsGetVillage_groupData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_group2($GroupId,$VillageId)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_group = new Village_group();
	
		$obj_newVillage_group->GroupId=$GroupId;
		$obj_newVillage_group->VillageId=$VillageId;

	   
        $issuccess = DAL_manageVillage_group::updateVillage_group($obj_newVillage_group);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_group::getVillage_groupByVillageId($obj_newVillage_group->VillageId);
            $obj_retResult->msg = "Village_group updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_group updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_groupList()
    {
        $obj_retResult = DAL_manageVillage_group::getVillage_groupList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_groupList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_group::getAllVillage_group($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_group::searchVillage_groupByVillageId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_group List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>GroupId</th>";
		$html .= "<th>VillageId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_groupList as $obj_Village_group)
            {               

                    $html .= $obj_Village_group->drawTableViewVillage_group(); 
                
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

	public static function deleteVillage_group($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$VillageId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_VillageId =0;
			
			$retResult = BL_manageVillage_group::getVillage_groupListByVillageId($VillageId);
			if($retResult->type ==1)
			{
			
			$obj_Village_group = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_group::deleteVillage_group($obj_Village_group->VillageId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_VillageId = $obj_Village_group->VillageId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_group";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_group you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_group->VillageId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_groupListByVillageId($VillageId)
    {
        $obj_retResult = DAL_manageVillage_group::getVillage_groupListByVillageId($VillageId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_group($VillageId,$ChildVillageId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_group::getVillage_groupListByVillageId($ChildVillageId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_groupList = $obj_retResult->data;
				$obj_Village_group = $arr_Village_groupList[0];
				
				$arrParentIds = explode(",",$obj_Village_group->Url);
				
				foreach($arrParentIds as $Village_groupParentId)
				{
					if($Village_groupParentId == $VillageId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>