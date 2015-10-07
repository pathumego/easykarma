<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Industrial.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageIndustrial.php");


class BL_manageIndustrial
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageIndustrial::addIndustrial($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageIndustrial::deleteIndustrial($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageIndustrial::updateIndustrial($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addIndustrial($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newIndustrial = new Industrial();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newIndustrial->IndustrialId = $packet[1];
		$obj_newIndustrial->IndustrialName = $packet[2];
		$obj_newIndustrial->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Industrial = DAL_manageIndustrial::addIndustrial($obj_newIndustrial);
            if ($obj_retResult_Industrial->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Industrial->data->wsGetIndustrialData();
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

    public static function addIndustrial2($IndustrialId,$IndustrialName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newIndustrial = new Industrial();
		
		$obj_newuser->setIndustrial($IndustrialId,$IndustrialName,$Description);
       // $isExist = BL_manageIndustrial::isExist($obj_newIndustrial->id);

        if (!$isExist)
        {
            $obj_retResult_Industrial = DAL_manageIndustrial::addIndustrial($obj_newIndustrial);
            if ($obj_retResult_Industrial->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Industrial->data;
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
            $obj_retResult->msg = "Sorry! Industrial already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateIndustrial($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Industrial = new Industrial();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Industrial->IndustrialId = $packet[0];
		$obj_Industrial->IndustrialName = $packet[1];
		$obj_Industrial->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Industrial = DAL_manageIndustrial::update($obj_Industrial);

        if ($obj_retResult_Industrial->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Industrial updation is Success";
			$retrunUserpacket = $obj_retResult_Industrial->data->wsGetIndustrialData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Industrial updation is Failed";
			$result_Industrial = DAL_manageIndustrial::getIndustrialByIndustrialId($obj_Industrial->IndustrialId);
			if($result_Industrial->type ==1)
			{
			$retrunUserpacket = $result_Industrial->data->wsGetIndustrialData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateIndustrial2($IndustrialId,$IndustrialName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newIndustrial = new Industrial();
	
		$obj_newIndustrial->IndustrialId=$IndustrialId;
		$obj_newIndustrial->IndustrialName=$IndustrialName;
		$obj_newIndustrial->Description=$Description;

	   
        $issuccess = DAL_manageIndustrial::updateIndustrial($obj_newIndustrial);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageIndustrial::getIndustrialByIndustrialId($obj_newIndustrial->IndustrialId);
            $obj_retResult->msg = "Industrial updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Industrial updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getIndustrialList()
    {
        $obj_retResult = DAL_manageIndustrial::getIndustrialList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getIndustrialList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageIndustrial::getAllIndustrial($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageIndustrial::searchIndustrialByIndustrialId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Industrial List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>IndustrialId</th>";
		$html .= "<th>IndustrialName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_IndustrialList as $obj_Industrial)
            {               

                    $html .= $obj_Industrial->drawTableViewIndustrial(); 
                
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

	public static function deleteIndustrial($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$IndustrialId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_IndustrialId =0;
			
			$retResult = BL_manageIndustrial::getIndustrialListByIndustrialId($IndustrialId);
			if($retResult->type ==1)
			{
			
			$obj_Industrial = $retResult->data[0];			
			$obj_result2 = DAL_manageIndustrial::deleteIndustrial($obj_Industrial->IndustrialId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_IndustrialId = $obj_Industrial->IndustrialId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Industrial";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Industrial you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Industrial->IndustrialId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getIndustrialListByIndustrialId($IndustrialId)
    {
        $obj_retResult = DAL_manageIndustrial::getIndustrialListByIndustrialId($IndustrialId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildIndustrial($IndustrialId,$ChildIndustrialId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageIndustrial::getIndustrialListByIndustrialId($ChildIndustrialId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_IndustrialList = $obj_retResult->data;
				$obj_Industrial = $arr_IndustrialList[0];
				
				$arrParentIds = explode(",",$obj_Industrial->Url);
				
				foreach($arrParentIds as $IndustrialParentId)
				{
					if($IndustrialParentId == $IndustrialId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>