<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageAlsubjects
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addAlsubjects($obj_Alsubjects)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Alsubjects->SubjectId = DAL_manageAlsubjects::getLastAlsubjectsId()+1;
		
		 $sql = "INSERT INTO tbl_alsubjects (SubjectId,SubjectName,SubjectNumber) 
		VALUES (".
		common::noSqlInject($obj_Alsubjects->SubjectId).","."'".common::noSqlInject($obj_Alsubjects->SubjectName)."'".",".common::noSqlInject($obj_Alsubjects->SubjectNumber).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Alsubjects;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastAlsubjectsId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(SubjectId) as maxId FROM  tbl_alsubjects";
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

    public static function getAlsubjectsList()
    {
    	  $db = config::dbconfig();

        $arr_AlsubjectsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_alsubjects ORDER BY SubjectId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Alsubjects = new Alsubjects();
		$obj_Alsubjects->SubjectId= $row["SubjectId"];
		$obj_Alsubjects->SubjectName= $row["SubjectName"];
		$obj_Alsubjects->SubjectNumber= $row["SubjectNumber"];

        array_push($arr_AlsubjectsList, $obj_Alsubjects);
        }
		
		if(count($arr_AlsubjectsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_AlsubjectsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getAlsubjectsBySubjectId($SubjectId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Alsubjects = new Alsubjects();
		$obj_Alsubjects->SubjectId = -1;
		$sql = "SELECT * FROM tbl_alsubjects WHERE SubjectId=".$SubjectId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Alsubjects->SubjectId= $row["SubjectId"];
		$obj_Alsubjects->SubjectName= $row["SubjectName"];
		$obj_Alsubjects->SubjectNumber= $row["SubjectNumber"];

        }
		
		if($obj_Alsubjects->SubjectId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Alsubjects;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getAlsubjectsListBySubjectId($SubjectId)
    {
    		
        $db = config::dbconfig();

        $arr_AlsubjectsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_alsubjects WHERE SubjectId=".$SubjectId." ORDER BY SubjectId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Alsubjects = new Alsubjects();
		$obj_Alsubjects->SubjectId= $row["SubjectId"];
		$obj_Alsubjects->SubjectName= $row["SubjectName"];
		$obj_Alsubjects->SubjectNumber= $row["SubjectNumber"];

        array_push($arr_AlsubjectsList, $obj_Alsubjects);
        }
		
		if(count($arr_AlsubjectsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_AlsubjectsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteAlsubjects($SubjectId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_alsubjects WHERE SubjectId=".$SubjectId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Alsubjects)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Alsubjects SET ". 
	"SubjectId=".common::noSqlInject($obj_Alsubjects->SubjectId).","."SubjectName="."'".common::noSqlInject($obj_Alsubjects->SubjectName)."'".","."SubjectNumber=".common::noSqlInject($obj_Alsubjects->SubjectNumber).	        
	" WHERE  SubjectId=".$obj_Alsubjects->SubjectId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Alsubjects;
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
	
	public static function disableAlsubjects($SubjectId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Alsubjects SET Status=0 WHERE  SubjectId=".$SubjectId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Alsubjects;
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
