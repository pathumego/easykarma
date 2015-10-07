<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Group_member.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageGroup_member.php");


class BL_manageGroup_member
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageGroup_member::addGroup_member($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageGroup_member::deleteGroup_member($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageGroup_member::updateGroup_member($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addGroup_member($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newGroup_member = new Group_member();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newGroup_member->GroupId = $packet[1];
		$obj_newGroup_member->MemberId = $packet[2]== "" ? 0 : $packet[2] ;
		$obj_newGroup_member->MemberType = $packet[3];
		$obj_newGroup_member->MemberDate = $packet[4];
		$obj_newGroup_member->Description = $packet[5];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Group_member = DAL_manageGroup_member::addGroup_member($obj_newGroup_member);
            if ($obj_retResult_Group_member->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Group_member->data->wsGetGroup_memberData();
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

    public static function addGroup_member2($GroupId,$MemberId,$MemberType,$MemberDate,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newGroup_member = new Group_member();
		
		$obj_newuser->setGroup_member($GroupId,$MemberId,$MemberType,$MemberDate,$Description);
       // $isExist = BL_manageGroup_member::isExist($obj_newGroup_member->id);

        if (!$isExist)
        {
            $obj_retResult_Group_member = DAL_manageGroup_member::addGroup_member($obj_newGroup_member);
            if ($obj_retResult_Group_member->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Group_member->data;
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
            $obj_retResult->msg = "Sorry! Group_member already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateGroup_member($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Group_member = new Group_member();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Group_member->GroupId = $packet[0];
		$obj_Group_member->MemberId = $packet[1];
		$obj_Group_member->MemberType = $packet[2];
		$obj_Group_member->MemberDate = $packet[3];
		$obj_Group_member->Description = $packet[4];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Group_member = DAL_manageGroup_member::update($obj_Group_member);

        if ($obj_retResult_Group_member->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Group_member updation is Success";
			$retrunUserpacket = $obj_retResult_Group_member->data->wsGetGroup_memberData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Group_member updation is Failed";
			$result_Group_member = DAL_manageGroup_member::getGroup_memberByMemberId($obj_Group_member->MemberId);
			if($result_Group_member->type ==1)
			{
			$retrunUserpacket = $result_Group_member->data->wsGetGroup_memberData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateGroup_member2($GroupId,$MemberId,$MemberType,$MemberDate,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newGroup_member = new Group_member();
	
		$obj_newGroup_member->GroupId=$GroupId;
		$obj_newGroup_member->MemberId=$MemberId;
		$obj_newGroup_member->MemberType=$MemberType;
		$obj_newGroup_member->MemberDate=$MemberDate;
		$obj_newGroup_member->Description=$Description;

	   
        $issuccess = DAL_manageGroup_member::updateGroup_member($obj_newGroup_member);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageGroup_member::getGroup_memberByMemberId($obj_newGroup_member->MemberId);
            $obj_retResult->msg = "Group_member updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Group_member updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getGroup_memberList()
    {
        $obj_retResult = DAL_manageGroup_member::getGroup_memberList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getGroup_memberList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageGroup_member::getAllGroup_member($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageGroup_member::searchGroup_memberByMemberId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Group_member List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>GroupId</th>";
		$html .= "<th>MemberId</th>";
		$html .= "<th>MemberType</th>";
		$html .= "<th>MemberDate</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Group_memberList as $obj_Group_member)
            {               

                    $html .= $obj_Group_member->drawTableViewGroup_member(); 
                
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

	public static function deleteGroup_member($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$MemberId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_MemberId =0;
			
			$retResult = BL_manageGroup_member::getGroup_memberListByMemberId($MemberId);
			if($retResult->type ==1)
			{
			
			$obj_Group_member = $retResult->data[0];			
			$obj_result2 = DAL_manageGroup_member::deleteGroup_member($obj_Group_member->MemberId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_MemberId = $obj_Group_member->MemberId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Group_member";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Group_member you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Group_member->MemberId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getGroup_memberListByMemberId($MemberId)
    {
        $obj_retResult = DAL_manageGroup_member::getGroup_memberListByMemberId($MemberId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildGroup_member($MemberId,$ChildMemberId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageGroup_member::getGroup_memberListByMemberId($ChildMemberId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Group_memberList = $obj_retResult->data;
				$obj_Group_member = $arr_Group_memberList[0];
				
				$arrParentIds = explode(",",$obj_Group_member->Url);
				
				foreach($arrParentIds as $Group_memberParentId)
				{
					if($Group_memberParentId == $MemberId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>