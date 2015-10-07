<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_othernames.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_othernames.php");


class BL_manageVillage_othernames
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_othernames::addVillage_othernames($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_othernames::deleteVillage_othernames($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_othernames::updateVillage_othernames($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_othernames($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_othernames = new Village_othernames();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_othernames->VillageId = $packet[1];
		$obj_newVillage_othernames->VillageNames = $packet[2];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_othernames = DAL_manageVillage_othernames::addVillage_othernames($obj_newVillage_othernames);
            if ($obj_retResult_Village_othernames->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_othernames->data->wsGetVillage_othernamesData();
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

    public static function addVillage_othernames2($VillageId,$VillageNames)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_othernames = new Village_othernames();
		
		$obj_newuser->setVillage_othernames($VillageId,$VillageNames);
       // $isExist = BL_manageVillage_othernames::isExist($obj_newVillage_othernames->id);

        if (!$isExist)
        {
            $obj_retResult_Village_othernames = DAL_manageVillage_othernames::addVillage_othernames($obj_newVillage_othernames);
            if ($obj_retResult_Village_othernames->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_othernames->data;
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
            $obj_retResult->msg = "Sorry! Village_othernames already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_othernames($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_othernames = new Village_othernames();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_othernames->VillageId = $packet[0];
		$obj_Village_othernames->VillageNames = $packet[1];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_othernames = DAL_manageVillage_othernames::update($obj_Village_othernames);

        if ($obj_retResult_Village_othernames->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_othernames updation is Success";
			$retrunUserpacket = $obj_retResult_Village_othernames->data->wsGetVillage_othernamesData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_othernames updation is Failed";
			$result_Village_othernames = DAL_manageVillage_othernames::getVillage_othernamesByVillageId($obj_Village_othernames->VillageId);
			if($result_Village_othernames->type ==1)
			{
			$retrunUserpacket = $result_Village_othernames->data->wsGetVillage_othernamesData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_othernames2($VillageId,$VillageNames)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_othernames = new Village_othernames();
	
		$obj_newVillage_othernames->VillageId=$VillageId;
		$obj_newVillage_othernames->VillageNames=$VillageNames;

	   
        $issuccess = DAL_manageVillage_othernames::updateVillage_othernames($obj_newVillage_othernames);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_othernames::getVillage_othernamesByVillageId($obj_newVillage_othernames->VillageId);
            $obj_retResult->msg = "Village_othernames updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_othernames updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_othernamesList()
    {
        $obj_retResult = DAL_manageVillage_othernames::getVillage_othernamesList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_othernamesList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_othernames::getAllVillage_othernames($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_othernames::searchVillage_othernamesByVillageId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_othernames List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>VillageId</th>";
		$html .= "<th>VillageNames</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_othernamesList as $obj_Village_othernames)
            {               

                    $html .= $obj_Village_othernames->drawTableViewVillage_othernames(); 
                
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

	public static function deleteVillage_othernames($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$VillageId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_VillageId =0;
			
			$retResult = BL_manageVillage_othernames::getVillage_othernamesListByVillageId($VillageId);
			if($retResult->type ==1)
			{
			
			$obj_Village_othernames = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_othernames::deleteVillage_othernames($obj_Village_othernames->VillageId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_VillageId = $obj_Village_othernames->VillageId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_othernames";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_othernames you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_othernames->VillageId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_othernamesListByVillageId($VillageId)
    {
        $obj_retResult = DAL_manageVillage_othernames::getVillage_othernamesListByVillageId($VillageId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_othernames($VillageId,$ChildVillageId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_othernames::getVillage_othernamesListByVillageId($ChildVillageId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_othernamesList = $obj_retResult->data;
				$obj_Village_othernames = $arr_Village_othernamesList[0];
				
				$arrParentIds = explode(",",$obj_Village_othernames->Url);
				
				foreach($arrParentIds as $Village_othernamesParentId)
				{
					if($Village_othernamesParentId == $VillageId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>