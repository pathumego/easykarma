<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageJob_meta
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addJob_meta($obj_Job_meta)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Job_meta->_id = DAL_manageJob_meta::getLastJob_metaId()+1;
		
		 $sql = "INSERT INTO tbl_job_meta (_id,LoggedTime,JobID,JobType,JobData,Status,client_name,client_mobile,client_simid,client_nic) 
		VALUES (".
		common::noSqlInject($obj_Job_meta->_id).","."'".common::noSqlInject($obj_Job_meta->LoggedTime)."'".","."'".common::noSqlInject($obj_Job_meta->JobID)."'".","."'".common::noSqlInject($obj_Job_meta->JobType)."'".","."'".common::noSqlInject($obj_Job_meta->JobData)."'".",".common::noSqlInject($obj_Job_meta->Status).","."'".common::noSqlInject($obj_Job_meta->client_name)."'".","."'".common::noSqlInject($obj_Job_meta->client_mobile)."'".","."'".common::noSqlInject($obj_Job_meta->client_simid)."'".","."'".common::noSqlInject($obj_Job_meta->client_nic)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Job_meta;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastJob_metaId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(_id) as maxId FROM  tbl_job_meta";
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

    public static function getJob_metaList()
    {
    	  $db = config::dbconfig();

        $arr_Job_metaList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_job_meta ORDER BY _id DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Job_meta = new Job_meta();
		$obj_Job_meta->_id= $row["_id"];
		$obj_Job_meta->LoggedTime= $row["LoggedTime"];
		$obj_Job_meta->JobID= $row["JobID"];
		$obj_Job_meta->JobType= $row["JobType"];
		$obj_Job_meta->JobData= $row["JobData"];
		$obj_Job_meta->Status= $row["Status"];
		$obj_Job_meta->client_name= $row["client_name"];
		$obj_Job_meta->client_mobile= $row["client_mobile"];
		$obj_Job_meta->client_simid= $row["client_simid"];
		$obj_Job_meta->client_nic= $row["client_nic"];

        array_push($arr_Job_metaList, $obj_Job_meta);
        }
		
		if(count($arr_Job_metaList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Job_metaList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getJob_metaBy_id($_id)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Job_meta = new Job_meta();
		$obj_Job_meta->_id = -1;
		$sql = "SELECT * FROM tbl_job_meta WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Job_meta->_id= $row["_id"];
		$obj_Job_meta->LoggedTime= $row["LoggedTime"];
		$obj_Job_meta->JobID= $row["JobID"];
		$obj_Job_meta->JobType= $row["JobType"];
		$obj_Job_meta->JobData= $row["JobData"];
		$obj_Job_meta->Status= $row["Status"];
		$obj_Job_meta->client_name= $row["client_name"];
		$obj_Job_meta->client_mobile= $row["client_mobile"];
		$obj_Job_meta->client_simid= $row["client_simid"];
		$obj_Job_meta->client_nic= $row["client_nic"];

        }
		
		if($obj_Job_meta->_id >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Job_meta;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getJob_metaListBy_id($_id)
    {
    		
        $db = config::dbconfig();

        $arr_Job_metaList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_job_meta WHERE _id=".$_id." ORDER BY _id DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Job_meta = new Job_meta();
		$obj_Job_meta->_id= $row["_id"];
		$obj_Job_meta->LoggedTime= $row["LoggedTime"];
		$obj_Job_meta->JobID= $row["JobID"];
		$obj_Job_meta->JobType= $row["JobType"];
		$obj_Job_meta->JobData= $row["JobData"];
		$obj_Job_meta->Status= $row["Status"];
		$obj_Job_meta->client_name= $row["client_name"];
		$obj_Job_meta->client_mobile= $row["client_mobile"];
		$obj_Job_meta->client_simid= $row["client_simid"];
		$obj_Job_meta->client_nic= $row["client_nic"];

        array_push($arr_Job_metaList, $obj_Job_meta);
        }
		
		if(count($arr_Job_metaList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Job_metaList;
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
        $sql = "DELETE FROM tbl_job_meta WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Job_meta)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Job_meta SET ". 
	"_id=".common::noSqlInject($obj_Job_meta->_id).","."LoggedTime="."'".common::noSqlInject($obj_Job_meta->LoggedTime)."'".","."JobID="."'".common::noSqlInject($obj_Job_meta->JobID)."'".","."JobType="."'".common::noSqlInject($obj_Job_meta->JobType)."'".","."JobData="."'".common::noSqlInject($obj_Job_meta->JobData)."'".","."Status=".common::noSqlInject($obj_Job_meta->Status).","."client_name="."'".common::noSqlInject($obj_Job_meta->client_name)."'".","."client_mobile="."'".common::noSqlInject($obj_Job_meta->client_mobile)."'".","."client_simid="."'".common::noSqlInject($obj_Job_meta->client_simid)."'".","."client_nic="."'".common::noSqlInject($obj_Job_meta->client_nic)."'".	        
	" WHERE  _id=".$obj_Job_meta->_id;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Job_meta;
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
	
	public static function disableJob_meta($_id)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Job_meta SET Status=0 WHERE  _id=".$_id;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Job_meta;
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
