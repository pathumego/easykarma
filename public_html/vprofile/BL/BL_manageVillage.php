<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage.php");


class BL_manageVillage
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage::addVillage($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage::deleteVillage($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage::updateVillage($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage = new Village();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage->VillageId = $packet[1];
		$obj_newVillage->Name = $packet[2];
		$obj_newVillage->VillageNumber = $packet[3] == "" ? 0 : $packet[3] ;
		$obj_newVillage->AgaDevision = $packet[4];
		$obj_newVillage->District = $packet[5];
		$obj_newVillage->Province = $packet[6];
		$obj_newVillage->GeogrophyTypeId = $packet[7] == "" ? 0 :$packet[7] ;
		$obj_newVillage->ForestTypeId = $packet[8] == "" ? 0 :$packet[8];
		$obj_newVillage->ForestDescription = $packet[9];
		$obj_newVillage->TraditionalKnowledge = $packet[10];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village = DAL_manageVillage::addVillage($obj_newVillage);
            if ($obj_retResult_Village->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village->data->wsGetVillageData();
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

    public static function addVillage2($VillageId,$Name,$VillageNumber,$AgaDevision,$District,$Province,$GeogrophyTypeId,$ForestTypeId,$ForestDescription,$TraditionalKnowledge)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage = new Village();
		
		$obj_newuser->setVillage($VillageId,$Name,$VillageNumber,$AgaDevision,$District,$Province,$GeogrophyTypeId,$ForestTypeId,$ForestDescription,$TraditionalKnowledge);
       // $isExist = BL_manageVillage::isExist($obj_newVillage->id);

        if (!$isExist)
        {
            $obj_retResult_Village = DAL_manageVillage::addVillage($obj_newVillage);
            if ($obj_retResult_Village->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village->data;
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
            $obj_retResult->msg = "Sorry! Village already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village = new Village();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village->VillageId = $packet[0];
		$obj_Village->Name = $packet[1];
		$obj_Village->VillageNumber = $packet[2];
		$obj_Village->AgaDevision = $packet[3];
		$obj_Village->District = $packet[4];
		$obj_Village->Province = $packet[5];
		$obj_Village->GeogrophyTypeId = $packet[6];
		$obj_Village->ForestTypeId = $packet[7];
		$obj_Village->ForestDescription = $packet[8];
		$obj_Village->TraditionalKnowledge = $packet[9];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village = DAL_manageVillage::update($obj_Village);

        if ($obj_retResult_Village->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village updation is Success";
			$retrunUserpacket = $obj_retResult_Village->data->wsGetVillageData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village updation is Failed";
			$result_Village = DAL_manageVillage::getVillageByVillageId($obj_Village->VillageId);
			if($result_Village->type ==1)
			{
			$retrunUserpacket = $result_Village->data->wsGetVillageData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage2($VillageId,$Name,$VillageNumber,$AgaDevision,$District,$Province,$GeogrophyTypeId,$ForestTypeId,$ForestDescription,$TraditionalKnowledge)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage = new Village();
	
		$obj_newVillage->VillageId=$VillageId;
		$obj_newVillage->Name=$Name;
		$obj_newVillage->VillageNumber=$VillageNumber;
		$obj_newVillage->AgaDevision=$AgaDevision;
		$obj_newVillage->District=$District;
		$obj_newVillage->Province=$Province;
		$obj_newVillage->GeogrophyTypeId=$GeogrophyTypeId;
		$obj_newVillage->ForestTypeId=$ForestTypeId;
		$obj_newVillage->ForestDescription=$ForestDescription;
		$obj_newVillage->TraditionalKnowledge=$TraditionalKnowledge;

	   
        $issuccess = DAL_manageVillage::updateVillage($obj_newVillage);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage::getVillageByVillageId($obj_newVillage->VillageId);
            $obj_retResult->msg = "Village updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillageList()
    {
        $obj_retResult = DAL_manageVillage::getVillageList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillageList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage::getAllVillage($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage::searchVillageByVillageId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>VillageId</th>";
		$html .= "<th>Name</th>";
		$html .= "<th>VillageNumber</th>";
		$html .= "<th>AgaDevision</th>";
		$html .= "<th>District</th>";
		$html .= "<th>Province</th>";
		$html .= "<th>GeogrophyTypeId</th>";
		$html .= "<th>ForestTypeId</th>";
		$html .= "<th>ForestDescription</th>";
		$html .= "<th>TraditionalKnowledge</th>";

		$html .= "</tr>";
		
            foreach ($arr_VillageList as $obj_Village)
            {               

                    $html .= $obj_Village->drawTableViewVillage(); 
                
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

	public static function deleteVillage($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$VillageId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_VillageId =0;
			
			$retResult = BL_manageVillage::getVillageListByVillageId($VillageId);
			if($retResult->type ==1)
			{
			
			$obj_Village = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage::deleteVillage($obj_Village->VillageId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_VillageId = $obj_Village->VillageId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village->VillageId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillageListByVillageId($VillageId)
    {
        $obj_retResult = DAL_manageVillage::getVillageListByVillageId($VillageId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage($VillageId,$ChildVillageId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage::getVillageListByVillageId($ChildVillageId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_VillageList = $obj_retResult->data;
				$obj_Village = $arr_VillageList[0];
				
				$arrParentIds = explode(",",$obj_Village->Url);
				
				foreach($arrParentIds as $VillageParentId)
				{
					if($VillageParentId == $VillageId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>