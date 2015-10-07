<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_traditionalknowledge.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_traditionalknowledge.php");


class BL_manageVillage_traditionalknowledge
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_traditionalknowledge::addVillage_traditionalknowledge($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_traditionalknowledge::deleteVillage_traditionalknowledge($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_traditionalknowledge::updateVillage_traditionalknowledge($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_traditionalknowledge($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_traditionalknowledge = new Village_traditionalknowledge();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_traditionalknowledge->TblId = $packet[1];
		$obj_newVillage_traditionalknowledge->VillageId = $packet[2];
		$obj_newVillage_traditionalknowledge->TraditionalKnowledgeCategoryID = $packet[3];
		$obj_newVillage_traditionalknowledge->Discription = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_traditionalknowledge = DAL_manageVillage_traditionalknowledge::addVillage_traditionalknowledge($obj_newVillage_traditionalknowledge);
            if ($obj_retResult_Village_traditionalknowledge->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_traditionalknowledge->data->wsGetVillage_traditionalknowledgeData();
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

    public static function addVillage_traditionalknowledge2($TblId,$VillageId,$TraditionalKnowledgeCategoryID,$Discription)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_traditionalknowledge = new Village_traditionalknowledge();
		
		$obj_newuser->setVillage_traditionalknowledge($TblId,$VillageId,$TraditionalKnowledgeCategoryID,$Discription);
       // $isExist = BL_manageVillage_traditionalknowledge::isExist($obj_newVillage_traditionalknowledge->id);

        if (!$isExist)
        {
            $obj_retResult_Village_traditionalknowledge = DAL_manageVillage_traditionalknowledge::addVillage_traditionalknowledge($obj_newVillage_traditionalknowledge);
            if ($obj_retResult_Village_traditionalknowledge->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_traditionalknowledge->data;
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
            $obj_retResult->msg = "Sorry! Village_traditionalknowledge already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_traditionalknowledge($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_traditionalknowledge = new Village_traditionalknowledge();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_traditionalknowledge->TblId = $packet[0];
		$obj_Village_traditionalknowledge->VillageId = $packet[1];
		$obj_Village_traditionalknowledge->TraditionalKnowledgeCategoryID = $packet[2];
		$obj_Village_traditionalknowledge->Discription = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_traditionalknowledge = DAL_manageVillage_traditionalknowledge::update($obj_Village_traditionalknowledge);

        if ($obj_retResult_Village_traditionalknowledge->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_traditionalknowledge updation is Success";
			$retrunUserpacket = $obj_retResult_Village_traditionalknowledge->data->wsGetVillage_traditionalknowledgeData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_traditionalknowledge updation is Failed";
			$result_Village_traditionalknowledge = DAL_manageVillage_traditionalknowledge::getVillage_traditionalknowledgeByTblId($obj_Village_traditionalknowledge->TblId);
			if($result_Village_traditionalknowledge->type ==1)
			{
			$retrunUserpacket = $result_Village_traditionalknowledge->data->wsGetVillage_traditionalknowledgeData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_traditionalknowledge2($TblId,$VillageId,$TraditionalKnowledgeCategoryID,$Discription)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_traditionalknowledge = new Village_traditionalknowledge();
	
		$obj_newVillage_traditionalknowledge->TblId=$TblId;
		$obj_newVillage_traditionalknowledge->VillageId=$VillageId;
		$obj_newVillage_traditionalknowledge->TraditionalKnowledgeCategoryID=$TraditionalKnowledgeCategoryID;
		$obj_newVillage_traditionalknowledge->Discription=$Discription;

	   
        $issuccess = DAL_manageVillage_traditionalknowledge::updateVillage_traditionalknowledge($obj_newVillage_traditionalknowledge);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_traditionalknowledge::getVillage_traditionalknowledgeByTblId($obj_newVillage_traditionalknowledge->TblId);
            $obj_retResult->msg = "Village_traditionalknowledge updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_traditionalknowledge updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_traditionalknowledgeList()
    {
        $obj_retResult = DAL_manageVillage_traditionalknowledge::getVillage_traditionalknowledgeList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_traditionalknowledgeList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_traditionalknowledge::getAllVillage_traditionalknowledge($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_traditionalknowledge::searchVillage_traditionalknowledgeByTblId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_traditionalknowledge List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TblId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>TraditionalKnowledgeCategoryID</th>";
		$html .= "<th>Discription</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_traditionalknowledgeList as $obj_Village_traditionalknowledge)
            {               

                    $html .= $obj_Village_traditionalknowledge->drawTableViewVillage_traditionalknowledge(); 
                
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

	public static function deleteVillage_traditionalknowledge($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$TblId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_TblId =0;
			
			$retResult = BL_manageVillage_traditionalknowledge::getVillage_traditionalknowledgeListByTblId($TblId);
			if($retResult->type ==1)
			{
			
			$obj_Village_traditionalknowledge = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_traditionalknowledge::deleteVillage_traditionalknowledge($obj_Village_traditionalknowledge->TblId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_TblId = $obj_Village_traditionalknowledge->TblId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_traditionalknowledge";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_traditionalknowledge you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_traditionalknowledge->TblId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_traditionalknowledgeListByTblId($TblId)
    {
        $obj_retResult = DAL_manageVillage_traditionalknowledge::getVillage_traditionalknowledgeListByTblId($TblId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_traditionalknowledge($TblId,$ChildTblId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_traditionalknowledge::getVillage_traditionalknowledgeListByTblId($ChildTblId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_traditionalknowledgeList = $obj_retResult->data;
				$obj_Village_traditionalknowledge = $arr_Village_traditionalknowledgeList[0];
				
				$arrParentIds = explode(",",$obj_Village_traditionalknowledge->Url);
				
				foreach($arrParentIds as $Village_traditionalknowledgeParentId)
				{
					if($Village_traditionalknowledgeParentId == $TblId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>