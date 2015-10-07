<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Society_member.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageSociety_member.php");


class BL_manageSociety_member
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageSociety_member::addSociety_member($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageSociety_member::deleteSociety_member($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageSociety_member::updateSociety_member($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addSociety_member($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newSociety_member = new Society_member();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newSociety_member->VillageSocietyId = $packet[1]== "" ? 0 :$packet[1];
		$obj_newSociety_member->MemberId = $packet[2]== "" ? 0 :$packet[2];
		$obj_newSociety_member->MemberType = $packet[3];
		$obj_newSociety_member->MemberDate = $packet[4];
		$obj_newSociety_member->Description = $packet[5];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Society_member = DAL_manageSociety_member::addSociety_member($obj_newSociety_member);
            if ($obj_retResult_Society_member->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Society_member->data->wsGetSociety_memberData();
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

    public static function addSociety_member2($VillageSocietyId,$MemberId,$MemberType,$MemberDate,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newSociety_member = new Society_member();
		
		$obj_newuser->setSociety_member($VillageSocietyId,$MemberId,$MemberType,$MemberDate,$Description);
       // $isExist = BL_manageSociety_member::isExist($obj_newSociety_member->id);

        if (!$isExist)
        {
            $obj_retResult_Society_member = DAL_manageSociety_member::addSociety_member($obj_newSociety_member);
            if ($obj_retResult_Society_member->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Society_member->data;
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
            $obj_retResult->msg = "Sorry! Society_member already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateSociety_member($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Society_member = new Society_member();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Society_member->VillageSocietyId = $packet[0];
		$obj_Society_member->MemberId = $packet[1];
		$obj_Society_member->MemberType = $packet[2];
		$obj_Society_member->MemberDate = $packet[3];
		$obj_Society_member->Description = $packet[4];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Society_member = DAL_manageSociety_member::update($obj_Society_member);

        if ($obj_retResult_Society_member->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Society_member updation is Success";
			$retrunUserpacket = $obj_retResult_Society_member->data->wsGetSociety_memberData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Society_member updation is Failed";
			$result_Society_member = DAL_manageSociety_member::getSociety_memberByMemberId($obj_Society_member->MemberId);
			if($result_Society_member->type ==1)
			{
			$retrunUserpacket = $result_Society_member->data->wsGetSociety_memberData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateSociety_member2($VillageSocietyId,$MemberId,$MemberType,$MemberDate,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newSociety_member = new Society_member();
	
		$obj_newSociety_member->VillageSocietyId=$VillageSocietyId;
		$obj_newSociety_member->MemberId=$MemberId;
		$obj_newSociety_member->MemberType=$MemberType;
		$obj_newSociety_member->MemberDate=$MemberDate;
		$obj_newSociety_member->Description=$Description;

	   
        $issuccess = DAL_manageSociety_member::updateSociety_member($obj_newSociety_member);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageSociety_member::getSociety_memberByMemberId($obj_newSociety_member->MemberId);
            $obj_retResult->msg = "Society_member updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Society_member updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getSociety_memberList()
    {
        $obj_retResult = DAL_manageSociety_member::getSociety_memberList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getSociety_memberList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageSociety_member::getAllSociety_member($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageSociety_member::searchSociety_memberByMemberId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Society_member List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>VillageSocietyId</th>";
		$html .= "<th>MemberId</th>";
		$html .= "<th>MemberType</th>";
		$html .= "<th>MemberDate</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Society_memberList as $obj_Society_member)
            {               

                    $html .= $obj_Society_member->drawTableViewSociety_member(); 
                
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

	public static function deleteSociety_member($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$MemberId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_MemberId =0;
			
			$retResult = BL_manageSociety_member::getSociety_memberListByMemberId($MemberId);
			if($retResult->type ==1)
			{
			
			$obj_Society_member = $retResult->data[0];			
			$obj_result2 = DAL_manageSociety_member::deleteSociety_member($obj_Society_member->MemberId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_MemberId = $obj_Society_member->MemberId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Society_member";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Society_member you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Society_member->MemberId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getSociety_memberListByMemberId($MemberId)
    {
        $obj_retResult = DAL_manageSociety_member::getSociety_memberListByMemberId($MemberId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildSociety_member($MemberId,$ChildMemberId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageSociety_member::getSociety_memberListByMemberId($ChildMemberId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Society_memberList = $obj_retResult->data;
				$obj_Society_member = $arr_Society_memberList[0];
				
				$arrParentIds = explode(",",$obj_Society_member->Url);
				
				foreach($arrParentIds as $Society_memberParentId)
				{
					if($Society_memberParentId == $MemberId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>