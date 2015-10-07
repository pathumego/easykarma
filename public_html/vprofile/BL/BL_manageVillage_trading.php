<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_trading.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_trading.php");


class BL_manageVillage_trading
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_trading::addVillage_trading($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_trading::deleteVillage_trading($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_trading::updateVillage_trading($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_trading($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_trading = new Village_trading();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_trading->TradingId = $packet[1];
		$obj_newVillage_trading->VillageId = $packet[2];
		$obj_newVillage_trading->BusinessId = $packet[3];
		$obj_newVillage_trading->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_trading = DAL_manageVillage_trading::addVillage_trading($obj_newVillage_trading);
            if ($obj_retResult_Village_trading->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_trading->data->wsGetVillage_tradingData();
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

    public static function addVillage_trading2($TradingId,$VillageId,$BusinessId,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_trading = new Village_trading();
		
		$obj_newuser->setVillage_trading($TradingId,$VillageId,$BusinessId,$Description);
       // $isExist = BL_manageVillage_trading::isExist($obj_newVillage_trading->id);

        if (!$isExist)
        {
            $obj_retResult_Village_trading = DAL_manageVillage_trading::addVillage_trading($obj_newVillage_trading);
            if ($obj_retResult_Village_trading->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_trading->data;
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
            $obj_retResult->msg = "Sorry! Village_trading already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_trading($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_trading = new Village_trading();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_trading->TradingId = $packet[0];
		$obj_Village_trading->VillageId = $packet[1];
		$obj_Village_trading->BusinessId = $packet[2];
		$obj_Village_trading->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_trading = DAL_manageVillage_trading::update($obj_Village_trading);

        if ($obj_retResult_Village_trading->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_trading updation is Success";
			$retrunUserpacket = $obj_retResult_Village_trading->data->wsGetVillage_tradingData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_trading updation is Failed";
			$result_Village_trading = DAL_manageVillage_trading::getVillage_tradingByBusinessId($obj_Village_trading->BusinessId);
			if($result_Village_trading->type ==1)
			{
			$retrunUserpacket = $result_Village_trading->data->wsGetVillage_tradingData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_trading2($TradingId,$VillageId,$BusinessId,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_trading = new Village_trading();
	
		$obj_newVillage_trading->TradingId=$TradingId;
		$obj_newVillage_trading->VillageId=$VillageId;
		$obj_newVillage_trading->BusinessId=$BusinessId;
		$obj_newVillage_trading->Description=$Description;

	   
        $issuccess = DAL_manageVillage_trading::updateVillage_trading($obj_newVillage_trading);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_trading::getVillage_tradingByBusinessId($obj_newVillage_trading->BusinessId);
            $obj_retResult->msg = "Village_trading updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_trading updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_tradingList()
    {
        $obj_retResult = DAL_manageVillage_trading::getVillage_tradingList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_tradingList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_trading::getAllVillage_trading($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_trading::searchVillage_tradingByBusinessId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_trading List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TradingId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>BusinessId</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_tradingList as $obj_Village_trading)
            {               

                    $html .= $obj_Village_trading->drawTableViewVillage_trading(); 
                
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

	public static function deleteVillage_trading($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$BusinessId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_BusinessId =0;
			
			$retResult = BL_manageVillage_trading::getVillage_tradingListByBusinessId($BusinessId);
			if($retResult->type ==1)
			{
			
			$obj_Village_trading = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_trading::deleteVillage_trading($obj_Village_trading->BusinessId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_BusinessId = $obj_Village_trading->BusinessId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_trading";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_trading you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_trading->BusinessId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_tradingListByBusinessId($BusinessId)
    {
        $obj_retResult = DAL_manageVillage_trading::getVillage_tradingListByBusinessId($BusinessId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_trading($BusinessId,$ChildBusinessId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_trading::getVillage_tradingListByBusinessId($ChildBusinessId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_tradingList = $obj_retResult->data;
				$obj_Village_trading = $arr_Village_tradingList[0];
				
				$arrParentIds = explode(",",$obj_Village_trading->Url);
				
				foreach($arrParentIds as $Village_tradingParentId)
				{
					if($Village_tradingParentId == $BusinessId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>