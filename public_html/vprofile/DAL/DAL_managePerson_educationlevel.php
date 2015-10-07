<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_educationlevel
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_educationlevel($obj_Person_educationlevel)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_educationlevel->EducationLevelId = DAL_managePerson_educationlevel::getLastPerson_educationlevelId()+1;
		
		 $sql = "INSERT INTO tbl_person_educationlevel (EducationLevelId,SchoolId,StartYear,StartClass,EndYear,EndClass,PersonId) 
		VALUES (".
		common::noSqlInject($obj_Person_educationlevel->EducationLevelId).",".common::noSqlInject($obj_Person_educationlevel->SchoolId).","."'".common::noSqlInject($obj_Person_educationlevel->StartYear)."'".","."'".common::noSqlInject($obj_Person_educationlevel->StartClass)."'".","."'".common::noSqlInject($obj_Person_educationlevel->EndYear)."'".","."'".common::noSqlInject($obj_Person_educationlevel->EndClass)."'".",".common::noSqlInject($obj_Person_educationlevel->PersonId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_educationlevel;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_educationlevelId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(EducationLevelId) as maxId FROM  tbl_person_educationlevel";
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

    public static function getPerson_educationlevelList()
    {
    	  $db = config::dbconfig();

        $arr_Person_educationlevelList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_educationlevel ORDER BY EducationLevelId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_educationlevel = new Person_educationlevel();
		$obj_Person_educationlevel->EducationLevelId= $row["EducationLevelId"];
		$obj_Person_educationlevel->SchoolId= $row["SchoolId"];
		$obj_Person_educationlevel->StartYear= $row["StartYear"];
		$obj_Person_educationlevel->StartClass= $row["StartClass"];
		$obj_Person_educationlevel->EndYear= $row["EndYear"];
		$obj_Person_educationlevel->EndClass= $row["EndClass"];
		$obj_Person_educationlevel->PersonId= $row["PersonId"];

        array_push($arr_Person_educationlevelList, $obj_Person_educationlevel);
        }
		
		if(count($arr_Person_educationlevelList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_educationlevelList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_educationlevelByEducationLevelId($EducationLevelId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_educationlevel = new Person_educationlevel();
		$sql = "SELECT * FROM tbl_person_educationlevel WHERE EducationLevelId=".$EducationLevelId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_educationlevel->EducationLevelId= $row["EducationLevelId"];
		$obj_Person_educationlevel->SchoolId= $row["SchoolId"];
		$obj_Person_educationlevel->StartYear= $row["StartYear"];
		$obj_Person_educationlevel->StartClass= $row["StartClass"];
		$obj_Person_educationlevel->EndYear= $row["EndYear"];
		$obj_Person_educationlevel->EndClass= $row["EndClass"];
		$obj_Person_educationlevel->PersonId= $row["PersonId"];

        }
		
		if(count($arr_Person_educationlevelList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_educationlevel;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_educationlevelListByPersonId($PersonId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_educationlevelList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_educationlevel WHERE PersonId=".$PersonId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_educationlevel = new Person_educationlevel();
		$obj_Person_educationlevel->EducationLevelId= $row["EducationLevelId"];
		$obj_Person_educationlevel->SchoolId= $row["SchoolId"];
		$obj_Person_educationlevel->StartYear= $row["StartYear"];
		$obj_Person_educationlevel->StartClass= $row["StartClass"];
		$obj_Person_educationlevel->EndYear= $row["EndYear"];
		$obj_Person_educationlevel->EndClass= $row["EndClass"];
		$obj_Person_educationlevel->PersonId= $row["PersonId"];

        array_push($arr_Person_educationlevelList, $obj_Person_educationlevel);
        }
		
		if(count($arr_Person_educationlevelList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_educationlevelList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_educationlevelListByEducationLevelId($EducationLevelId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_educationlevelList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_educationlevel WHERE EducationLevelId=".$EducationLevelId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_educationlevel = new Person_educationlevel();
		$obj_Person_educationlevel->EducationLevelId= $row["EducationLevelId"];
		$obj_Person_educationlevel->SchoolId= $row["SchoolId"];
		$obj_Person_educationlevel->StartYear= $row["StartYear"];
		$obj_Person_educationlevel->StartClass= $row["StartClass"];
		$obj_Person_educationlevel->EndYear= $row["EndYear"];
		$obj_Person_educationlevel->EndClass= $row["EndClass"];
		$obj_Person_educationlevel->PersonId= $row["PersonId"];

        array_push($arr_Person_educationlevelList, $obj_Person_educationlevel);
        }
		
		if(count($arr_Person_educationlevelList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_educationlevelList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function delete($EducationLevelId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_educationlevel WHERE EducationLevelId=".$EducationLevelId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_educationlevel)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_educationlevel SET ". 
	"EducationLevelId=".common::noSqlInject($obj_Person_educationlevel->EducationLevelId).","."SchoolId=".common::noSqlInject($obj_Person_educationlevel->SchoolId).","."StartYear="."'".common::noSqlInject($obj_Person_educationlevel->StartYear)."'".","."StartClass="."'".common::noSqlInject($obj_Person_educationlevel->StartClass)."'".","."EndYear="."'".common::noSqlInject($obj_Person_educationlevel->EndYear)."'".","."EndClass="."'".common::noSqlInject($obj_Person_educationlevel->EndClass)."'".","."PersonId=".common::noSqlInject($obj_Person_educationlevel->PersonId).	        
	" WHERE  EducationLevelId=".$obj_Person_educationlevel->EducationLevelId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_educationlevel;
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
	
	public static function disablePerson_educationlevel($EducationLevelId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_educationlevel SET Status=0 WHERE  EducationLevelId=".$EducationLevelId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_educationlevel;
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