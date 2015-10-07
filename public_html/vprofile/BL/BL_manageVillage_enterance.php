<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_enterance.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_enterance.php");


class BL_manageVillage_enterance
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_enterance::addVillage_enterance($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_enterance::deleteVillage_enterance($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_enterance::updateVillage_enterance($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_enterance($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_enterance = new Village_enterance();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_enterance->TblId = $packet[1];
		$obj_newVillage_enterance->VillageId = $packet[2];
		$obj_newVillage_enterance->Direction = $packet[3];
		$obj_newVillage_enterance->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_enterance = DAL_manageVillage_enterance::addVillage_enterance($obj_newVillage_enterance);
            if ($obj_retResult_Village_enterance->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_enterance->data->wsGetVillage_enteranceData();
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

    public static function addVillage_enterance2($TblId,$VillageId,$Direction,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_enterance = new Village_enterance();
		
		$obj_newuser->setVillage_enterance($TblId,$VillageId,$Direction,$Description);
       // $isExist = BL_manageVillage_enterance::isExist($obj_newVillage_enterance->id);

        if (!$isExist)
        {
            $obj_retResult_Village_enterance = DAL_manageVillage_enterance::addVillage_enterance($obj_newVillage_enterance);
            if ($obj_retResult_Village_enterance->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_enterance->data;
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
            $obj_retResult->msg = "Sorry! Village_enterance already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_enterance($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_enterance = new Village_enterance();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_enterance->TblId = $packet[0];
		$obj_Village_enterance->VillageId = $packet[1];
		$obj_Village_enterance->Direction = $packet[2];
		$obj_Village_enterance->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_enterance = DAL_manageVillage_enterance::update($obj_Village_enterance);

        if ($obj_retResult_Village_enterance->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_enterance updation is Success";
			$retrunUserpacket = $obj_retResult_Village_enterance->data->wsGetVillage_enteranceData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_enterance updation is Failed";
			$result_Village_enterance = DAL_manageVillage_enterance::getVillage_enteranceByTblId($obj_Village_enterance->TblId);
			if($result_Village_enterance->type ==1)
			{
			$retrunUserpacket = $result_Village_enterance->data->wsGetVillage_enteranceData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_enterance2($TblId,$VillageId,$Direction,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_enterance = new Village_enterance();
	
		$obj_newVillage_enterance->TblId=$TblId;
		$obj_newVillage_enterance->VillageId=$VillageId;
		$obj_newVillage_enterance->Direction=$Direction;
		$obj_newVillage_enterance->Description=$Description;

	   
        $issuccess = DAL_manageVillage_enterance::updateVillage_enterance($obj_newVillage_enterance);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_enterance::getVillage_enteranceByTblId($obj_newVillage_enterance->TblId);
            $obj_retResult->msg = "Village_enterance updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_enterance updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_enteranceList()
    {
        $obj_retResult = DAL_manageVillage_enterance::getVillage_enteranceList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_enteranceList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_enterance::getAllVillage_enterance($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_enterance::searchVillage_enteranceByTblId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_enterance List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TblId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>Direction</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_enteranceList as $obj_Village_enterance)
            {               

                    $html .= $obj_Village_enterance->drawTableViewVillage_enterance(); 
                
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

	public static function deleteVillage_enterance($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$TblId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_TblId =0;
			
			$retResult = BL_manageVillage_enterance::getVillage_enteranceListByTblId($TblId);
			if($retResult->type ==1)
			{
			
			$obj_Village_enterance = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_enterance::deleteVillage_enterance($obj_Village_enterance->TblId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_TblId = $obj_Village_enterance->TblId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_enterance";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_enterance you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_enterance->TblId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_enteranceListByTblId($TblId)
    {
        $obj_retResult = DAL_manageVillage_enterance::getVillage_enteranceListByTblId($TblId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_enterance($TblId,$ChildTblId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_enterance::getVillage_enteranceListByTblId($ChildTblId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_enteranceList = $obj_retResult->data;
				$obj_Village_enterance = $arr_Village_enteranceList[0];
				
				$arrParentIds = explode(",",$obj_Village_enterance->Url);
				
				foreach($arrParentIds as $Village_enteranceParentId)
				{
					if($Village_enteranceParentId == $TblId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>