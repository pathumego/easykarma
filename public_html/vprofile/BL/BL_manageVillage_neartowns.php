<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_neartowns.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_neartowns.php");


class BL_manageVillage_neartowns
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_neartowns::addVillage_neartowns($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_neartowns::deleteVillage_neartowns($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_neartowns::updateVillage_neartowns($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_neartowns($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_neartowns = new Village_neartowns();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_neartowns->VillageId = $packet[1];
		$obj_newVillage_neartowns->TownId = $packet[2];
		$obj_newVillage_neartowns->Distance = $packet[3];
		$obj_newVillage_neartowns->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_neartowns = DAL_manageVillage_neartowns::addVillage_neartowns($obj_newVillage_neartowns);
            if ($obj_retResult_Village_neartowns->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_neartowns->data->wsGetVillage_neartownsData();
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

    public static function addVillage_neartowns2($VillageId,$TownId,$Distance,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_neartowns = new Village_neartowns();
		
		$obj_newuser->setVillage_neartowns($VillageId,$TownId,$Distance,$Description);
       // $isExist = BL_manageVillage_neartowns::isExist($obj_newVillage_neartowns->id);

        if (!$isExist)
        {
            $obj_retResult_Village_neartowns = DAL_manageVillage_neartowns::addVillage_neartowns($obj_newVillage_neartowns);
            if ($obj_retResult_Village_neartowns->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_neartowns->data;
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
            $obj_retResult->msg = "Sorry! Village_neartowns already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_neartowns($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_neartowns = new Village_neartowns();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_neartowns->VillageId = $packet[0];
		$obj_Village_neartowns->TownId = $packet[1];
		$obj_Village_neartowns->Distance = $packet[2];
		$obj_Village_neartowns->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_neartowns = DAL_manageVillage_neartowns::update($obj_Village_neartowns);

        if ($obj_retResult_Village_neartowns->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_neartowns updation is Success";
			$retrunUserpacket = $obj_retResult_Village_neartowns->data->wsGetVillage_neartownsData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_neartowns updation is Failed";
			$result_Village_neartowns = DAL_manageVillage_neartowns::getVillage_neartownsByTownId($obj_Village_neartowns->TownId);
			if($result_Village_neartowns->type ==1)
			{
			$retrunUserpacket = $result_Village_neartowns->data->wsGetVillage_neartownsData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_neartowns2($VillageId,$TownId,$Distance,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_neartowns = new Village_neartowns();
	
		$obj_newVillage_neartowns->VillageId=$VillageId;
		$obj_newVillage_neartowns->TownId=$TownId;
		$obj_newVillage_neartowns->Distance=$Distance;
		$obj_newVillage_neartowns->Description=$Description;

	   
        $issuccess = DAL_manageVillage_neartowns::updateVillage_neartowns($obj_newVillage_neartowns);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_neartowns::getVillage_neartownsByTownId($obj_newVillage_neartowns->TownId);
            $obj_retResult->msg = "Village_neartowns updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_neartowns updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_neartownsList()
    {
        $obj_retResult = DAL_manageVillage_neartowns::getVillage_neartownsList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_neartownsList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_neartowns::getAllVillage_neartowns($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_neartowns::searchVillage_neartownsByTownId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_neartowns List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>VillageId</th>";
		$html .= "<th>TownId</th>";
		$html .= "<th>Distance</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_neartownsList as $obj_Village_neartowns)
            {               

                    $html .= $obj_Village_neartowns->drawTableViewVillage_neartowns(); 
                
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

	public static function deleteVillage_neartowns($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$TownId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_TownId =0;
			
			$retResult = BL_manageVillage_neartowns::getVillage_neartownsListByTownId($TownId);
			if($retResult->type ==1)
			{
			
			$obj_Village_neartowns = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_neartowns::deleteVillage_neartowns($obj_Village_neartowns->TownId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_TownId = $obj_Village_neartowns->TownId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_neartowns";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_neartowns you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_neartowns->TownId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_neartownsListByTownId($TownId)
    {
        $obj_retResult = DAL_manageVillage_neartowns::getVillage_neartownsListByTownId($TownId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_neartowns($TownId,$ChildTownId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_neartowns::getVillage_neartownsListByTownId($ChildTownId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_neartownsList = $obj_retResult->data;
				$obj_Village_neartowns = $arr_Village_neartownsList[0];
				
				$arrParentIds = explode(",",$obj_Village_neartowns->Url);
				
				foreach($arrParentIds as $Village_neartownsParentId)
				{
					if($Village_neartownsParentId == $TownId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>