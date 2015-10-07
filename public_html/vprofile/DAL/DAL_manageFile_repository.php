<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageFile_repository
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addFile_repository($obj_File_repository)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_File_repository->_id = DAL_manageFile_repository::getLastFile_repositoryId()+1;
		
		 $sql = "INSERT INTO tbl_file_repository (_id,LoggedTime,FileName,FilePath,AgentID,JobID,Extension,metadata,Status) 
		VALUES (".
		common::noSqlInject($obj_File_repository->_id).","."'".common::noSqlInject($obj_File_repository->LoggedTime)."'".","."'".common::noSqlInject($obj_File_repository->FileName)."'".","."'".common::noSqlInject($obj_File_repository->FilePath)."'".","."'".common::noSqlInject($obj_File_repository->AgentID)."'".","."'".common::noSqlInject($obj_File_repository->JobID)."'".","."'".common::noSqlInject($obj_File_repository->Extension)."'".","."'".common::noSqlInject($obj_File_repository->metadata)."'".",".common::noSqlInject($obj_File_repository->Status).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_File_repository;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastFile_repositoryId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(_id) as maxId FROM  tbl_file_repository";
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

    public static function getFile_repositoryList()
    {
    	  $db = config::dbconfig();

        $arr_File_repositoryList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_file_repository ORDER BY _id DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_File_repository = new File_repository();
		$obj_File_repository->_id= $row["_id"];
		$obj_File_repository->LoggedTime= $row["LoggedTime"];
		$obj_File_repository->FileName= $row["FileName"];
		$obj_File_repository->FilePath= $row["FilePath"];
		$obj_File_repository->AgentID= $row["AgentID"];
		$obj_File_repository->JobID= $row["JobID"];
		$obj_File_repository->Extension= $row["Extension"];
		$obj_File_repository->metadata= $row["metadata"];
		$obj_File_repository->Status= $row["Status"];

        array_push($arr_File_repositoryList, $obj_File_repository);
        }
		
		if(count($arr_File_repositoryList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_File_repositoryList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getFile_repositoryBy_id($_id)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_File_repository = new File_repository();
		$obj_File_repository->_id = -1;
		$sql = "SELECT * FROM tbl_file_repository WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_File_repository->_id= $row["_id"];
		$obj_File_repository->LoggedTime= $row["LoggedTime"];
		$obj_File_repository->FileName= $row["FileName"];
		$obj_File_repository->FilePath= $row["FilePath"];
		$obj_File_repository->AgentID= $row["AgentID"];
		$obj_File_repository->JobID= $row["JobID"];
		$obj_File_repository->Extension= $row["Extension"];
		$obj_File_repository->metadata= $row["metadata"];
		$obj_File_repository->Status= $row["Status"];

        }
		
		if($obj_File_repository->_id >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_File_repository;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getFile_repositoryListBy_id($_id)
    {
    		
        $db = config::dbconfig();

        $arr_File_repositoryList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_file_repository WHERE _id=".$_id." ORDER BY _id DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_File_repository = new File_repository();
		$obj_File_repository->_id= $row["_id"];
		$obj_File_repository->LoggedTime= $row["LoggedTime"];
		$obj_File_repository->FileName= $row["FileName"];
		$obj_File_repository->FilePath= $row["FilePath"];
		$obj_File_repository->AgentID= $row["AgentID"];
		$obj_File_repository->JobID= $row["JobID"];
		$obj_File_repository->Extension= $row["Extension"];
		$obj_File_repository->metadata= $row["metadata"];
		$obj_File_repository->Status= $row["Status"];

        array_push($arr_File_repositoryList, $obj_File_repository);
        }
		
		if(count($arr_File_repositoryList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_File_repositoryList;
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
        $sql = "DELETE FROM tbl_file_repository WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_File_repository)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_File_repository SET ". 
	"_id=".common::noSqlInject($obj_File_repository->_id).","."LoggedTime="."'".common::noSqlInject($obj_File_repository->LoggedTime)."'".","."FileName="."'".common::noSqlInject($obj_File_repository->FileName)."'".","."FilePath="."'".common::noSqlInject($obj_File_repository->FilePath)."'".","."AgentID="."'".common::noSqlInject($obj_File_repository->AgentID)."'".","."JobID="."'".common::noSqlInject($obj_File_repository->JobID)."'".","."Extension="."'".common::noSqlInject($obj_File_repository->Extension)."'".","."metadata="."'".common::noSqlInject($obj_File_repository->metadata)."'".","."Status=".common::noSqlInject($obj_File_repository->Status).	        
	" WHERE  _id=".$obj_File_repository->_id;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_File_repository;
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
	
	public static function disableFile_repository($_id)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_File_repository SET Status=0 WHERE  _id=".$_id;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_File_repository;
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
