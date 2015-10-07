<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_workingexperiance
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_workingexperiance($obj_Person_workingexperiance)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_workingexperiance->WorkExpId = DAL_managePerson_workingexperiance::getLastPerson_workingexperianceId()+1;
		
		 $sql = "INSERT INTO tbl_person_workingexperiance (WorkExpId,CompanyId,StartDate,EndDate,Position,PersonId) 
		VALUES (".
		common::noSqlInject($obj_Person_workingexperiance->WorkExpId).",".common::noSqlInject($obj_Person_workingexperiance->CompanyId).","."'".common::noSqlInject($obj_Person_workingexperiance->StartDate)."'".","."'".common::noSqlInject($obj_Person_workingexperiance->EndDate)."'".","."'".common::noSqlInject($obj_Person_workingexperiance->Position)."'".",".common::noSqlInject($obj_Person_workingexperiance->PersonId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_workingexperiance;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_workingexperianceId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(WorkExpId) as maxId FROM  tbl_person_workingexperiance";
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

    public static function getPerson_workingexperianceList()
    {
    	  $db = config::dbconfig();

        $arr_Person_workingexperianceList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_workingexperiance ORDER BY WorkExpId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_workingexperiance = new Person_workingexperiance();
		$obj_Person_workingexperiance->WorkExpId= $row["WorkExpId"];
		$obj_Person_workingexperiance->CompanyId= $row["CompanyId"];
		$obj_Person_workingexperiance->StartDate= $row["StartDate"];
		$obj_Person_workingexperiance->EndDate= $row["EndDate"];
		$obj_Person_workingexperiance->Position= $row["Position"];
		$obj_Person_workingexperiance->PersonId= $row["PersonId"];

        array_push($arr_Person_workingexperianceList, $obj_Person_workingexperiance);
        }
		
		if(count($arr_Person_workingexperianceList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_workingexperianceList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_workingexperianceByWorkExpId($WorkExpId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_workingexperiance = new Person_workingexperiance();
		$obj_Person_workingexperiance->WorkExpId = -1;
		$sql = "SELECT * FROM tbl_person_workingexperiance WHERE WorkExpId=".$WorkExpId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_workingexperiance->WorkExpId= $row["WorkExpId"];
		$obj_Person_workingexperiance->CompanyId= $row["CompanyId"];
		$obj_Person_workingexperiance->StartDate= $row["StartDate"];
		$obj_Person_workingexperiance->EndDate= $row["EndDate"];
		$obj_Person_workingexperiance->Position= $row["Position"];
		$obj_Person_workingexperiance->PersonId= $row["PersonId"];

        }
		
		if($obj_Person_workingexperiance->WorkExpId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_workingexperiance;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_workingexperianceListByWorkExpId($WorkExpId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_workingexperianceList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_workingexperiance WHERE WorkExpId=".$WorkExpId." ORDER BY WorkExpId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_workingexperiance = new Person_workingexperiance();
		$obj_Person_workingexperiance->WorkExpId= $row["WorkExpId"];
		$obj_Person_workingexperiance->CompanyId= $row["CompanyId"];
		$obj_Person_workingexperiance->StartDate= $row["StartDate"];
		$obj_Person_workingexperiance->EndDate= $row["EndDate"];
		$obj_Person_workingexperiance->Position= $row["Position"];
		$obj_Person_workingexperiance->PersonId= $row["PersonId"];

        array_push($arr_Person_workingexperianceList, $obj_Person_workingexperiance);
        }
		
		if(count($arr_Person_workingexperianceList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_workingexperianceList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePerson_workingexperiance($WorkExpId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_workingexperiance WHERE WorkExpId=".$WorkExpId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_workingexperiance)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_workingexperiance SET ". 
	"WorkExpId=".common::noSqlInject($obj_Person_workingexperiance->WorkExpId).","."CompanyId=".common::noSqlInject($obj_Person_workingexperiance->CompanyId).","."StartDate="."'".common::noSqlInject($obj_Person_workingexperiance->StartDate)."'".","."EndDate="."'".common::noSqlInject($obj_Person_workingexperiance->EndDate)."'".","."Position="."'".common::noSqlInject($obj_Person_workingexperiance->Position)."'".","."PersonId=".common::noSqlInject($obj_Person_workingexperiance->PersonId).	        
	" WHERE  WorkExpId=".$obj_Person_workingexperiance->WorkExpId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_workingexperiance;
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
	
	public static function disablePerson_workingexperiance($WorkExpId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_workingexperiance SET Status=0 WHERE  WorkExpId=".$WorkExpId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_workingexperiance;
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
