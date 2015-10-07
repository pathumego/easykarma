<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_industrial.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_industrial.php");


class BL_manageVillage_industrial
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_industrial::addVillage_industrial($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_industrial::deleteVillage_industrial($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_industrial::updateVillage_industrial($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_industrial($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_industrial = new Village_industrial();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_industrial->IndustrialId = $packet[1];
		$obj_newVillage_industrial->VillageId = $packet[2];
		$obj_newVillage_industrial->BusinessId = $packet[3];
		$obj_newVillage_industrial->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_industrial = DAL_manageVillage_industrial::addVillage_industrial($obj_newVillage_industrial);
            if ($obj_retResult_Village_industrial->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_industrial->data->wsGetVillage_industrialData();
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

    public static function addVillage_industrial2($IndustrialId,$VillageId,$BusinessId,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_industrial = new Village_industrial();
		
		$obj_newuser->setVillage_industrial($IndustrialId,$VillageId,$BusinessId,$Description);
       // $isExist = BL_manageVillage_industrial::isExist($obj_newVillage_industrial->id);

        if (!$isExist)
        {
            $obj_retResult_Village_industrial = DAL_manageVillage_industrial::addVillage_industrial($obj_newVillage_industrial);
            if ($obj_retResult_Village_industrial->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_industrial->data;
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
            $obj_retResult->msg = "Sorry! Village_industrial already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_industrial($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_industrial = new Village_industrial();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_industrial->IndustrialId = $packet[0];
		$obj_Village_industrial->VillageId = $packet[1];
		$obj_Village_industrial->BusinessId = $packet[2];
		$obj_Village_industrial->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_industrial = DAL_manageVillage_industrial::update($obj_Village_industrial);

        if ($obj_retResult_Village_industrial->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_industrial updation is Success";
			$retrunUserpacket = $obj_retResult_Village_industrial->data->wsGetVillage_industrialData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_industrial updation is Failed";
			$result_Village_industrial = DAL_manageVillage_industrial::getVillage_industrialByBusinessId($obj_Village_industrial->BusinessId);
			if($result_Village_industrial->type ==1)
			{
			$retrunUserpacket = $result_Village_industrial->data->wsGetVillage_industrialData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_industrial2($IndustrialId,$VillageId,$BusinessId,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_industrial = new Village_industrial();
	
		$obj_newVillage_industrial->IndustrialId=$IndustrialId;
		$obj_newVillage_industrial->VillageId=$VillageId;
		$obj_newVillage_industrial->BusinessId=$BusinessId;
		$obj_newVillage_industrial->Description=$Description;

	   
        $issuccess = DAL_manageVillage_industrial::updateVillage_industrial($obj_newVillage_industrial);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_industrial::getVillage_industrialByBusinessId($obj_newVillage_industrial->BusinessId);
            $obj_retResult->msg = "Village_industrial updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_industrial updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_industrialList()
    {
        $obj_retResult = DAL_manageVillage_industrial::getVillage_industrialList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_industrialList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_industrial::getAllVillage_industrial($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_industrial::searchVillage_industrialByBusinessId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_industrial List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>IndustrialId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>BusinessId</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_industrialList as $obj_Village_industrial)
            {               

                    $html .= $obj_Village_industrial->drawTableViewVillage_industrial(); 
                
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

	public static function deleteVillage_industrial($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$BusinessId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_BusinessId =0;
			
			$retResult = BL_manageVillage_industrial::getVillage_industrialListByBusinessId($BusinessId);
			if($retResult->type ==1)
			{
			
			$obj_Village_industrial = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_industrial::deleteVillage_industrial($obj_Village_industrial->BusinessId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_BusinessId = $obj_Village_industrial->BusinessId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_industrial";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_industrial you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_industrial->BusinessId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_industrialListByBusinessId($BusinessId)
    {
        $obj_retResult = DAL_manageVillage_industrial::getVillage_industrialListByBusinessId($BusinessId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_industrial($BusinessId,$ChildBusinessId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_industrial::getVillage_industrialListByBusinessId($ChildBusinessId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_industrialList = $obj_retResult->data;
				$obj_Village_industrial = $arr_Village_industrialList[0];
				
				$arrParentIds = explode(",",$obj_Village_industrial->Url);
				
				foreach($arrParentIds as $Village_industrialParentId)
				{
					if($Village_industrialParentId == $BusinessId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>