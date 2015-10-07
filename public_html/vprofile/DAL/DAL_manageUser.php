<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
class DAL_manageUser
{

//---------------------------------------------------------------------------------------------------------
	public static function authenticateUser($userName, $password)
	{
		$db = config::dbconfig();
		$obj_retResult = new returnResult();
		
        $sql = "SELECT * FROM tbl_user WHERE userName ='".$userName."' AND Password ='".$password."'";
     	$rs = mysql_query($sql);		

        if (mysql_num_rows($rs) == 1)
        {
        	$obj_User = new User();
        	while($row = mysql_fetch_array($rs))
			{
			$obj_User->userName = $row["userName"];
			$obj_User->userId = $row["userId"];
			$obj_User->personId = $row["personId"];
			$obj_User->userStatus = $row["userStatus"];
			}
			
			$obj_retResult->type = 1;
			$obj_retResult->data = $obj_User;
			$obj_retResult->msg = "successfully login";
		}
		else
		{
			$obj_retResult->type = 0;
			$obj_retResult->msg = "password or user name invalid";
		}
		
		return $obj_retResult;
	}
	//---------------------------------------------------------------------------------------------------------
	
    public static function addUser($obj_User)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_User->userId = DAL_manageUser::getLastUserId()+1;
		
		 $sql = "INSERT INTO tbl_user (userId,userName,password,personId,userType,userOptCode,userMetadata,userStatus) 
		VALUES (".
		common::noSqlInject($obj_User->userId).","."'".common::noSqlInject($obj_User->userName)."'".","."'".common::noSqlInject($obj_User->password)."'".",".common::noSqlInject($obj_User->personId).",".common::noSqlInject($obj_User->userType).","."'".common::noSqlInject($obj_User->userOptCode)."'".","."'".common::noSqlInject($obj_User->userMetadata)."'".",".common::noSqlInject($obj_User->userStatus).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_User;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastUserId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(userId) as maxId FROM  tbl_user";
        $rs = mysql_query($sql);
        if ((mysql_num_rows($rs)) > 0)
        {
            while ($row = mysql_fetch_array($rs))
            {
                $maxId = $row["maxId"];
                $lastID = is_null($maxId)?0:$maxId;
            }
        }

        return $lastID;

    }
	
	    //---------------------------------------------------------------------------------------------------------

    public static function getUserList()
    {
    	  $db = config::dbconfig();

        $arr_UserList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_user ORDER BY userId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_User = new User();
		$obj_User->userId= $row["userId"];
		$obj_User->userName= $row["userName"];
		$obj_User->password= $row["password"];
		$obj_User->personId= $row["personId"];
		$obj_User->userType= $row["userType"];
		$obj_User->userOptCode= $row["userOptCode"];
		$obj_User->userMetadata= $row["userMetadata"];
		$obj_User->userStatus= $row["userStatus"];
		
        array_push($arr_UserList, $obj_User);
        }
		
		if(count($arr_UserList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_UserList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getUserByuserId($userId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_User = new User();
		$sql = "SELECT * FROM tbl_user WHERE userId=".$userId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_User->userId= $row["userId"];
		$obj_User->userName= $row["userName"];
		$obj_User->password= $row["password"];
		$obj_User->personId= $row["personId"];
		$obj_User->userType= $row["userType"];
		$obj_User->userOptCode= $row["userOptCode"];
		$obj_User->userMetadata= $row["userMetadata"];
		$obj_User->userStatus= $row["userStatus"];
        }
		
		if($obj_User->userId >-1 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_User;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getUserListByuserId($userId)
    {
    		
        $db = config::dbconfig();

        $arr_UserList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_user WHERE userId=".$userId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_User = new User();
		$obj_User->userId= $row["userId"];
		$obj_User->userName= $row["userName"];
		$obj_User->password= $row["password"];
		$obj_User->personId= $row["personId"];
		$obj_User->userType= $row["userType"];
		$obj_User->userOptCode= $row["userOptCode"];
		$obj_User->userMetadata= $row["userMetadata"];
		$obj_User->userStatus= $row["userStatus"];
		
        array_push($arr_UserList, $obj_User);
        }
		
		if(count($arr_UserList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_UserList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function delete($userId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_user WHERE userId=".$userId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_User)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_user SET ". 
	"userId=".common::noSqlInject($obj_User->userId).","."userName="."'".common::noSqlInject($obj_User->userName)."'".","."password="."'".common::noSqlInject($obj_User->password)."'".","."personId=".common::noSqlInject($obj_User->personId).","."userType=".common::noSqlInject($obj_User->userType).","."userOptCode="."'".common::noSqlInject($obj_User->userOptCode)."'".","."userMetadata="."'".common::noSqlInject($obj_User->userMetadata)."'".","."userStatus=".common::noSqlInject($obj_User->userStatus).        
	" WHERE  userId=".$obj_User->userId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_User;
			$obj_retresult->msg = "success";
			
		//}
		//else
		//{
		//	$obj_retresult->type = 0;
		//	$obj_retresult->msg = "failed";
		//}
		}
		catch(Exception $ex)
		{
			$obj_retresult->type = 0;
			$obj_retresult->msg = "failed";
		}

		return $obj_retresult;
	}
	
	//---------------------------------------------------------------------------------------------------------
	
	public static function disableUser($userId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_user SET Status=0 WHERE  userId=".$userId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_User;
			$obj_retresult->msg = "success";
			
		}
		else
		{
			$obj_retresult->type = 0;
			$obj_retresult->msg = "failed";
		}

		return $obj_retresult;
	}
	

	//---------------------------------------------------------------------------------------------------------

}
?>