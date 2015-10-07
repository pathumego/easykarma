<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Society.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageSociety.php");


class BL_manageSociety
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageSociety::addSociety($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageSociety::deleteSociety($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageSociety::updateSociety($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addSociety($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newSociety = new Society();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newSociety->SocietyId = $packet[1];
		$obj_newSociety->Name = $packet[2];
		$obj_newSociety->Description = $packet[3];
		$obj_newSociety->Mission = $packet[4];
		$obj_newSociety->SocietyTypeId = $packet[5]== "" ? 0 :$packet[5];
		$obj_newSociety->SocietyAddress = $packet[6];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Society = DAL_manageSociety::addSociety($obj_newSociety);
            if ($obj_retResult_Society->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Society->data->wsGetSocietyData();
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

    public static function addSociety2($SocietyId,$Name,$Description,$Mission,$SocietyTypeId,$SocietyAddress)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newSociety = new Society();
		
		$obj_newuser->setSociety($SocietyId,$Name,$Description,$Mission,$SocietyTypeId,$SocietyAddress);
       // $isExist = BL_manageSociety::isExist($obj_newSociety->id);

        if (!$isExist)
        {
            $obj_retResult_Society = DAL_manageSociety::addSociety($obj_newSociety);
            if ($obj_retResult_Society->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Society->data;
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
            $obj_retResult->msg = "Sorry! Society already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateSociety($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Society = new Society();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Society->SocietyId = $packet[0];
		$obj_Society->Name = $packet[1];
		$obj_Society->Description = $packet[2];
		$obj_Society->Mission = $packet[3];
		$obj_Society->SocietyTypeId = $packet[4]== "" ? 0 :$packet[4];
		$obj_Society->SocietyAddress = $packet[5];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Society = DAL_manageSociety::update($obj_Society);

        if ($obj_retResult_Society->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Society updation is Success";
			$retrunUserpacket = $obj_retResult_Society->data->wsGetSocietyData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Society updation is Failed";
			$result_Society = DAL_manageSociety::getSocietyBySocietyId($obj_Society->SocietyId);
			if($result_Society->type ==1)
			{
			$retrunUserpacket = $result_Society->data->wsGetSocietyData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateSociety2($SocietyId,$Name,$Description,$Mission,$SocietyTypeId,$SocietyAddress)
    {
        $obj_retResult = new returnResult();
        $obj_newSociety = new Society();
	
		$obj_newSociety->SocietyId=$SocietyId;
		$obj_newSociety->Name=$Name;
		$obj_newSociety->Description=$Description;
		$obj_newSociety->Mission=$Mission;
		$obj_newSociety->SocietyTypeId=$SocietyTypeId;
		$obj_newSociety->SocietyAddress=$SocietyAddress;

	   
        $issuccess = DAL_manageSociety::updateSociety($obj_newSociety);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageSociety::getSocietyBySocietyId($obj_newSociety->SocietyId);
            $obj_retResult->msg = "Society updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Society updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getSocietyList()
    {
        $obj_retResult = DAL_manageSociety::getSocietyList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getSocietyList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageSociety::getAllSociety($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageSociety::searchSocietyBySocietyId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Society List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>SocietyId</th>";
		$html .= "<th>Name</th>";
		$html .= "<th>Description</th>";
		$html .= "<th>Mission</th>";
		$html .= "<th>SocietyTypeId</th>";
		$html .= "<th>SocietyAddress</th>";

		$html .= "</tr>";
		
            foreach ($arr_SocietyList as $obj_Society)
            {               

                    $html .= $obj_Society->drawTableViewSociety(); 
                
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

	public static function deleteSociety($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$SocietyId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_SocietyId =0;
			
			$retResult = BL_manageSociety::getSocietyListBySocietyId($SocietyId);
			if($retResult->type ==1)
			{
			
			$obj_Society = $retResult->data[0];			
			$obj_result2 = DAL_manageSociety::deleteSociety($obj_Society->SocietyId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_SocietyId = $obj_Society->SocietyId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Society";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Society you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Society->SocietyId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getSocietyListBySocietyId($SocietyId)
    {
        $obj_retResult = DAL_manageSociety::getSocietyListBySocietyId($SocietyId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildSociety($SocietyId,$ChildSocietyId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageSociety::getSocietyListBySocietyId($ChildSocietyId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_SocietyList = $obj_retResult->data;
				$obj_Society = $arr_SocietyList[0];
				
				$arrParentIds = explode(",",$obj_Society->Url);
				
				foreach($arrParentIds as $SocietyParentId)
				{
					if($SocietyParentId == $SocietyId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>