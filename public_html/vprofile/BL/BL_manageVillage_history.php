<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_history.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_history.php");


class BL_manageVillage_history
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_history::addVillage_history($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_history::deleteVillage_history($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_history::updateVillage_history($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_history($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_history = new Village_history();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_history->TblId = $packet[1];
		$obj_newVillage_history->VillageId = $packet[2];
		$obj_newVillage_history->DescriptionType = $packet[3];
		$obj_newVillage_history->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_history = DAL_manageVillage_history::addVillage_history($obj_newVillage_history);
            if ($obj_retResult_Village_history->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_history->data->wsGetVillage_historyData();
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

    public static function addVillage_history2($TblId,$VillageId,$DescriptionType,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_history = new Village_history();
		
		$obj_newuser->setVillage_history($TblId,$VillageId,$DescriptionType,$Description);
       // $isExist = BL_manageVillage_history::isExist($obj_newVillage_history->id);

        if (!$isExist)
        {
            $obj_retResult_Village_history = DAL_manageVillage_history::addVillage_history($obj_newVillage_history);
            if ($obj_retResult_Village_history->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_history->data;
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
            $obj_retResult->msg = "Sorry! Village_history already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_history($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_history = new Village_history();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_history->TblId = $packet[0];
		$obj_Village_history->VillageId = $packet[1];
		$obj_Village_history->DescriptionType = $packet[2];
		$obj_Village_history->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_history = DAL_manageVillage_history::update($obj_Village_history);

        if ($obj_retResult_Village_history->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_history updation is Success";
			$retrunUserpacket = $obj_retResult_Village_history->data->wsGetVillage_historyData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_history updation is Failed";
			$result_Village_history = DAL_manageVillage_history::getVillage_historyByTblId($obj_Village_history->TblId);
			if($result_Village_history->type ==1)
			{
			$retrunUserpacket = $result_Village_history->data->wsGetVillage_historyData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_history2($TblId,$VillageId,$DescriptionType,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_history = new Village_history();
	
		$obj_newVillage_history->TblId=$TblId;
		$obj_newVillage_history->VillageId=$VillageId;
		$obj_newVillage_history->DescriptionType=$DescriptionType;
		$obj_newVillage_history->Description=$Description;

	   
        $issuccess = DAL_manageVillage_history::updateVillage_history($obj_newVillage_history);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_history::getVillage_historyByTblId($obj_newVillage_history->TblId);
            $obj_retResult->msg = "Village_history updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_history updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_historyList()
    {
        $obj_retResult = DAL_manageVillage_history::getVillage_historyList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_historyList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_history::getAllVillage_history($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_history::searchVillage_historyByTblId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_history List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TblId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>DescriptionType</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_historyList as $obj_Village_history)
            {               

                    $html .= $obj_Village_history->drawTableViewVillage_history(); 
                
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

	public static function deleteVillage_history($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$TblId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_TblId =0;
			
			$retResult = BL_manageVillage_history::getVillage_historyListByTblId($TblId);
			if($retResult->type ==1)
			{
			
			$obj_Village_history = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_history::deleteVillage_history($obj_Village_history->TblId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_TblId = $obj_Village_history->TblId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_history";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_history you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_history->TblId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_historyListByTblId($TblId)
    {
        $obj_retResult = DAL_manageVillage_history::getVillage_historyListByTblId($TblId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_history($TblId,$ChildTblId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_history::getVillage_historyListByTblId($ChildTblId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_historyList = $obj_retResult->data;
				$obj_Village_history = $arr_Village_historyList[0];
				
				$arrParentIds = explode(",",$obj_Village_history->Url);
				
				foreach($arrParentIds as $Village_historyParentId)
				{
					if($Village_historyParentId == $TblId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>