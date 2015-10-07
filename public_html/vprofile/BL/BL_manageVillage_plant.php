<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_plant.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_plant.php");


class BL_manageVillage_plant
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_plant::addVillage_plant($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_plant::deleteVillage_plant($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_plant::updateVillage_plant($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_plant($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_plant = new Village_plant();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_plant->PlantId = $packet[1];
		$obj_newVillage_plant->VillageId = $packet[2];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_plant = DAL_manageVillage_plant::addVillage_plant($obj_newVillage_plant);
            if ($obj_retResult_Village_plant->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_plant->data->wsGetVillage_plantData();
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

    public static function addVillage_plant2($PlantId,$VillageId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_plant = new Village_plant();
		
		$obj_newuser->setVillage_plant($PlantId,$VillageId);
       // $isExist = BL_manageVillage_plant::isExist($obj_newVillage_plant->id);

        if (!$isExist)
        {
            $obj_retResult_Village_plant = DAL_manageVillage_plant::addVillage_plant($obj_newVillage_plant);
            if ($obj_retResult_Village_plant->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_plant->data;
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
            $obj_retResult->msg = "Sorry! Village_plant already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_plant($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_plant = new Village_plant();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_plant->PlantId = $packet[0];
		$obj_Village_plant->VillageId = $packet[1];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_plant = DAL_manageVillage_plant::update($obj_Village_plant);

        if ($obj_retResult_Village_plant->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_plant updation is Success";
			$retrunUserpacket = $obj_retResult_Village_plant->data->wsGetVillage_plantData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_plant updation is Failed";
			$result_Village_plant = DAL_manageVillage_plant::getVillage_plantByVillageId($obj_Village_plant->VillageId);
			if($result_Village_plant->type ==1)
			{
			$retrunUserpacket = $result_Village_plant->data->wsGetVillage_plantData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_plant2($PlantId,$VillageId)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_plant = new Village_plant();
	
		$obj_newVillage_plant->PlantId=$PlantId;
		$obj_newVillage_plant->VillageId=$VillageId;

	   
        $issuccess = DAL_manageVillage_plant::updateVillage_plant($obj_newVillage_plant);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_plant::getVillage_plantByVillageId($obj_newVillage_plant->VillageId);
            $obj_retResult->msg = "Village_plant updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_plant updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_plantList()
    {
        $obj_retResult = DAL_manageVillage_plant::getVillage_plantList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_plantList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_plant::getAllVillage_plant($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_plant::searchVillage_plantByVillageId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_plant List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>PlantId</th>";
		$html .= "<th>VillageId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_plantList as $obj_Village_plant)
            {               

                    $html .= $obj_Village_plant->drawTableViewVillage_plant(); 
                
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

	public static function deleteVillage_plant($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$VillageId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_VillageId =0;
			
			$retResult = BL_manageVillage_plant::getVillage_plantListByVillageId($VillageId);
			if($retResult->type ==1)
			{
			
			$obj_Village_plant = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_plant::deleteVillage_plant($obj_Village_plant->VillageId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_VillageId = $obj_Village_plant->VillageId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_plant";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_plant you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_plant->VillageId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_plantListByVillageId($VillageId)
    {
        $obj_retResult = DAL_manageVillage_plant::getVillage_plantListByVillageId($VillageId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_plant($VillageId,$ChildVillageId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_plant::getVillage_plantListByVillageId($ChildVillageId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_plantList = $obj_retResult->data;
				$obj_Village_plant = $arr_Village_plantList[0];
				
				$arrParentIds = explode(",",$obj_Village_plant->Url);
				
				foreach($arrParentIds as $Village_plantParentId)
				{
					if($Village_plantParentId == $VillageId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>