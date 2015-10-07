<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Agriculture.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageAgriculture.php");


class BL_manageAgriculture
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageAgriculture::addAgriculture($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageAgriculture::deleteAgriculture($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageAgriculture::updateAgriculture($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addAgriculture($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newAgriculture = new Agriculture();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newAgriculture->AgricultureId = $packet[1];
		$obj_newAgriculture->AgricultureName = $packet[2];
		$obj_newAgriculture->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Agriculture = DAL_manageAgriculture::addAgriculture($obj_newAgriculture);
            if ($obj_retResult_Agriculture->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Agriculture->data->wsGetAgricultureData();
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

    public static function addAgriculture2($AgricultureId,$AgricultureName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newAgriculture = new Agriculture();
		
		$obj_newuser->setAgriculture($AgricultureId,$AgricultureName,$Description);
       // $isExist = BL_manageAgriculture::isExist($obj_newAgriculture->id);

        if (!$isExist)
        {
            $obj_retResult_Agriculture = DAL_manageAgriculture::addAgriculture($obj_newAgriculture);
            if ($obj_retResult_Agriculture->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Agriculture->data;
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
            $obj_retResult->msg = "Sorry! Agriculture already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateAgriculture($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Agriculture = new Agriculture();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Agriculture->AgricultureId = $packet[0];
		$obj_Agriculture->AgricultureName = $packet[1];
		$obj_Agriculture->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Agriculture = DAL_manageAgriculture::update($obj_Agriculture);

        if ($obj_retResult_Agriculture->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Agriculture updation is Success";
			$retrunUserpacket = $obj_retResult_Agriculture->data->wsGetAgricultureData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Agriculture updation is Failed";
			$result_Agriculture = DAL_manageAgriculture::getAgricultureByAgricultureId($obj_Agriculture->AgricultureId);
			if($result_Agriculture->type ==1)
			{
			$retrunUserpacket = $result_Agriculture->data->wsGetAgricultureData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateAgriculture2($AgricultureId,$AgricultureName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newAgriculture = new Agriculture();
	
		$obj_newAgriculture->AgricultureId=$AgricultureId;
		$obj_newAgriculture->AgricultureName=$AgricultureName;
		$obj_newAgriculture->Description=$Description;

	   
        $issuccess = DAL_manageAgriculture::updateAgriculture($obj_newAgriculture);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageAgriculture::getAgricultureByAgricultureId($obj_newAgriculture->AgricultureId);
            $obj_retResult->msg = "Agriculture updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Agriculture updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getAgricultureList()
    {
        $obj_retResult = DAL_manageAgriculture::getAgricultureList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getAgricultureList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageAgriculture::getAllAgriculture($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageAgriculture::searchAgricultureByAgricultureId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Agriculture List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>AgricultureId</th>";
		$html .= "<th>AgricultureName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_AgricultureList as $obj_Agriculture)
            {               

                    $html .= $obj_Agriculture->drawTableViewAgriculture(); 
                
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

	public static function deleteAgriculture($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$AgricultureId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_AgricultureId =0;
			
			$retResult = BL_manageAgriculture::getAgricultureListByAgricultureId($AgricultureId);
			if($retResult->type ==1)
			{
			
			$obj_Agriculture = $retResult->data[0];			
			$obj_result2 = DAL_manageAgriculture::deleteAgriculture($obj_Agriculture->AgricultureId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_AgricultureId = $obj_Agriculture->AgricultureId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Agriculture";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Agriculture you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Agriculture->AgricultureId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getAgricultureListByAgricultureId($AgricultureId)
    {
        $obj_retResult = DAL_manageAgriculture::getAgricultureListByAgricultureId($AgricultureId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildAgriculture($AgricultureId,$ChildAgricultureId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageAgriculture::getAgricultureListByAgricultureId($ChildAgricultureId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_AgricultureList = $obj_retResult->data;
				$obj_Agriculture = $arr_AgricultureList[0];
				
				$arrParentIds = explode(",",$obj_Agriculture->Url);
				
				foreach($arrParentIds as $AgricultureParentId)
				{
					if($AgricultureParentId == $AgricultureId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>