<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Town.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTown.php");


class BL_manageTown
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageTown::addTown($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageTown::deleteTown($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageTown::updateTown($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addTown($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newTown = new Town();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newTown->TownId = $packet[1];
		$obj_newTown->TownName = $packet[2];
		$obj_newTown->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Town = DAL_manageTown::addTown($obj_newTown);
            if ($obj_retResult_Town->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Town->data->wsGetTownData();
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

    public static function addTown2($TownId,$TownName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newTown = new Town();
		
		$obj_newuser->setTown($TownId,$TownName,$Description);
       // $isExist = BL_manageTown::isExist($obj_newTown->id);

        if (!$isExist)
        {
            $obj_retResult_Town = DAL_manageTown::addTown($obj_newTown);
            if ($obj_retResult_Town->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Town->data;
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
            $obj_retResult->msg = "Sorry! Town already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateTown($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Town = new Town();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Town->TownId = $packet[0];
		$obj_Town->TownName = $packet[1];
		$obj_Town->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Town = DAL_manageTown::update($obj_Town);

        if ($obj_retResult_Town->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Town updation is Success";
			$retrunUserpacket = $obj_retResult_Town->data->wsGetTownData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Town updation is Failed";
			$result_Town = DAL_manageTown::getTownByTownId($obj_Town->TownId);
			if($result_Town->type ==1)
			{
			$retrunUserpacket = $result_Town->data->wsGetTownData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateTown2($TownId,$TownName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newTown = new Town();
	
		$obj_newTown->TownId=$TownId;
		$obj_newTown->TownName=$TownName;
		$obj_newTown->Description=$Description;

	   
        $issuccess = DAL_manageTown::updateTown($obj_newTown);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageTown::getTownByTownId($obj_newTown->TownId);
            $obj_retResult->msg = "Town updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Town updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getTownList()
    {
        $obj_retResult = DAL_manageTown::getTownList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getTownList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageTown::getAllTown($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageTown::searchTownByTownId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Town List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TownId</th>";
		$html .= "<th>TownName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_TownList as $obj_Town)
            {               

                    $html .= $obj_Town->drawTableViewTown(); 
                
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

	public static function deleteTown($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$TownId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_TownId =0;
			
			$retResult = BL_manageTown::getTownListByTownId($TownId);
			if($retResult->type ==1)
			{
			
			$obj_Town = $retResult->data[0];			
			$obj_result2 = DAL_manageTown::deleteTown($obj_Town->TownId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_TownId = $obj_Town->TownId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Town";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Town you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Town->TownId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getTownListByTownId($TownId)
    {
        $obj_retResult = DAL_manageTown::getTownListByTownId($TownId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildTown($TownId,$ChildTownId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageTown::getTownListByTownId($ChildTownId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_TownList = $obj_retResult->data;
				$obj_Town = $arr_TownList[0];
				
				$arrParentIds = explode(",",$obj_Town->Url);
				
				foreach($arrParentIds as $TownParentId)
				{
					if($TownParentId == $TownId)
					{						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>