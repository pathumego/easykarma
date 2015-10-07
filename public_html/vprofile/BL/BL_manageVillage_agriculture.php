<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_agriculture.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_agriculture.php");


class BL_manageVillage_agriculture
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_agriculture::addVillage_agriculture($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_agriculture::deleteVillage_agriculture($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_agriculture::updateVillage_agriculture($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_agriculture($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_agriculture = new Village_agriculture();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_agriculture->AgricultureId = $packet[1];
		$obj_newVillage_agriculture->VillageId = $packet[2];
		$obj_newVillage_agriculture->BusinessId = $packet[3];
		$obj_newVillage_agriculture->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_agriculture = DAL_manageVillage_agriculture::addVillage_agriculture($obj_newVillage_agriculture);
            if ($obj_retResult_Village_agriculture->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_agriculture->data->wsGetVillage_agricultureData();
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

    public static function addVillage_agriculture2($AgricultureId,$VillageId,$BusinessId,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_agriculture = new Village_agriculture();
		
		$obj_newuser->setVillage_agriculture($AgricultureId,$VillageId,$BusinessId,$Description);
       // $isExist = BL_manageVillage_agriculture::isExist($obj_newVillage_agriculture->id);

        if (!$isExist)
        {
            $obj_retResult_Village_agriculture = DAL_manageVillage_agriculture::addVillage_agriculture($obj_newVillage_agriculture);
            if ($obj_retResult_Village_agriculture->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_agriculture->data;
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
            $obj_retResult->msg = "Sorry! Village_agriculture already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_agriculture($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_agriculture = new Village_agriculture();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_agriculture->AgricultureId = $packet[0];
		$obj_Village_agriculture->VillageId = $packet[1];
		$obj_Village_agriculture->BusinessId = $packet[2];
		$obj_Village_agriculture->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_agriculture = DAL_manageVillage_agriculture::update($obj_Village_agriculture);

        if ($obj_retResult_Village_agriculture->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_agriculture updation is Success";
			$retrunUserpacket = $obj_retResult_Village_agriculture->data->wsGetVillage_agricultureData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_agriculture updation is Failed";
			$result_Village_agriculture = DAL_manageVillage_agriculture::getVillage_agricultureByBusinessId($obj_Village_agriculture->BusinessId);
			if($result_Village_agriculture->type ==1)
			{
			$retrunUserpacket = $result_Village_agriculture->data->wsGetVillage_agricultureData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_agriculture2($AgricultureId,$VillageId,$BusinessId,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_agriculture = new Village_agriculture();
	
		$obj_newVillage_agriculture->AgricultureId=$AgricultureId;
		$obj_newVillage_agriculture->VillageId=$VillageId;
		$obj_newVillage_agriculture->BusinessId=$BusinessId;
		$obj_newVillage_agriculture->Description=$Description;

	   
        $issuccess = DAL_manageVillage_agriculture::updateVillage_agriculture($obj_newVillage_agriculture);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_agriculture::getVillage_agricultureByBusinessId($obj_newVillage_agriculture->BusinessId);
            $obj_retResult->msg = "Village_agriculture updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_agriculture updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_agricultureList()
    {
        $obj_retResult = DAL_manageVillage_agriculture::getVillage_agricultureList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_agricultureList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_agriculture::getAllVillage_agriculture($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_agriculture::searchVillage_agricultureByBusinessId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_agriculture List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>AgricultureId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>BusinessId</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_agricultureList as $obj_Village_agriculture)
            {               

                    $html .= $obj_Village_agriculture->drawTableViewVillage_agriculture(); 
                
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

	public static function deleteVillage_agriculture($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$BusinessId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_BusinessId =0;
			
			$retResult = BL_manageVillage_agriculture::getVillage_agricultureListByBusinessId($BusinessId);
			if($retResult->type ==1)
			{
			
			$obj_Village_agriculture = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_agriculture::deleteVillage_agriculture($obj_Village_agriculture->BusinessId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_BusinessId = $obj_Village_agriculture->BusinessId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_agriculture";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_agriculture you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_agriculture->BusinessId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_agricultureListByBusinessId($BusinessId)
    {
        $obj_retResult = DAL_manageVillage_agriculture::getVillage_agricultureListByBusinessId($BusinessId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_agriculture($BusinessId,$ChildBusinessId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_agriculture::getVillage_agricultureListByBusinessId($ChildBusinessId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_agricultureList = $obj_retResult->data;
				$obj_Village_agriculture = $arr_Village_agricultureList[0];
				
				$arrParentIds = explode(",",$obj_Village_agriculture->Url);
				
				foreach($arrParentIds as $Village_agricultureParentId)
				{
					if($Village_agricultureParentId == $BusinessId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>