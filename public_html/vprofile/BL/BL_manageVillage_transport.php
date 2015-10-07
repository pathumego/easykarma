<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_transport.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_transport.php");


class BL_manageVillage_transport
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_transport::addVillage_transport($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_transport::deleteVillage_transport($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_transport::updateVillage_transport($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_transport($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_transport = new Village_transport();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_transport->TransportId = $packet[1];
		$obj_newVillage_transport->VillageId = $packet[2];
		$obj_newVillage_transport->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_transport = DAL_manageVillage_transport::addVillage_transport($obj_newVillage_transport);
            if ($obj_retResult_Village_transport->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_transport->data->wsGetVillage_transportData();
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

    public static function addVillage_transport2($TransportId,$VillageId,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_transport = new Village_transport();
		
		$obj_newuser->setVillage_transport($TransportId,$VillageId,$Description);
       // $isExist = BL_manageVillage_transport::isExist($obj_newVillage_transport->id);

        if (!$isExist)
        {
            $obj_retResult_Village_transport = DAL_manageVillage_transport::addVillage_transport($obj_newVillage_transport);
            if ($obj_retResult_Village_transport->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_transport->data;
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
            $obj_retResult->msg = "Sorry! Village_transport already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_transport($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_transport = new Village_transport();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_transport->TransportId = $packet[0];
		$obj_Village_transport->VillageId = $packet[1];
		$obj_Village_transport->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_transport = DAL_manageVillage_transport::update($obj_Village_transport);

        if ($obj_retResult_Village_transport->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_transport updation is Success";
			$retrunUserpacket = $obj_retResult_Village_transport->data->wsGetVillage_transportData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_transport updation is Failed";
			$result_Village_transport = DAL_manageVillage_transport::getVillage_transportByVillageId($obj_Village_transport->VillageId);
			if($result_Village_transport->type ==1)
			{
			$retrunUserpacket = $result_Village_transport->data->wsGetVillage_transportData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_transport2($TransportId,$VillageId,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_transport = new Village_transport();
	
		$obj_newVillage_transport->TransportId=$TransportId;
		$obj_newVillage_transport->VillageId=$VillageId;
		$obj_newVillage_transport->Description=$Description;

	   
        $issuccess = DAL_manageVillage_transport::updateVillage_transport($obj_newVillage_transport);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_transport::getVillage_transportByVillageId($obj_newVillage_transport->VillageId);
            $obj_retResult->msg = "Village_transport updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_transport updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_transportList()
    {
        $obj_retResult = DAL_manageVillage_transport::getVillage_transportList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_transportList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_transport::getAllVillage_transport($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_transport::searchVillage_transportByVillageId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_transport List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TransportId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_transportList as $obj_Village_transport)
            {               

                    $html .= $obj_Village_transport->drawTableViewVillage_transport(); 
                
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

	public static function deleteVillage_transport($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$VillageId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_VillageId =0;
			
			$retResult = BL_manageVillage_transport::getVillage_transportListByVillageId($VillageId);
			if($retResult->type ==1)
			{
			
			$obj_Village_transport = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_transport::deleteVillage_transport($obj_Village_transport->VillageId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_VillageId = $obj_Village_transport->VillageId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_transport";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_transport you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_transport->VillageId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_transportListByVillageId($VillageId)
    {
        $obj_retResult = DAL_manageVillage_transport::getVillage_transportListByVillageId($VillageId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_transport($VillageId,$ChildVillageId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_transport::getVillage_transportListByVillageId($ChildVillageId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_transportList = $obj_retResult->data;
				$obj_Village_transport = $arr_Village_transportList[0];
				
				$arrParentIds = explode(",",$obj_Village_transport->Url);
				
				foreach($arrParentIds as $Village_transportParentId)
				{
					if($Village_transportParentId == $VillageId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>