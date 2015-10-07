<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/User.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageUser.php");


class BL_manageUser
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageUser::addUser($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageUser::deleteUser($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageUser::updateUser($obj_mainpacket);
                break;
            }


    }
	
}

    //---------------------------------------------------------------------------------------------------------

    public static function authenticateUser($userName, $password)
    {

        return $obj_retResult = DAL_manageUser::authenticateUser($userName, $password);

    }
	
//---------------------------------------------------------------------------------------------------------

    public static function addUser($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newUser = new User();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newUser->userId = $packet[1];
		$obj_newUser->userName = $packet[2];
		$obj_newUser->password = $packet[3];
		$obj_newUser->personId = $packet[4];
		$obj_newUser->userType = $packet[5];
		$obj_newUser->userOptCode = $packet[6];
		$obj_newUser->userMetadata = $packet[7];
		$obj_newUser->userStatus = $packet[8];
  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_User = DAL_manageUser::addUser($obj_newUser);
            if ($obj_retResult_User->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_User->data->wsGetUserData();
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

    public static function addUser2($userId,$userName,$password,$personId,$userType)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newUser = new User();
		
		$obj_newuser->setUser($userId,$userName,$password,$personId,$userType);
       // $isExist = BL_manageUser::isExist($obj_newUser->id);

        if (!$isExist)
        {
            $obj_retResult_User = DAL_manageUser::addUser($obj_newUser);
            if ($obj_retResult_User->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_User->data;
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
            $obj_retResult->msg = "Sorry! User already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateUser($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_User = new User();
		if (count($packet) >= 2)//check packet length
        {
		$obj_User->userId = $packet[0];
		$obj_User->userName = $packet[1];
		$obj_User->password = $packet[2];
		$obj_User->personId = $packet[3];
		$obj_User->userType = $packet[4];
		$obj_User->userOptCode = $packet[5];
		$obj_User->userMetadata = $packet[6];
		$obj_User->userStatus = $packet[7];
		
        $obj_retResult = new returnResult();
       

       
        $obj_retResult_User = DAL_manageUser::update($obj_User);

        if ($obj_retResult_User->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "User updation is Success";
			$retrunUserpacket = $obj_retResult_User->data->wsGetUserData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "User updation is Failed";
			$result_User = DAL_manageUser::getUserByuserId($obj_User->userId);
			if($result_User->type ==1)
			{
			$retrunUserpacket = $result_User->data->wsGetUserData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------
    public static function updateUser2($userId,$userName,$password,$personId,$userType,$userOptCode,$userMetadata,$userStatus)
    {
        $obj_retResult = new returnResult();
        $obj_newUser = new User();
	
		$obj_newUser->userId=$userId;
		$obj_newUser->userName=$userName;
		$obj_newUser->password=$password;
		$obj_newUser->personId=$personId;
		$obj_newUser->userType=$userType;
		$obj_newUser->userOptCode = $userOptCode;
		$obj_newUser->userMetadata = $userMetadata;
		$obj_newUser->userStatus = $userStatus;
	   
        $issuccess = DAL_manageUser::updateUser($obj_newUser);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageUser::getUserByuserId($obj_newUser->userId);
            $obj_retResult->msg = "User updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "User updation is Failed";
        }

        return $obj_retResult;
    }
	
    public static function updateUser3($userId,$userName,$password,$personId,$userType)
    {
        $obj_retResult = new returnResult();
        $obj_newUser = new User();
	
		$obj_newUser->userId=$userId;
		$obj_newUser->userName=$userName;
		$obj_newUser->password=$password;
		$obj_newUser->personId=$personId;
		$obj_newUser->userType=$userType;

	   
        $issuccess = DAL_manageUser::updateUser($obj_newUser);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageUser::getUserByuserId($obj_newUser->userId);
            $obj_retResult->msg = "User updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "User updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getUserList()
    {
        $obj_retResult = DAL_manageUser::getUserList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getUserList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageUser::getAllUser($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageUser::searchUserByuserId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >User List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";

		$html .= "<th>userId</th>";
		$html .= "<th>userName</th>";
		$html .= "<th>password</th>";
		$html .= "<th>personId</th>";
		$html .= "<th>userType</th>";
		$html .= "<th>userOptCode</th>";
		$html .= "<th>userMetadata</th>";
		$html .= "<th>userStatus</th>";
		$html .= "</tr>";
		
            foreach ($arr_UserList as $obj_User)
            { 
			$html .= $obj_User->drawTableViewUser();                 
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

	public static function deleteUser($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$userId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_userId =0;
			
			$retResult = BL_manageUser::getUserListByuserId($userId);
			if($retResult->type ==1)
			{
			
			$obj_User = $retResult->data[0];			
			$obj_result2 = DAL_manageUser::deleteUser($obj_User->userId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_userId = $obj_User->userId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this User";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The User you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_User->userId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getUserListByuserId($userId)
    {
        $obj_retResult = DAL_manageUser::getUserListByuserId($userId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildUser($userId,$ChilduserId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageUser::getUserListByuserId($ChilduserId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_UserList = $obj_retResult->data;
				$obj_User = $arr_UserList[0];
				
				$arrParentIds = explode(",",$obj_User->Url);
				
				foreach($arrParentIds as $UserParentId)
				{
					if($UserParentId == $userId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>