<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageAgent
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addAgent($obj_Agent)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Agent->_id = DAL_manageAgent::getLastAgentId()+1;
		
		 $sql = "INSERT INTO tbl_agent (_id,agent_code,agent_name,agent_pass,agent_type,reg_date,meta,Status) 
		VALUES (".
		common::noSqlInject($obj_Agent->_id).","."'".common::noSqlInject($obj_Agent->agent_code)."'".","."'".common::noSqlInject($obj_Agent->agent_name)."'".","."'".common::noSqlInject($obj_Agent->agent_pass)."'".",".common::noSqlInject($obj_Agent->agent_type).","."'".common::noSqlInject($obj_Agent->reg_date)."'".","."'".common::noSqlInject($obj_Agent->meta)."'".",".common::noSqlInject($obj_Agent->Status).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Agent;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastAgentId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(_id) as maxId FROM  tbl_agent";
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

    public static function getAgentList()
    {
    	  $db = config::dbconfig();

        $arr_AgentList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_agent ORDER BY _id DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Agent = new Agent();
		$obj_Agent->_id= $row["_id"];
		$obj_Agent->agent_code= $row["agent_code"];
		$obj_Agent->agent_name= $row["agent_name"];
		$obj_Agent->agent_pass= $row["agent_pass"];
		$obj_Agent->agent_type= $row["agent_type"];
		$obj_Agent->reg_date= $row["reg_date"];
		$obj_Agent->meta= $row["meta"];
		$obj_Agent->Status= $row["Status"];

        array_push($arr_AgentList, $obj_Agent);
        }
		
		if(count($arr_AgentList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_AgentList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getAgentBy_id($_id)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Agent = new Agent();
		$obj_Agent->_id = -1;
		$sql = "SELECT * FROM tbl_agent WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Agent->_id= $row["_id"];
		$obj_Agent->agent_code= $row["agent_code"];
		$obj_Agent->agent_name= $row["agent_name"];
		$obj_Agent->agent_pass= $row["agent_pass"];
		$obj_Agent->agent_type= $row["agent_type"];
		$obj_Agent->reg_date= $row["reg_date"];
		$obj_Agent->meta= $row["meta"];
		$obj_Agent->Status= $row["Status"];

        }
		
		if($obj_Agent->_id >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Agent;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getAgentListBy_id($_id)
    {
    		
        $db = config::dbconfig();

        $arr_AgentList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_agent WHERE _id=".$_id." ORDER BY _id DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Agent = new Agent();
		$obj_Agent->_id= $row["_id"];
		$obj_Agent->agent_code= $row["agent_code"];
		$obj_Agent->agent_name= $row["agent_name"];
		$obj_Agent->agent_pass= $row["agent_pass"];
		$obj_Agent->agent_type= $row["agent_type"];
		$obj_Agent->reg_date= $row["reg_date"];
		$obj_Agent->meta= $row["meta"];
		$obj_Agent->Status= $row["Status"];

        array_push($arr_AgentList, $obj_Agent);
        }
		
		if(count($arr_AgentList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_AgentList;
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
        $sql = "DELETE FROM tbl_agent WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Agent)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Agent SET ". 
	"_id=".common::noSqlInject($obj_Agent->_id).","."agent_code="."'".common::noSqlInject($obj_Agent->agent_code)."'".","."agent_name="."'".common::noSqlInject($obj_Agent->agent_name)."'".","."agent_pass="."'".common::noSqlInject($obj_Agent->agent_pass)."'".","."agent_type=".common::noSqlInject($obj_Agent->agent_type).","."reg_date="."'".common::noSqlInject($obj_Agent->reg_date)."'".","."meta="."'".common::noSqlInject($obj_Agent->meta)."'".","."Status=".common::noSqlInject($obj_Agent->Status).	        
	" WHERE  _id=".$obj_Agent->_id;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Agent;
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
	
	public static function disableAgent($_id)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Agent SET Status=0 WHERE  _id=".$_id;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Agent;
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
