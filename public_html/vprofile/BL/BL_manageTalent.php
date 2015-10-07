<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Talent.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTalent.php");


class BL_manageTalent
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageTalent::addTalent($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageTalent::deleteTalent($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageTalent::updateTalent($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addTalent($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newTalent = new Talent();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newTalent->TalentId = $packet[1];
		$obj_newTalent->TalentType = $packet[2]== "" ? 0 : $packet[2];
		$obj_newTalent->TalentField = $packet[3];
		$obj_newTalent->Description = $packet[4];
		$obj_newTalent->TalentName = $packet[5];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Talent = DAL_manageTalent::addTalent($obj_newTalent);
            if ($obj_retResult_Talent->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Talent->data->wsGetTalentData();
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

    public static function addTalent2($TalentId,$TalentType,$TalentField,$Description,$TalentName)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newTalent = new Talent();
		
		$obj_newuser->setTalent($TalentId,$TalentType,$TalentField,$Description,$TalentName);
       // $isExist = BL_manageTalent::isExist($obj_newTalent->id);

        if (!$isExist)
        {
            $obj_retResult_Talent = DAL_manageTalent::addTalent($obj_newTalent);
            if ($obj_retResult_Talent->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Talent->data;
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
            $obj_retResult->msg = "Sorry! Talent already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateTalent($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Talent = new Talent();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Talent->TalentId = $packet[0];
		$obj_Talent->TalentType = $packet[1];
		$obj_Talent->TalentField = $packet[2];
		$obj_Talent->Description = $packet[3];
		$obj_Talent->TalentName = $packet[4];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Talent = DAL_manageTalent::update($obj_Talent);

        if ($obj_retResult_Talent->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Talent updation is Success";
			$retrunUserpacket = $obj_retResult_Talent->data->wsGetTalentData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Talent updation is Failed";
			$result_Talent = DAL_manageTalent::getTalentByTalentId($obj_Talent->TalentId);
			if($result_Talent->type ==1)
			{
			$retrunUserpacket = $result_Talent->data->wsGetTalentData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateTalent2($TalentId,$TalentType,$TalentField,$Description,$TalentName)
    {
        $obj_retResult = new returnResult();
        $obj_newTalent = new Talent();
	
		$obj_newTalent->TalentId=$TalentId;
		$obj_newTalent->TalentType=$TalentType;
		$obj_newTalent->TalentField=$TalentField;
		$obj_newTalent->Description=$Description;
		$obj_newTalent->TalentName=$TalentName;

	   
        $issuccess = DAL_manageTalent::updateTalent($obj_newTalent);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageTalent::getTalentByTalentId($obj_newTalent->TalentId);
            $obj_retResult->msg = "Talent updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Talent updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getTalentList()
    {
        $obj_retResult = DAL_manageTalent::getTalentList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getTalentList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageTalent::getAllTalent($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageTalent::searchTalentByTalentId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Talent List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TalentId</th>";
		$html .= "<th>TalentType</th>";
		$html .= "<th>TalentField</th>";
		$html .= "<th>Description</th>";
		$html .= "<th>TalentName</th>";

		$html .= "</tr>";
		
            foreach ($arr_TalentList as $obj_Talent)
            {               

                    $html .= $obj_Talent->drawTableViewTalent(); 
                
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

	public static function deleteTalent($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$TalentId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_TalentId =0;
			
			$retResult = BL_manageTalent::getTalentListByTalentId($TalentId);
			if($retResult->type ==1)
			{
			
			$obj_Talent = $retResult->data[0];			
			$obj_result2 = DAL_manageTalent::deleteTalent($obj_Talent->TalentId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_TalentId = $obj_Talent->TalentId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Talent";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Talent you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Talent->TalentId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getTalentListByTalentId($TalentId)
    {
        $obj_retResult = DAL_manageTalent::getTalentListByTalentId($TalentId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildTalent($TalentId,$ChildTalentId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageTalent::getTalentListByTalentId($ChildTalentId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_TalentList = $obj_retResult->data;
				$obj_Talent = $arr_TalentList[0];
				
				$arrParentIds = explode(",",$obj_Talent->Url);
				
				foreach($arrParentIds as $TalentParentId)
				{
					if($TalentParentId == $TalentId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>