<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_olresult
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_olresult($obj_Person_olresult)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_olresult->OLResultId = DAL_managePerson_olresult::getLastPerson_olresultId()+1;
		
		 $sql = "INSERT INTO tbl_person_olresult (OLResultId,SubjectId,SchoolId,Grade,Language,DateTime,PersonId) 
		VALUES (".
		common::noSqlInject($obj_Person_olresult->OLResultId).","."'".common::noSqlInject($obj_Person_olresult->SubjectId)."'".","."'".common::noSqlInject($obj_Person_olresult->SchoolId)."'".","."'".common::noSqlInject($obj_Person_olresult->Grade)."'".","."'".common::noSqlInject($obj_Person_olresult->Language)."'".","."'".common::noSqlInject($obj_Person_olresult->DateTime)."'".",".common::noSqlInject($obj_Person_olresult->PersonId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_olresult;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_olresultId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(OLResultId) as maxId FROM  tbl_person_olresult";
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

    public static function getPerson_olresultList()
    {
    	  $db = config::dbconfig();

        $arr_Person_olresultList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_olresult ORDER BY OLResultId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_olresult = new Person_olresult();
		$obj_Person_olresult->OLResultId= $row["OLResultId"];
		$obj_Person_olresult->SubjectId= $row["SubjectId"];
		$obj_Person_olresult->SchoolId= $row["SchoolId"];
		$obj_Person_olresult->Grade= $row["Grade"];
		$obj_Person_olresult->Language= $row["Language"];
		$obj_Person_olresult->DateTime= $row["DateTime"];
		$obj_Person_olresult->PersonId= $row["PersonId"];

        array_push($arr_Person_olresultList, $obj_Person_olresult);
        }
		
		if(count($arr_Person_olresultList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_olresultList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_olresultByOLResultId($OLResultId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_olresult = new Person_olresult();
		$obj_Person_olresult->OLResultId = -1;
		$sql = "SELECT * FROM tbl_person_olresult WHERE OLResultId=".$OLResultId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_olresult->OLResultId= $row["OLResultId"];
		$obj_Person_olresult->SubjectId= $row["SubjectId"];
		$obj_Person_olresult->SchoolId= $row["SchoolId"];
		$obj_Person_olresult->Grade= $row["Grade"];
		$obj_Person_olresult->Language= $row["Language"];
		$obj_Person_olresult->DateTime= $row["DateTime"];
		$obj_Person_olresult->PersonId= $row["PersonId"];

        }
		
		if($obj_Person_olresult->OLResultId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_olresult;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_olresultListByOLResultId($OLResultId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_olresultList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_olresult WHERE OLResultId=".$OLResultId." ORDER BY OLResultId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_olresult = new Person_olresult();
		$obj_Person_olresult->OLResultId= $row["OLResultId"];
		$obj_Person_olresult->SubjectId= $row["SubjectId"];
		$obj_Person_olresult->SchoolId= $row["SchoolId"];
		$obj_Person_olresult->Grade= $row["Grade"];
		$obj_Person_olresult->Language= $row["Language"];
		$obj_Person_olresult->DateTime= $row["DateTime"];
		$obj_Person_olresult->PersonId= $row["PersonId"];

        array_push($arr_Person_olresultList, $obj_Person_olresult);
        }
		
		if(count($arr_Person_olresultList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_olresultList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePerson_olresult($OLResultId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_olresult WHERE OLResultId=".$OLResultId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_olresult)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_olresult SET ". 
	"OLResultId=".common::noSqlInject($obj_Person_olresult->OLResultId).","."SubjectId="."'".common::noSqlInject($obj_Person_olresult->SubjectId)."'".","."SchoolId="."'".common::noSqlInject($obj_Person_olresult->SchoolId)."'".","."Grade="."'".common::noSqlInject($obj_Person_olresult->Grade)."'".","."Language="."'".common::noSqlInject($obj_Person_olresult->Language)."'".","."DateTime="."'".common::noSqlInject($obj_Person_olresult->DateTime)."'".","."PersonId=".common::noSqlInject($obj_Person_olresult->PersonId).	        
	" WHERE  OLResultId=".$obj_Person_olresult->OLResultId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_olresult;
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
	
	public static function disablePerson_olresult($OLResultId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_olresult SET Status=0 WHERE  OLResultId=".$OLResultId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_olresult;
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
