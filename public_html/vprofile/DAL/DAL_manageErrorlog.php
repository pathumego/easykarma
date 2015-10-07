<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageErrorlog
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addErrorlog($obj_Errorlog)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Errorlog->_id = DAL_manageErrorlog::getLastErrorlogId()+1;
		
		 $sql = "INSERT INTO tbl_errorlog (_id,LoggedTime,Tag,Place,Event,Message,metadata,Status) 
		VALUES (".
		common::noSqlInject($obj_Errorlog->_id).","."'".common::noSqlInject($obj_Errorlog->LoggedTime)."'".","."'".common::noSqlInject($obj_Errorlog->Tag)."'".","."'".common::noSqlInject($obj_Errorlog->Place)."'".","."'".common::noSqlInject($obj_Errorlog->Event)."'".","."'".common::noSqlInject($obj_Errorlog->Message)."'".","."'".common::noSqlInject($obj_Errorlog->metadata)."'".",".common::noSqlInject($obj_Errorlog->Status).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Errorlog;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastErrorlogId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(_id) as maxId FROM  tbl_errorlog";
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

    public static function getErrorlogList()
    {
    	  $db = config::dbconfig();

        $arr_ErrorlogList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_errorlog ORDER BY _id DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Errorlog = new Errorlog();
		$obj_Errorlog->_id= $row["_id"];
		$obj_Errorlog->LoggedTime= $row["LoggedTime"];
		$obj_Errorlog->Tag= $row["Tag"];
		$obj_Errorlog->Place= $row["Place"];
		$obj_Errorlog->Event= $row["Event"];
		$obj_Errorlog->Message= $row["Message"];
		$obj_Errorlog->metadata= $row["metadata"];
		$obj_Errorlog->Status= $row["Status"];

        array_push($arr_ErrorlogList, $obj_Errorlog);
        }
		
		if(count($arr_ErrorlogList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_ErrorlogList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getErrorlogBy_id($_id)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Errorlog = new Errorlog();
		$obj_Errorlog->_id = -1;
		$sql = "SELECT * FROM tbl_errorlog WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Errorlog->_id= $row["_id"];
		$obj_Errorlog->LoggedTime= $row["LoggedTime"];
		$obj_Errorlog->Tag= $row["Tag"];
		$obj_Errorlog->Place= $row["Place"];
		$obj_Errorlog->Event= $row["Event"];
		$obj_Errorlog->Message= $row["Message"];
		$obj_Errorlog->metadata= $row["metadata"];
		$obj_Errorlog->Status= $row["Status"];

        }
		
		if($obj_Errorlog->_id >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Errorlog;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getErrorlogListBy_id($_id)
    {
    		
        $db = config::dbconfig();

        $arr_ErrorlogList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_errorlog WHERE _id=".$_id." ORDER BY _id DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Errorlog = new Errorlog();
		$obj_Errorlog->_id= $row["_id"];
		$obj_Errorlog->LoggedTime= $row["LoggedTime"];
		$obj_Errorlog->Tag= $row["Tag"];
		$obj_Errorlog->Place= $row["Place"];
		$obj_Errorlog->Event= $row["Event"];
		$obj_Errorlog->Message= $row["Message"];
		$obj_Errorlog->metadata= $row["metadata"];
		$obj_Errorlog->Status= $row["Status"];

        array_push($arr_ErrorlogList, $obj_Errorlog);
        }
		
		if(count($arr_ErrorlogList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_ErrorlogList;
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
        $sql = "DELETE FROM tbl_errorlog WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Errorlog)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Errorlog SET ". 
	"_id=".common::noSqlInject($obj_Errorlog->_id).","."LoggedTime="."'".common::noSqlInject($obj_Errorlog->LoggedTime)."'".","."Tag="."'".common::noSqlInject($obj_Errorlog->Tag)."'".","."Place="."'".common::noSqlInject($obj_Errorlog->Place)."'".","."Event="."'".common::noSqlInject($obj_Errorlog->Event)."'".","."Message="."'".common::noSqlInject($obj_Errorlog->Message)."'".","."metadata="."'".common::noSqlInject($obj_Errorlog->metadata)."'".","."Status=".common::noSqlInject($obj_Errorlog->Status).	        
	" WHERE  _id=".$obj_Errorlog->_id;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Errorlog;
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
	
	public static function disableErrorlog($_id)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Errorlog SET Status=0 WHERE  _id=".$_id;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Errorlog;
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
