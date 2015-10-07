<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageUser_to_job
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addUser_to_job($obj_User_to_job)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_User_to_job->_id = DAL_manageUser_to_job::getLastUser_to_jobId()+1;
		
		 $sql = "INSERT INTO tbl_user_to_job (_id,user_id,job_id,meta,Status) 
		VALUES (".
		common::noSqlInject($obj_User_to_job->_id).",".common::noSqlInject($obj_User_to_job->user_id).",".common::noSqlInject($obj_User_to_job->job_id).","."'".common::noSqlInject($obj_User_to_job->meta)."'".",".common::noSqlInject($obj_User_to_job->Status).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_User_to_job;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastUser_to_jobId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(_id) as maxId FROM  tbl_user_to_job";
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

    public static function getUser_to_jobList()
    {
    	  $db = config::dbconfig();

        $arr_User_to_jobList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_user_to_job ORDER BY _id DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_User_to_job = new User_to_job();
		$obj_User_to_job->_id= $row["_id"];
		$obj_User_to_job->user_id= $row["user_id"];
		$obj_User_to_job->job_id= $row["job_id"];
		$obj_User_to_job->meta= $row["meta"];
		$obj_User_to_job->Status= $row["Status"];

        array_push($arr_User_to_jobList, $obj_User_to_job);
        }
		
		if(count($arr_User_to_jobList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_User_to_jobList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getUser_to_jobBy_id($_id)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_User_to_job = new User_to_job();
		$obj_User_to_job->_id = -1;
		$sql = "SELECT * FROM tbl_user_to_job WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_User_to_job->_id= $row["_id"];
		$obj_User_to_job->user_id= $row["user_id"];
		$obj_User_to_job->job_id= $row["job_id"];
		$obj_User_to_job->meta= $row["meta"];
		$obj_User_to_job->Status= $row["Status"];

        }
		
		if($obj_User_to_job->_id >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_User_to_job;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getUser_to_jobListBy_id($_id)
    {
    		
        $db = config::dbconfig();

        $arr_User_to_jobList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_user_to_job WHERE _id=".$_id." ORDER BY _id DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_User_to_job = new User_to_job();
		$obj_User_to_job->_id= $row["_id"];
		$obj_User_to_job->user_id= $row["user_id"];
		$obj_User_to_job->job_id= $row["job_id"];
		$obj_User_to_job->meta= $row["meta"];
		$obj_User_to_job->Status= $row["Status"];

        array_push($arr_User_to_jobList, $obj_User_to_job);
        }
		
		if(count($arr_User_to_jobList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_User_to_jobList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function delete($_id)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_user_to_job WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_User_to_job)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_user_to_job SET ". 
	"_id=".common::noSqlInject($obj_User_to_job->_id).","."user_id=".common::noSqlInject($obj_User_to_job->user_id).","."job_id=".common::noSqlInject($obj_User_to_job->job_id).","."meta="."'".common::noSqlInject($obj_User_to_job->meta)."'".","."Status=".common::noSqlInject($obj_User_to_job->Status).	        
	" WHERE  _id=".$obj_User_to_job->_id;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_User_to_job;
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
	
	public static function disableUser_to_job($_id)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_user_to_job SET Status=0 WHERE  _id=".$_id;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_User_to_job;
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
