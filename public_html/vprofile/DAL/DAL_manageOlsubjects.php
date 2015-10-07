<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageOlsubjects
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addOlsubjects($obj_Olsubjects)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Olsubjects->SubjectId = DAL_manageOlsubjects::getLastOlsubjectsId()+1;
		
		 $sql = "INSERT INTO tbl_olsubjects (SubjectId,SubjectName,SubjectNumber) 
		VALUES (".
		common::noSqlInject($obj_Olsubjects->SubjectId).","."'".common::noSqlInject($obj_Olsubjects->SubjectName)."'".",".common::noSqlInject($obj_Olsubjects->SubjectNumber).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Olsubjects;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastOlsubjectsId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(SubjectId) as maxId FROM  tbl_olsubjects";
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

    public static function getOlsubjectsList()
    {
    	  $db = config::dbconfig();

        $arr_OlsubjectsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_olsubjects ORDER BY SubjectId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Olsubjects = new Olsubjects();
		$obj_Olsubjects->SubjectId= $row["SubjectId"];
		$obj_Olsubjects->SubjectName= $row["SubjectName"];
		$obj_Olsubjects->SubjectNumber= $row["SubjectNumber"];

        array_push($arr_OlsubjectsList, $obj_Olsubjects);
        }
		
		if(count($arr_OlsubjectsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_OlsubjectsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getOlsubjectsBySubjectId($SubjectId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Olsubjects = new Olsubjects();
		$obj_Olsubjects->SubjectId = -1;
		$sql = "SELECT * FROM tbl_olsubjects WHERE SubjectId=".$SubjectId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Olsubjects->SubjectId= $row["SubjectId"];
		$obj_Olsubjects->SubjectName= $row["SubjectName"];
		$obj_Olsubjects->SubjectNumber= $row["SubjectNumber"];

        }
		
		if($obj_Olsubjects->SubjectId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Olsubjects;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getOlsubjectsListBySubjectId($SubjectId)
    {
    		
        $db = config::dbconfig();

        $arr_OlsubjectsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_olsubjects WHERE SubjectId=".$SubjectId." ORDER BY SubjectId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Olsubjects = new Olsubjects();
		$obj_Olsubjects->SubjectId= $row["SubjectId"];
		$obj_Olsubjects->SubjectName= $row["SubjectName"];
		$obj_Olsubjects->SubjectNumber= $row["SubjectNumber"];

        array_push($arr_OlsubjectsList, $obj_Olsubjects);
        }
		
		if(count($arr_OlsubjectsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_OlsubjectsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteOlsubjects($SubjectId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_olsubjects WHERE SubjectId=".$SubjectId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Olsubjects)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Olsubjects SET ". 
	"SubjectId=".common::noSqlInject($obj_Olsubjects->SubjectId).","."SubjectName="."'".common::noSqlInject($obj_Olsubjects->SubjectName)."'".","."SubjectNumber=".common::noSqlInject($obj_Olsubjects->SubjectNumber).	        
	" WHERE  SubjectId=".$obj_Olsubjects->SubjectId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Olsubjects;
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
	
	public static function disableOlsubjects($SubjectId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Olsubjects SET Status=0 WHERE  SubjectId=".$SubjectId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Olsubjects;
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
