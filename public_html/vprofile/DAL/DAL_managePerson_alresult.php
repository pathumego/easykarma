<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_alresult
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_alresult($obj_Person_alresult)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_alresult->ALResultId = DAL_managePerson_alresult::getLastPerson_alresultId()+1;
		
		 $sql = "INSERT INTO tbl_person_alresult (ALResultId,SubjectId,SchoolId,Grade,Language,DateTime,PersonId) 
		VALUES (".
		common::noSqlInject($obj_Person_alresult->ALResultId).","."'".common::noSqlInject($obj_Person_alresult->SubjectId)."'".","."'".common::noSqlInject($obj_Person_alresult->SchoolId)."'".","."'".common::noSqlInject($obj_Person_alresult->Grade)."'".","."'".common::noSqlInject($obj_Person_alresult->Language)."'".","."'".common::noSqlInject($obj_Person_alresult->DateTime)."'".",".common::noSqlInject($obj_Person_alresult->PersonId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_alresult;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_alresultId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(ALResultId) as maxId FROM  tbl_person_alresult";
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

    public static function getPerson_alresultList()
    {
    	  $db = config::dbconfig();

        $arr_Person_alresultList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_alresult ORDER BY ALResultId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_alresult = new Person_alresult();
		$obj_Person_alresult->ALResultId= $row["ALResultId"];
		$obj_Person_alresult->SubjectId= $row["SubjectId"];
		$obj_Person_alresult->SchoolId= $row["SchoolId"];
		$obj_Person_alresult->Grade= $row["Grade"];
		$obj_Person_alresult->Language= $row["Language"];
		$obj_Person_alresult->DateTime= $row["DateTime"];
		$obj_Person_alresult->PersonId= $row["PersonId"];

        array_push($arr_Person_alresultList, $obj_Person_alresult);
        }
		
		if(count($arr_Person_alresultList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_alresultList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_alresultByALResultId($ALResultId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_alresult = new Person_alresult();
		$sql = "SELECT * FROM tbl_person_alresult WHERE ALResultId=".$ALResultId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_alresult->ALResultId= $row["ALResultId"];
		$obj_Person_alresult->SubjectId= $row["SubjectId"];
		$obj_Person_alresult->SchoolId= $row["SchoolId"];
		$obj_Person_alresult->Grade= $row["Grade"];
		$obj_Person_alresult->Language= $row["Language"];
		$obj_Person_alresult->DateTime= $row["DateTime"];
		$obj_Person_alresult->PersonId= $row["PersonId"];

        }
		
		if(count($arr_Person_alresultList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_alresult;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_alresultListByPersonId($PersonId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_alresultList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_alresult WHERE PersonId=".$PersonId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_alresult = new Person_alresult();
		$obj_Person_alresult->ALResultId= $row["ALResultId"];
		$obj_Person_alresult->SubjectId= $row["SubjectId"];
		$obj_Person_alresult->SchoolId= $row["SchoolId"];
		$obj_Person_alresult->Grade= $row["Grade"];
		$obj_Person_alresult->Language= $row["Language"];
		$obj_Person_alresult->DateTime= $row["DateTime"];
		$obj_Person_alresult->PersonId= $row["PersonId"];

        array_push($arr_Person_alresultList, $obj_Person_alresult);
        }
		
		if(count($arr_Person_alresultList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_alresultList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_alresultListByALResultId($ALResultId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_alresultList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_alresult WHERE ALResultId=".$ALResultId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_alresult = new Person_alresult();
		$obj_Person_alresult->ALResultId= $row["ALResultId"];
		$obj_Person_alresult->SubjectId= $row["SubjectId"];
		$obj_Person_alresult->SchoolId= $row["SchoolId"];
		$obj_Person_alresult->Grade= $row["Grade"];
		$obj_Person_alresult->Language= $row["Language"];
		$obj_Person_alresult->DateTime= $row["DateTime"];
		$obj_Person_alresult->PersonId= $row["PersonId"];

        array_push($arr_Person_alresultList, $obj_Person_alresult);
        }
		
		if(count($arr_Person_alresultList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_alresultList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function delete($ALResultId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_alresult WHERE ALResultId=".$ALResultId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_alresult)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_alresult SET ". 
	"ALResultId=".common::noSqlInject($obj_Person_alresult->ALResultId).","."SubjectId="."'".common::noSqlInject($obj_Person_alresult->SubjectId)."'".","."SchoolId="."'".common::noSqlInject($obj_Person_alresult->SchoolId)."'".","."Grade="."'".common::noSqlInject($obj_Person_alresult->Grade)."'".","."Language="."'".common::noSqlInject($obj_Person_alresult->Language)."'".","."DateTime="."'".common::noSqlInject($obj_Person_alresult->DateTime)."'".","."PersonId=".common::noSqlInject($obj_Person_alresult->PersonId).	        
	" WHERE  ALResultId=".$obj_Person_alresult->ALResultId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_alresult;
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
	
	public static function disablePerson_alresult($ALResultId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_alresult SET Status=0 WHERE  ALResultId=".$ALResultId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_alresult;
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