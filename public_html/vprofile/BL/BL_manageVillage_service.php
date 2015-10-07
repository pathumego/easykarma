<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_service.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_service.php");


class BL_manageVillage_service
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_service::addVillage_service($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_service::deleteVillage_service($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_service::updateVillage_service($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_service($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_service = new Village_service();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_service->ServiceId = $packet[1];
		$obj_newVillage_service->VillageId = $packet[2];
		$obj_newVillage_service->BusinessId = $packet[3];
		$obj_newVillage_service->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_service = DAL_manageVillage_service::addVillage_service($obj_newVillage_service);
            if ($obj_retResult_Village_service->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_service->data->wsGetVillage_serviceData();
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

    public static function addVillage_service2($ServiceId,$VillageId,$BusinessId,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_service = new Village_service();
		
		$obj_newuser->setVillage_service($ServiceId,$VillageId,$BusinessId,$Description);
       // $isExist = BL_manageVillage_service::isExist($obj_newVillage_service->id);

        if (!$isExist)
        {
            $obj_retResult_Village_service = DAL_manageVillage_service::addVillage_service($obj_newVillage_service);
            if ($obj_retResult_Village_service->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_service->data;
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
            $obj_retResult->msg = "Sorry! Village_service already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_service($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_service = new Village_service();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_service->ServiceId = $packet[0];
		$obj_Village_service->VillageId = $packet[1];
		$obj_Village_service->BusinessId = $packet[2];
		$obj_Village_service->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_service = DAL_manageVillage_service::update($obj_Village_service);

        if ($obj_retResult_Village_service->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_service updation is Success";
			$retrunUserpacket = $obj_retResult_Village_service->data->wsGetVillage_serviceData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_service updation is Failed";
			$result_Village_service = DAL_manageVillage_service::getVillage_serviceByBusinessId($obj_Village_service->BusinessId);
			if($result_Village_service->type ==1)
			{
			$retrunUserpacket = $result_Village_service->data->wsGetVillage_serviceData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_service2($ServiceId,$VillageId,$BusinessId,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_service = new Village_service();
	
		$obj_newVillage_service->ServiceId=$ServiceId;
		$obj_newVillage_service->VillageId=$VillageId;
		$obj_newVillage_service->BusinessId=$BusinessId;
		$obj_newVillage_service->Description=$Description;

	   
        $issuccess = DAL_manageVillage_service::updateVillage_service($obj_newVillage_service);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_service::getVillage_serviceByBusinessId($obj_newVillage_service->BusinessId);
            $obj_retResult->msg = "Village_service updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_service updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_serviceList()
    {
        $obj_retResult = DAL_manageVillage_service::getVillage_serviceList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_serviceList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_service::getAllVillage_service($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_service::searchVillage_serviceByBusinessId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_service List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>ServiceId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>BusinessId</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_serviceList as $obj_Village_service)
            {               

                    $html .= $obj_Village_service->drawTableViewVillage_service(); 
                
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

	public static function deleteVillage_service($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$BusinessId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_BusinessId =0;
			
			$retResult = BL_manageVillage_service::getVillage_serviceListByBusinessId($BusinessId);
			if($retResult->type ==1)
			{
			
			$obj_Village_service = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_service::deleteVillage_service($obj_Village_service->BusinessId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_BusinessId = $obj_Village_service->BusinessId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_service";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_service you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_service->BusinessId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_serviceListByBusinessId($BusinessId)
    {
        $obj_retResult = DAL_manageVillage_service::getVillage_serviceListByBusinessId($BusinessId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_service($BusinessId,$ChildBusinessId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_service::getVillage_serviceListByBusinessId($ChildBusinessId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_serviceList = $obj_retResult->data;
				$obj_Village_service = $arr_Village_serviceList[0];
				
				$arrParentIds = explode(",",$obj_Village_service->Url);
				
				foreach($arrParentIds as $Village_serviceParentId)
				{
					if($Village_serviceParentId == $BusinessId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>