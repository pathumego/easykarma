<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Trading.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTrading.php");


class BL_manageTrading
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageTrading::addTrading($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageTrading::deleteTrading($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageTrading::updateTrading($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addTrading($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newTrading = new Trading();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newTrading->tradingId = $packet[1];
		$obj_newTrading->tradingName = $packet[2];
		$obj_newTrading->tradingType = $packet[3];
		$obj_newTrading->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Trading = DAL_manageTrading::addTrading($obj_newTrading);
            if ($obj_retResult_Trading->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Trading->data->wsGetTradingData();
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

    public static function addTrading2($tradingId,$tradingName,$tradingType,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newTrading = new Trading();
		
		$obj_newuser->setTrading($tradingId,$tradingName,$tradingType,$Description);
       // $isExist = BL_manageTrading::isExist($obj_newTrading->id);

        if (!$isExist)
        {
            $obj_retResult_Trading = DAL_manageTrading::addTrading($obj_newTrading);
            if ($obj_retResult_Trading->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Trading->data;
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
            $obj_retResult->msg = "Sorry! Trading already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateTrading($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Trading = new Trading();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Trading->tradingId = $packet[0];
		$obj_Trading->tradingName = $packet[1];
		$obj_Trading->tradingType = $packet[2];
		$obj_Trading->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Trading = DAL_manageTrading::update($obj_Trading);

        if ($obj_retResult_Trading->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Trading updation is Success";
			$retrunUserpacket = $obj_retResult_Trading->data->wsGetTradingData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Trading updation is Failed";
			$result_Trading = DAL_manageTrading::getTradingBytradingId($obj_Trading->tradingId);
			if($result_Trading->type ==1)
			{
			$retrunUserpacket = $result_Trading->data->wsGetTradingData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateTrading2($tradingId,$tradingName,$tradingType,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newTrading = new Trading();
	
		$obj_newTrading->tradingId=$tradingId;
		$obj_newTrading->tradingName=$tradingName;
		$obj_newTrading->tradingType=$tradingType;
		$obj_newTrading->Description=$Description;

	   
        $issuccess = DAL_manageTrading::updateTrading($obj_newTrading);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageTrading::getTradingBytradingId($obj_newTrading->tradingId);
            $obj_retResult->msg = "Trading updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Trading updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getTradingList()
    {
        $obj_retResult = DAL_manageTrading::getTradingList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getTradingList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageTrading::getAllTrading($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageTrading::searchTradingBytradingId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Trading List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>tradingId</th>";
		$html .= "<th>tradingName</th>";
		$html .= "<th>tradingType</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_TradingList as $obj_Trading)
            {               

                    $html .= $obj_Trading->drawTableViewTrading(); 
                
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

	public static function deleteTrading($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$tradingId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_tradingId =0;
			
			$retResult = BL_manageTrading::getTradingListBytradingId($tradingId);
			if($retResult->type ==1)
			{
			
			$obj_Trading = $retResult->data[0];			
			$obj_result2 = DAL_manageTrading::deleteTrading($obj_Trading->tradingId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_tradingId = $obj_Trading->tradingId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Trading";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Trading you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Trading->tradingId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getTradingListBytradingId($tradingId)
    {
        $obj_retResult = DAL_manageTrading::getTradingListBytradingId($tradingId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildTrading($tradingId,$ChildtradingId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageTrading::getTradingListBytradingId($ChildtradingId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_TradingList = $obj_retResult->data;
				$obj_Trading = $arr_TradingList[0];
				
				$arrParentIds = explode(",",$obj_Trading->Url);
				
				foreach($arrParentIds as $TradingParentId)
				{
					if($TradingParentId == $tradingId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>