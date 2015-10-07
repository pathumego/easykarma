<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageImg_repository
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addImg_repository($obj_Img_repository)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Img_repository->_id = DAL_manageImg_repository::getLastImg_repositoryId()+1;
		
		 $sql = "INSERT INTO tbl_img_repository (_id,LoggedTime,ImgName,ImgPath,AgentID,JobID,ImgType,metadata,Status) 
		VALUES (".
		common::noSqlInject($obj_Img_repository->_id).","."'".common::noSqlInject($obj_Img_repository->LoggedTime)."'".","."'".common::noSqlInject($obj_Img_repository->ImgName)."'".","."'".common::noSqlInject($obj_Img_repository->ImgPath)."'".","."'".common::noSqlInject($obj_Img_repository->AgentID)."'".","."'".common::noSqlInject($obj_Img_repository->JobID)."'".","."'".common::noSqlInject($obj_Img_repository->ImgType)."'".","."'".common::noSqlInject($obj_Img_repository->metadata)."'".",".common::noSqlInject($obj_Img_repository->Status).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Img_repository;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastImg_repositoryId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(_id) as maxId FROM  tbl_img_repository";
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

    public static function getImg_repositoryList()
    {
    	  $db = config::dbconfig();

        $arr_Img_repositoryList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_img_repository ORDER BY _id DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Img_repository = new Img_repository();
		$obj_Img_repository->_id= $row["_id"];
		$obj_Img_repository->LoggedTime= $row["LoggedTime"];
		$obj_Img_repository->ImgName= $row["ImgName"];
		$obj_Img_repository->ImgPath= $row["ImgPath"];
		$obj_Img_repository->AgentID= $row["AgentID"];
		$obj_Img_repository->JobID= $row["JobID"];
		$obj_Img_repository->ImgType= $row["ImgType"];
		$obj_Img_repository->metadata= $row["metadata"];
		$obj_Img_repository->Status= $row["Status"];

        array_push($arr_Img_repositoryList, $obj_Img_repository);
        }
		
		if(count($arr_Img_repositoryList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Img_repositoryList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getImg_repositoryBy_id($_id)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Img_repository = new Img_repository();
		$obj_Img_repository->_id = -1;
		$sql = "SELECT * FROM tbl_img_repository WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Img_repository->_id= $row["_id"];
		$obj_Img_repository->LoggedTime= $row["LoggedTime"];
		$obj_Img_repository->ImgName= $row["ImgName"];
		$obj_Img_repository->ImgPath= $row["ImgPath"];
		$obj_Img_repository->AgentID= $row["AgentID"];
		$obj_Img_repository->JobID= $row["JobID"];
		$obj_Img_repository->ImgType= $row["ImgType"];
		$obj_Img_repository->metadata= $row["metadata"];
		$obj_Img_repository->Status= $row["Status"];

        }
		
		if($obj_Img_repository->_id >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Img_repository;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getImg_repositoryListBy_id($_id)
    {
    		
        $db = config::dbconfig();

        $arr_Img_repositoryList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_img_repository WHERE _id=".$_id." ORDER BY _id DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Img_repository = new Img_repository();
		$obj_Img_repository->_id= $row["_id"];
		$obj_Img_repository->LoggedTime= $row["LoggedTime"];
		$obj_Img_repository->ImgName= $row["ImgName"];
		$obj_Img_repository->ImgPath= $row["ImgPath"];
		$obj_Img_repository->AgentID= $row["AgentID"];
		$obj_Img_repository->JobID= $row["JobID"];
		$obj_Img_repository->ImgType= $row["ImgType"];
		$obj_Img_repository->metadata= $row["metadata"];
		$obj_Img_repository->Status= $row["Status"];

        array_push($arr_Img_repositoryList, $obj_Img_repository);
        }
		
		if(count($arr_Img_repositoryList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Img_repositoryList;
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
        $sql = "DELETE FROM tbl_img_repository WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Img_repository)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Img_repository SET ". 
	"_id=".common::noSqlInject($obj_Img_repository->_id).","."LoggedTime="."'".common::noSqlInject($obj_Img_repository->LoggedTime)."'".","."ImgName="."'".common::noSqlInject($obj_Img_repository->ImgName)."'".","."ImgPath="."'".common::noSqlInject($obj_Img_repository->ImgPath)."'".","."AgentID="."'".common::noSqlInject($obj_Img_repository->AgentID)."'".","."JobID="."'".common::noSqlInject($obj_Img_repository->JobID)."'".","."ImgType="."'".common::noSqlInject($obj_Img_repository->ImgType)."'".","."metadata="."'".common::noSqlInject($obj_Img_repository->metadata)."'".","."Status=".common::noSqlInject($obj_Img_repository->Status).	        
	" WHERE  _id=".$obj_Img_repository->_id;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Img_repository;
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
	
	public static function disableImg_repository($_id)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Img_repository SET Status=0 WHERE  _id=".$_id;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Img_repository;
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
