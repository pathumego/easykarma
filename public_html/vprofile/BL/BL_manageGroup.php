<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Group.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageGroup.php");


class BL_manageGroup
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageGroup::addGroup($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageGroup::deleteGroup($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageGroup::updateGroup($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addGroup($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newGroup = new Group();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newGroup->GroupId = $packet[1];
		$obj_newGroup->GroupName = $packet[2];
		$obj_newGroup->GroupPrimaryType = $packet[3]== "" ? 0 : $packet[3];
		$obj_newGroup->GroupMissionTypeId = $packet[4]== "" ? 0 : $packet[4];
		$obj_newGroup->GroupAddress = $packet[5];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Group = DAL_manageGroup::addGroup($obj_newGroup);
            if ($obj_retResult_Group->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Group->data->wsGetGroupData();
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

    public static function addGroup2($GroupId,$GroupName,$GroupPrimaryType,$GroupMissionTypeId,$GroupAddress)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newGroup = new Group();
		
		$obj_newuser->setGroup($GroupId,$GroupName,$GroupPrimaryType,$GroupMissionTypeId,$GroupAddress);
       // $isExist = BL_manageGroup::isExist($obj_newGroup->id);

        if (!$isExist)
        {
            $obj_retResult_Group = DAL_manageGroup::addGroup($obj_newGroup);
            if ($obj_retResult_Group->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Group->data;
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
            $obj_retResult->msg = "Sorry! Group already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateGroup($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Group = new Group();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Group->GroupId = $packet[0];
		$obj_Group->GroupName = $packet[1];
		$obj_Group->GroupPrimaryType = $packet[2];
		$obj_Group->GroupMissionTypeId = $packet[3];
		$obj_Group->GroupAddress = $packet[4];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Group = DAL_manageGroup::update($obj_Group);

        if ($obj_retResult_Group->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Group updation is Success";
			$retrunUserpacket = $obj_retResult_Group->data->wsGetGroupData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Group updation is Failed";
			$result_Group = DAL_manageGroup::getGroupByGroupId($obj_Group->GroupId);
			if($result_Group->type ==1)
			{
			$retrunUserpacket = $result_Group->data->wsGetGroupData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateGroup2($GroupId,$GroupName,$GroupPrimaryType,$GroupMissionTypeId,$GroupAddress)
    {
        $obj_retResult = new returnResult();
        $obj_newGroup = new Group();
	
		$obj_newGroup->GroupId=$GroupId;
		$obj_newGroup->GroupName=$GroupName;
		$obj_newGroup->GroupPrimaryType=$GroupPrimaryType;
		$obj_newGroup->GroupMissionTypeId=$GroupMissionTypeId;
		$obj_newGroup->GroupAddress=$GroupAddress;

	   
        $issuccess = DAL_manageGroup::updateGroup($obj_newGroup);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageGroup::getGroupByGroupId($obj_newGroup->GroupId);
            $obj_retResult->msg = "Group updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Group updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getGroupList()
    {
        $obj_retResult = DAL_manageGroup::getGroupList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getGroupList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageGroup::getAllGroup($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageGroup::searchGroupByGroupId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Group List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>GroupId</th>";
		$html .= "<th>GroupName</th>";
		$html .= "<th>GroupPrimaryType</th>";
		$html .= "<th>GroupMissionTypeId</th>";
		$html .= "<th>GroupAddress</th>";

		$html .= "</tr>";
		
            foreach ($arr_GroupList as $obj_Group)
            {               

                    $html .= $obj_Group->drawTableViewGroup(); 
                
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

	public static function deleteGroup($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$GroupId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_GroupId =0;
			
			$retResult = BL_manageGroup::getGroupListByGroupId($GroupId);
			if($retResult->type ==1)
			{
			
			$obj_Group = $retResult->data[0];			
			$obj_result2 = DAL_manageGroup::deleteGroup($obj_Group->GroupId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_GroupId = $obj_Group->GroupId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Group";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Group you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Group->GroupId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getGroupListByGroupId($GroupId)
    {
        $obj_retResult = DAL_manageGroup::getGroupListByGroupId($GroupId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildGroup($GroupId,$ChildGroupId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageGroup::getGroupListByGroupId($ChildGroupId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_GroupList = $obj_retResult->data;
				$obj_Group = $arr_GroupList[0];
				
				$arrParentIds = explode(",",$obj_Group->Url);
				
				foreach($arrParentIds as $GroupParentId)
				{
					if($GroupParentId == $GroupId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>