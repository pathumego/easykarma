<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Service.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageService.php");


class BL_manageService
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageService::addService($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageService::deleteService($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageService::updateService($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addService($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newService = new Service();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newService->ServiceId = $packet[1];
		$obj_newService->ServiceName = $packet[2];
		$obj_newService->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Service = DAL_manageService::addService($obj_newService);
            if ($obj_retResult_Service->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Service->data->wsGetServiceData();
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

    public static function addService2($ServiceId,$ServiceName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newService = new Service();
		
		$obj_newuser->setService($ServiceId,$ServiceName,$Description);
       // $isExist = BL_manageService::isExist($obj_newService->id);

        if (!$isExist)
        {
            $obj_retResult_Service = DAL_manageService::addService($obj_newService);
            if ($obj_retResult_Service->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Service->data;
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
            $obj_retResult->msg = "Sorry! Service already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateService($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Service = new Service();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Service->ServiceId = $packet[0];
		$obj_Service->ServiceName = $packet[1];
		$obj_Service->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Service = DAL_manageService::update($obj_Service);

        if ($obj_retResult_Service->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Service updation is Success";
			$retrunUserpacket = $obj_retResult_Service->data->wsGetServiceData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Service updation is Failed";
			$result_Service = DAL_manageService::getServiceByServiceId($obj_Service->ServiceId);
			if($result_Service->type ==1)
			{
			$retrunUserpacket = $result_Service->data->wsGetServiceData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateService2($ServiceId,$ServiceName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newService = new Service();
	
		$obj_newService->ServiceId=$ServiceId;
		$obj_newService->ServiceName=$ServiceName;
		$obj_newService->Description=$Description;

	   
        $issuccess = DAL_manageService::updateService($obj_newService);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageService::getServiceByServiceId($obj_newService->ServiceId);
            $obj_retResult->msg = "Service updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Service updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getServiceList()
    {
        $obj_retResult = DAL_manageService::getServiceList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getServiceList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageService::getAllService($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageService::searchServiceByServiceId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Service List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>ServiceId</th>";
		$html .= "<th>ServiceName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_ServiceList as $obj_Service)
            {               

                    $html .= $obj_Service->drawTableViewService(); 
                
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

	public static function deleteService($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$ServiceId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_ServiceId =0;
			
			$retResult = BL_manageService::getServiceListByServiceId($ServiceId);
			if($retResult->type ==1)
			{
			
			$obj_Service = $retResult->data[0];			
			$obj_result2 = DAL_manageService::deleteService($obj_Service->ServiceId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_ServiceId = $obj_Service->ServiceId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Service";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Service you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Service->ServiceId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getServiceListByServiceId($ServiceId)
    {
        $obj_retResult = DAL_manageService::getServiceListByServiceId($ServiceId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildService($ServiceId,$ChildServiceId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageService::getServiceListByServiceId($ChildServiceId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_ServiceList = $obj_retResult->data;
				$obj_Service = $arr_ServiceList[0];
				
				$arrParentIds = explode(",",$obj_Service->Url);
				
				foreach($arrParentIds as $ServiceParentId)
				{
					if($ServiceParentId == $ServiceId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>