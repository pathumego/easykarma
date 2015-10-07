<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Groupmissiontype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageGroupmissiontype.php");


class BL_manageGroupmissiontype
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageGroupmissiontype::addGroupmissiontype($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageGroupmissiontype::deleteGroupmissiontype($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageGroupmissiontype::updateGroupmissiontype($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addGroupmissiontype($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newGroupmissiontype = new Groupmissiontype();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newGroupmissiontype->GroupMissionTypeId = $packet[1];
		$obj_newGroupmissiontype->GroupMissionTypeName = $packet[2];
		$obj_newGroupmissiontype->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Groupmissiontype = DAL_manageGroupmissiontype::addGroupmissiontype($obj_newGroupmissiontype);
            if ($obj_retResult_Groupmissiontype->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Groupmissiontype->data->wsGetGroupmissiontypeData();
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

    public static function addGroupmissiontype2($GroupMissionTypeId,$GroupMissionTypeName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newGroupmissiontype = new Groupmissiontype();
		
		$obj_newuser->setGroupmissiontype($GroupMissionTypeId,$GroupMissionTypeName,$Description);
       // $isExist = BL_manageGroupmissiontype::isExist($obj_newGroupmissiontype->id);

        if (!$isExist)
        {
            $obj_retResult_Groupmissiontype = DAL_manageGroupmissiontype::addGroupmissiontype($obj_newGroupmissiontype);
            if ($obj_retResult_Groupmissiontype->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Groupmissiontype->data;
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
            $obj_retResult->msg = "Sorry! Groupmissiontype already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateGroupmissiontype($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Groupmissiontype = new Groupmissiontype();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Groupmissiontype->GroupMissionTypeId = $packet[0];
		$obj_Groupmissiontype->GroupMissionTypeName = $packet[1];
		$obj_Groupmissiontype->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Groupmissiontype = DAL_manageGroupmissiontype::update($obj_Groupmissiontype);

        if ($obj_retResult_Groupmissiontype->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Groupmissiontype updation is Success";
			$retrunUserpacket = $obj_retResult_Groupmissiontype->data->wsGetGroupmissiontypeData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Groupmissiontype updation is Failed";
			$result_Groupmissiontype = DAL_manageGroupmissiontype::getGroupmissiontypeByGroupMissionTypeId($obj_Groupmissiontype->GroupMissionTypeId);
			if($result_Groupmissiontype->type ==1)
			{
			$retrunUserpacket = $result_Groupmissiontype->data->wsGetGroupmissiontypeData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateGroupmissiontype2($GroupMissionTypeId,$GroupMissionTypeName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newGroupmissiontype = new Groupmissiontype();
	
		$obj_newGroupmissiontype->GroupMissionTypeId=$GroupMissionTypeId;
		$obj_newGroupmissiontype->GroupMissionTypeName=$GroupMissionTypeName;
		$obj_newGroupmissiontype->Description=$Description;

	   
        $issuccess = DAL_manageGroupmissiontype::updateGroupmissiontype($obj_newGroupmissiontype);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageGroupmissiontype::getGroupmissiontypeByGroupMissionTypeId($obj_newGroupmissiontype->GroupMissionTypeId);
            $obj_retResult->msg = "Groupmissiontype updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Groupmissiontype updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getGroupmissiontypeList()
    {
        $obj_retResult = DAL_manageGroupmissiontype::getGroupmissiontypeList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getGroupmissiontypeList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageGroupmissiontype::getAllGroupmissiontype($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageGroupmissiontype::searchGroupmissiontypeByGroupMissionTypeId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Groupmissiontype List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>GroupMissionTypeId</th>";
		$html .= "<th>GroupMissionTypeName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_GroupmissiontypeList as $obj_Groupmissiontype)
            {               

                    $html .= $obj_Groupmissiontype->drawTableViewGroupmissiontype(); 
                
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

	public static function deleteGroupmissiontype($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$GroupMissionTypeId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_GroupMissionTypeId =0;
			
			$retResult = BL_manageGroupmissiontype::getGroupmissiontypeListByGroupMissionTypeId($GroupMissionTypeId);
			if($retResult->type ==1)
			{
			
			$obj_Groupmissiontype = $retResult->data[0];			
			$obj_result2 = DAL_manageGroupmissiontype::deleteGroupmissiontype($obj_Groupmissiontype->GroupMissionTypeId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_GroupMissionTypeId = $obj_Groupmissiontype->GroupMissionTypeId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Groupmissiontype";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Groupmissiontype you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Groupmissiontype->GroupMissionTypeId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getGroupmissiontypeListByGroupMissionTypeId($GroupMissionTypeId)
    {
        $obj_retResult = DAL_manageGroupmissiontype::getGroupmissiontypeListByGroupMissionTypeId($GroupMissionTypeId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildGroupmissiontype($GroupMissionTypeId,$ChildGroupMissionTypeId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageGroupmissiontype::getGroupmissiontypeListByGroupMissionTypeId($ChildGroupMissionTypeId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_GroupmissiontypeList = $obj_retResult->data;
				$obj_Groupmissiontype = $arr_GroupmissiontypeList[0];
				
				$arrParentIds = explode(",",$obj_Groupmissiontype->Url);
				
				foreach($arrParentIds as $GroupmissiontypeParentId)
				{
					if($GroupmissiontypeParentId == $GroupMissionTypeId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>