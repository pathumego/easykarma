<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_highereducation
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_highereducation($obj_Person_highereducation)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_highereducation->ResultId = DAL_managePerson_highereducation::getLastPerson_highereducationId()+1;
		
		 $sql = "INSERT INTO tbl_person_highereducation (ResultId,SubjectId,InstituteId,Grade,Language,DateTime,PersonId,Level) 
		VALUES (".
		common::noSqlInject($obj_Person_highereducation->ResultId).","."'".common::noSqlInject($obj_Person_highereducation->SubjectId)."'".","."'".common::noSqlInject($obj_Person_highereducation->InstituteId)."'".","."'".common::noSqlInject($obj_Person_highereducation->Grade)."'".","."'".common::noSqlInject($obj_Person_highereducation->Language)."'".","."'".common::noSqlInject($obj_Person_highereducation->DateTime)."'".",".common::noSqlInject($obj_Person_highereducation->PersonId).","."'".common::noSqlInject($obj_Person_highereducation->Level)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_highereducation;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_highereducationId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(ResultId) as maxId FROM  tbl_person_highereducation";
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

    public static function getPerson_highereducationList()
    {
    	  $db = config::dbconfig();

        $arr_Person_highereducationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_highereducation ORDER BY ResultId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_highereducation = new Person_highereducation();
		$obj_Person_highereducation->ResultId= $row["ResultId"];
		$obj_Person_highereducation->SubjectId= $row["SubjectId"];
		$obj_Person_highereducation->InstituteId= $row["InstituteId"];
		$obj_Person_highereducation->Grade= $row["Grade"];
		$obj_Person_highereducation->Language= $row["Language"];
		$obj_Person_highereducation->DateTime= $row["DateTime"];
		$obj_Person_highereducation->PersonId= $row["PersonId"];
		$obj_Person_highereducation->Level= $row["Level"];

        array_push($arr_Person_highereducationList, $obj_Person_highereducation);
        }
		
		if(count($arr_Person_highereducationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_highereducationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_highereducationByResultId($ResultId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_highereducation = new Person_highereducation();
		$sql = "SELECT * FROM tbl_person_highereducation WHERE ResultId=".$ResultId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_highereducation->ResultId= $row["ResultId"];
		$obj_Person_highereducation->SubjectId= $row["SubjectId"];
		$obj_Person_highereducation->InstituteId= $row["InstituteId"];
		$obj_Person_highereducation->Grade= $row["Grade"];
		$obj_Person_highereducation->Language= $row["Language"];
		$obj_Person_highereducation->DateTime= $row["DateTime"];
		$obj_Person_highereducation->PersonId= $row["PersonId"];
		$obj_Person_highereducation->Level= $row["Level"];

        }
		
		if(count($arr_Person_highereducationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_highereducation;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
		//---------------------------------------------------------------------------------------------------------

    public static function getPerson_highereducationListByPersonId($PersonId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_highereducationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_highereducation WHERE PersonId=".$PersonId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_highereducation = new Person_highereducation();
		$obj_Person_highereducation->ResultId= $row["ResultId"];
		$obj_Person_highereducation->SubjectId= $row["SubjectId"];
		$obj_Person_highereducation->InstituteId= $row["InstituteId"];
		$obj_Person_highereducation->Grade= $row["Grade"];
		$obj_Person_highereducation->Language= $row["Language"];
		$obj_Person_highereducation->DateTime= $row["DateTime"];
		$obj_Person_highereducation->PersonId= $row["PersonId"];
		$obj_Person_highereducation->Level= $row["Level"];

        array_push($arr_Person_highereducationList, $obj_Person_highereducation);
        }
		
		if(count($arr_Person_highereducationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_highereducationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_highereducationListByResultId($ResultId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_highereducationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_highereducation WHERE ResultId=".$ResultId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_highereducation = new Person_highereducation();
		$obj_Person_highereducation->ResultId= $row["ResultId"];
		$obj_Person_highereducation->SubjectId= $row["SubjectId"];
		$obj_Person_highereducation->InstituteId= $row["InstituteId"];
		$obj_Person_highereducation->Grade= $row["Grade"];
		$obj_Person_highereducation->Language= $row["Language"];
		$obj_Person_highereducation->DateTime= $row["DateTime"];
		$obj_Person_highereducation->PersonId= $row["PersonId"];
		$obj_Person_highereducation->Level= $row["Level"];

        array_push($arr_Person_highereducationList, $obj_Person_highereducation);
        }
		
		if(count($arr_Person_highereducationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_highereducationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function delete($ResultId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_highereducation WHERE ResultId=".$ResultId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_highereducation)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_highereducation SET ". 
	"ResultId=".common::noSqlInject($obj_Person_highereducation->ResultId).","."SubjectId="."'".common::noSqlInject($obj_Person_highereducation->SubjectId)."'".","."InstituteId="."'".common::noSqlInject($obj_Person_highereducation->InstituteId)."'".","."Grade="."'".common::noSqlInject($obj_Person_highereducation->Grade)."'".","."Language="."'".common::noSqlInject($obj_Person_highereducation->Language)."'".","."DateTime="."'".common::noSqlInject($obj_Person_highereducation->DateTime)."'".","."PersonId=".common::noSqlInject($obj_Person_highereducation->PersonId).","."Level="."'".common::noSqlInject($obj_Person_highereducation->Level)."'".	        
	" WHERE  ResultId=".$obj_Person_highereducation->ResultId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_highereducation;
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
	
	public static function disablePerson_highereducation($ResultId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_highereducation SET Status=0 WHERE  ResultId=".$ResultId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_highereducation;
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