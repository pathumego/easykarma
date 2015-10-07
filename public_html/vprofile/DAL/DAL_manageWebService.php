<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
class DAL_manageWebService{
	
//---------------------------------------------------------------------------------------------------------

    public static function addNewSessionKey($userName, $userId, $sessionKey)
    {
        $obj_retResult = new returnResult();
        $db = config::dbconfig();
        $id = DAL_manageWebService::getLastSessionId() + 1;

        $sql = "INSERT INTO tbl_webservicecall (id, userName, userId, sessionKey, startTime, lastUpdateTime) VALUES (".$id.",'".$userName."','".$userId."','".$sessionKey."',NOW(),NOW())";

		$rs = mysql_query($sql);
		
        if (mysql_affected_rows() > 0)
        {
            $obj_retResult->type =1;
			$obj_retResult->data = $sessionKey;
        }
		else
		{
			 $obj_retResult->type =0;
		}
        return $obj_retResult;

    }	


//---------------------------------------------------------------------------------------------------------

    public static function getSessionKeyByUserId($userId)
    {

        $db = config::dbconfig();
		$obj_serviceSession = new serviceSession();
		$obj_retresult = new returnResult();
        $sql= "SELECT * FROM tbl_webservicecall WHERE userId ='".$userId."'";
        $rs = mysql_query($sql);
        while ($row = mysql_fetch_array($rs))
        {
            $obj_serviceSession->id = $row["id"];
			$obj_serviceSession->userName = $row["userName"];
			$obj_serviceSession->userId = $row["userId"];
            $obj_serviceSession->sessionKey = $row["sessionKey"];
			$obj_serviceSession->startTime = $row["startTime"];
			$obj_serviceSession->lastUpdateTime = $row["lastUpdateTime"];
        }

		if($obj_serviceSession->id >-1 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_serviceSession;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;


    }
	
//---------------------------------------------------------------------------------------------------------
	
	public function getSessionKey($sessionKey)
	{
	 	$db = config::dbconfig();

		$obj_serviceSession = new serviceSession();
		$obj_retresult = new returnResult();

        $sql = "SELECT * FROM tbl_webservicecall where sessionKey ='".$sessionKey."'";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {           
            $obj_serviceSession->id = $row["id"];
			$obj_serviceSession->userName = $row["userName"];
			$obj_serviceSession->userId = $row["userId"];
            $obj_serviceSession->sessionKey = $row["sessionKey"];
			$obj_serviceSession->startTime = $row["startTime"];
			$obj_serviceSession->lastUpdateTime = $row["lastUpdateTime"];
        }

		if($obj_serviceSession->id >-1 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_serviceSession;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
	
	
}

//---------------------------------------------------------------------------------------------------------
	
	public static function updateSessionTime($sessionkey)	
	{	
		
        $db = config::dbconfig();
		$obj_retresult = new returnResult();
        $sql ="UPDATE tbl_webservicecall SET lastUpdateTime= NOW() WHERE sessionKey='".$sessionkey."'";
		$rs = mysql_query($sql);
		
       if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
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
	
	public static function updateSessionLastUpdateTimeById($id)	
	{	
		
        $db = config::dbconfig();
		$obj_retresult = new returnResult();
        $sql ="UPDATE tbl_webservicecall SET lastUpdateTime= NOW() WHERE id=".$id;
		$rs = mysql_query($sql);
		
       if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
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
	
public function updateSessionLastUpdateTime(){
		
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		$sql = "UPDATE tbl_webservicecall SET lastUpdateTime=NOW() WHERE sessionKey ='".$sessionKey."'";		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
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

    public static function getLastSessionId()
    {

        $lastID = 0;
        $db = config::dbconfig();
        $sql = "SELECT MAX(id) FROM tbl_webservicecall";
		$rs = mysql_query($sql);
        if ($row = mysql_fetch_row($rs))
        {
            $lastID = is_null($row[0]) ? 0 : $row[0];
        }

        return $lastID;

    }	
}
?>