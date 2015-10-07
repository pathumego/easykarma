<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_society.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_society.php");


class BL_manageVillage_society
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_society::addVillage_society($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_society::deleteVillage_society($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_society::updateVillage_society($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_society($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_society = new Village_society();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_society->SocietyId = $packet[1];
		$obj_newVillage_society->VillageId = $packet[2];
		$obj_newVillage_society->VillageSocietyId = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_society = DAL_manageVillage_society::addVillage_society($obj_newVillage_society);
            if ($obj_retResult_Village_society->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_society->data->wsGetVillage_societyData();
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

    public static function addVillage_society2($SocietyId,$VillageId,$VillageSocietyId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_society = new Village_society();
		
		$obj_newuser->setVillage_society($SocietyId,$VillageId,$VillageSocietyId);
       // $isExist = BL_manageVillage_society::isExist($obj_newVillage_society->id);

        if (!$isExist)
        {
            $obj_retResult_Village_society = DAL_manageVillage_society::addVillage_society($obj_newVillage_society);
            if ($obj_retResult_Village_society->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_society->data;
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
            $obj_retResult->msg = "Sorry! Village_society already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_society($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_society = new Village_society();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_society->SocietyId = $packet[0];
		$obj_Village_society->VillageId = $packet[1];
		$obj_Village_society->VillageSocietyId = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_society = DAL_manageVillage_society::update($obj_Village_society);

        if ($obj_retResult_Village_society->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_society updation is Success";
			$retrunUserpacket = $obj_retResult_Village_society->data->wsGetVillage_societyData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_society updation is Failed";
			$result_Village_society = DAL_manageVillage_society::getVillage_societyByVillageSocietyId($obj_Village_society->VillageSocietyId);
			if($result_Village_society->type ==1)
			{
			$retrunUserpacket = $result_Village_society->data->wsGetVillage_societyData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_society2($SocietyId,$VillageId,$VillageSocietyId)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_society = new Village_society();
	
		$obj_newVillage_society->SocietyId=$SocietyId;
		$obj_newVillage_society->VillageId=$VillageId;
		$obj_newVillage_society->VillageSocietyId=$VillageSocietyId;

	   
        $issuccess = DAL_manageVillage_society::updateVillage_society($obj_newVillage_society);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_society::getVillage_societyByVillageSocietyId($obj_newVillage_society->VillageSocietyId);
            $obj_retResult->msg = "Village_society updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_society updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_societyList()
    {
        $obj_retResult = DAL_manageVillage_society::getVillage_societyList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_societyList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_society::getAllVillage_society($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_society::searchVillage_societyByVillageSocietyId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_society List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>SocietyId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>VillageSocietyId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_societyList as $obj_Village_society)
            {               

                    $html .= $obj_Village_society->drawTableViewVillage_society(); 
                
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

	public static function deleteVillage_society($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$VillageSocietyId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_VillageSocietyId =0;
			
			$retResult = BL_manageVillage_society::getVillage_societyListByVillageSocietyId($VillageSocietyId);
			if($retResult->type ==1)
			{
			
			$obj_Village_society = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_society::deleteVillage_society($obj_Village_society->VillageSocietyId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_VillageSocietyId = $obj_Village_society->VillageSocietyId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_society";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_society you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_society->VillageSocietyId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_societyListByVillageSocietyId($VillageSocietyId)
    {
        $obj_retResult = DAL_manageVillage_society::getVillage_societyListByVillageSocietyId($VillageSocietyId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_society($VillageSocietyId,$ChildVillageSocietyId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_society::getVillage_societyListByVillageSocietyId($ChildVillageSocietyId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_societyList = $obj_retResult->data;
				$obj_Village_society = $arr_Village_societyList[0];
				
				$arrParentIds = explode(",",$obj_Village_society->Url);
				
				foreach($arrParentIds as $Village_societyParentId)
				{
					if($Village_societyParentId == $VillageSocietyId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>