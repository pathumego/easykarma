<?php
require_once ("config.php");
require_once ("include/common.php");
class DAL_manageAgent_sessions
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addAgent_sessions($obj_Agent_sessions)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Agent_sessions->_id = DAL_manageAgent_sessions::getLastAgent_sessionsId()+1;
		
		 $sql = "INSERT INTO tbl_agent_sessions (_id,LoggedTime,SessionID,AgentID,JobID,JobType,Status) 
		VALUES (".
		common::noSqlInject($obj_Agent_sessions->_id).","."'".common::noSqlInject($obj_Agent_sessions->LoggedTime)."'".","."'".common::noSqlInject($obj_Agent_sessions->SessionID)."'".","."'".common::noSqlInject($obj_Agent_sessions->AgentID)."'".","."'".common::noSqlInject($obj_Agent_sessions->JobID)."'".","."'".common::noSqlInject($obj_Agent_sessions->JobType)."'".",".common::noSqlInject($obj_Agent_sessions->Status).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Agent_sessions;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastAgent_sessionsId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(_id) as maxId FROM  tbl_agent_sessions";
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

    public static function getAgent_sessionsList()
    {
    	  $db = config::dbconfig();

        $arr_Agent_sessionsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_agent_sessions ORDER BY _id DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Agent_sessions = new Agent_sessions();
		$obj_Agent_sessions->_id= $row["_id"];
		$obj_Agent_sessions->LoggedTime= $row["LoggedTime"];
		$obj_Agent_sessions->SessionID= $row["SessionID"];
		$obj_Agent_sessions->AgentID= $row["AgentID"];
		$obj_Agent_sessions->JobID= $row["JobID"];
		$obj_Agent_sessions->JobType= $row["JobType"];
		$obj_Agent_sessions->Status= $row["Status"];

        array_push($arr_Agent_sessionsList, $obj_Agent_sessions);
        }
		
		if(count($arr_Agent_sessionsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Agent_sessionsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getAgent_sessionsBy_id($_id)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Agent_sessions = new Agent_sessions();
		$obj_Agent_sessions->_id = -1;
		$sql = "SELECT * FROM tbl_agent_sessions WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Agent_sessions->_id= $row["_id"];
		$obj_Agent_sessions->LoggedTime= $row["LoggedTime"];
		$obj_Agent_sessions->SessionID= $row["SessionID"];
		$obj_Agent_sessions->AgentID= $row["AgentID"];
		$obj_Agent_sessions->JobID= $row["JobID"];
		$obj_Agent_sessions->JobType= $row["JobType"];
		$obj_Agent_sessions->Status= $row["Status"];

        }
		
		if($obj_Agent_sessions->_id >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Agent_sessions;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getAgent_sessionsListBy_id($_id)
    {
    		
        $db = config::dbconfig();

        $arr_Agent_sessionsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_agent_sessions WHERE _id=".$_id." ORDER BY _id DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Agent_sessions = new Agent_sessions();
		$obj_Agent_sessions->_id= $row["_id"];
		$obj_Agent_sessions->LoggedTime= $row["LoggedTime"];
		$obj_Agent_sessions->SessionID= $row["SessionID"];
		$obj_Agent_sessions->AgentID= $row["AgentID"];
		$obj_Agent_sessions->JobID= $row["JobID"];
		$obj_Agent_sessions->JobType= $row["JobType"];
		$obj_Agent_sessions->Status= $row["Status"];

        array_push($arr_Agent_sessionsList, $obj_Agent_sessions);
        }
		
		if(count($arr_Agent_sessionsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Agent_sessionsList;
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
        $sql = "DELETE FROM tbl_agent_sessions WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Agent_sessions)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Agent_sessions SET ". 
	"_id=".common::noSqlInject($obj_Agent_sessions->_id).","."LoggedTime="."'".common::noSqlInject($obj_Agent_sessions->LoggedTime)."'".","."SessionID="."'".common::noSqlInject($obj_Agent_sessions->SessionID)."'".","."AgentID="."'".common::noSqlInject($obj_Agent_sessions->AgentID)."'".","."JobID="."'".common::noSqlInject($obj_Agent_sessions->JobID)."'".","."JobType="."'".common::noSqlInject($obj_Agent_sessions->JobType)."'".","."Status=".common::noSqlInject($obj_Agent_sessions->Status).	        
	" WHERE  _id=".$obj_Agent_sessions->_id;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Agent_sessions;
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
	
	public static function disableAgent_sessions($_id)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Agent_sessions SET Status=0 WHERE  _id=".$_id;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Agent_sessions;
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
