<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Transport.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTransport.php");


class BL_manageTransport
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageTransport::addTransport($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageTransport::deleteTransport($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageTransport::updateTransport($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addTransport($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newTransport = new Transport();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newTransport->TransportId = $packet[1];
		$obj_newTransport->TransportName = $packet[2];
		$obj_newTransport->TransportType = $packet[3];
		$obj_newTransport->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Transport = DAL_manageTransport::addTransport($obj_newTransport);
            if ($obj_retResult_Transport->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Transport->data->wsGetTransportData();
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

    public static function addTransport2($TransportId,$TransportName,$TransportType,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newTransport = new Transport();
		
		$obj_newuser->setTransport($TransportId,$TransportName,$TransportType,$Description);
       // $isExist = BL_manageTransport::isExist($obj_newTransport->id);

        if (!$isExist)
        {
            $obj_retResult_Transport = DAL_manageTransport::addTransport($obj_newTransport);
            if ($obj_retResult_Transport->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Transport->data;
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
            $obj_retResult->msg = "Sorry! Transport already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateTransport($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Transport = new Transport();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Transport->TransportId = $packet[0];
		$obj_Transport->TransportName = $packet[1];
		$obj_Transport->TransportType = $packet[2];
		$obj_Transport->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Transport = DAL_manageTransport::update($obj_Transport);

        if ($obj_retResult_Transport->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Transport updation is Success";
			$retrunUserpacket = $obj_retResult_Transport->data->wsGetTransportData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Transport updation is Failed";
			$result_Transport = DAL_manageTransport::getTransportByTransportId($obj_Transport->TransportId);
			if($result_Transport->type ==1)
			{
			$retrunUserpacket = $result_Transport->data->wsGetTransportData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateTransport2($TransportId,$TransportName,$TransportType,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newTransport = new Transport();
	
		$obj_newTransport->TransportId=$TransportId;
		$obj_newTransport->TransportName=$TransportName;
		$obj_newTransport->TransportType=$TransportType;
		$obj_newTransport->Description=$Description;

	   
        $issuccess = DAL_manageTransport::updateTransport($obj_newTransport);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageTransport::getTransportByTransportId($obj_newTransport->TransportId);
            $obj_retResult->msg = "Transport updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Transport updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getTransportList()
    {
        $obj_retResult = DAL_manageTransport::getTransportList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getTransportList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageTransport::getAllTransport($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageTransport::searchTransportByTransportId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Transport List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TransportId</th>";
		$html .= "<th>TransportName</th>";
		$html .= "<th>TransportType</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_TransportList as $obj_Transport)
            {               

                    $html .= $obj_Transport->drawTableViewTransport(); 
                
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

	public static function deleteTransport($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$TransportId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_TransportId =0;
			
			$retResult = BL_manageTransport::getTransportListByTransportId($TransportId);
			if($retResult->type ==1)
			{
			
			$obj_Transport = $retResult->data[0];			
			$obj_result2 = DAL_manageTransport::deleteTransport($obj_Transport->TransportId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_TransportId = $obj_Transport->TransportId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Transport";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Transport you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Transport->TransportId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getTransportListByTransportId($TransportId)
    {
        $obj_retResult = DAL_manageTransport::getTransportListByTransportId($TransportId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildTransport($TransportId,$ChildTransportId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageTransport::getTransportListByTransportId($ChildTransportId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_TransportList = $obj_retResult->data;
				$obj_Transport = $arr_TransportList[0];
				
				$arrParentIds = explode(",",$obj_Transport->Url);
				
				foreach($arrParentIds as $TransportParentId)
				{
					if($TransportParentId == $TransportId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>