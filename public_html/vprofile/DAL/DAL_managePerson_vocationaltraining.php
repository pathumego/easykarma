<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_vocationaltraining
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_vocationaltraining($obj_Person_vocationaltraining)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_vocationaltraining->VocationalTrainId = DAL_managePerson_vocationaltraining::getLastPerson_vocationaltrainingId()+1;
		
		 $sql = "INSERT INTO tbl_person_vocationaltraining (VocationalTrainId,FieldName,CourseName,InstituteId,StartDate,EndDate,CertificateType,PersonId) 
		VALUES (".
		common::noSqlInject($obj_Person_vocationaltraining->VocationalTrainId).","."'".common::noSqlInject($obj_Person_vocationaltraining->FieldName)."'".","."'".common::noSqlInject($obj_Person_vocationaltraining->CourseName)."'".",".common::noSqlInject($obj_Person_vocationaltraining->InstituteId).","."'".common::noSqlInject($obj_Person_vocationaltraining->StartDate)."'".","."'".common::noSqlInject($obj_Person_vocationaltraining->EndDate)."'".","."'".common::noSqlInject($obj_Person_vocationaltraining->CertificateType)."'".",".common::noSqlInject($obj_Person_vocationaltraining->PersonId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_vocationaltraining;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_vocationaltrainingId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(VocationalTrainId) as maxId FROM  tbl_person_vocationaltraining";
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

    public static function getPerson_vocationaltrainingList()
    {
    	  $db = config::dbconfig();

        $arr_Person_vocationaltrainingList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_vocationaltraining ORDER BY VocationalTrainId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_vocationaltraining = new Person_vocationaltraining();
		$obj_Person_vocationaltraining->VocationalTrainId= $row["VocationalTrainId"];
		$obj_Person_vocationaltraining->FieldName= $row["FieldName"];
		$obj_Person_vocationaltraining->CourseName= $row["CourseName"];
		$obj_Person_vocationaltraining->InstituteId= $row["InstituteId"];
		$obj_Person_vocationaltraining->StartDate= $row["StartDate"];
		$obj_Person_vocationaltraining->EndDate= $row["EndDate"];
		$obj_Person_vocationaltraining->CertificateType= $row["CertificateType"];
		$obj_Person_vocationaltraining->PersonId= $row["PersonId"];

        array_push($arr_Person_vocationaltrainingList, $obj_Person_vocationaltraining);
        }
		
		if(count($arr_Person_vocationaltrainingList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_vocationaltrainingList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_vocationaltrainingByVocationalTrainId($VocationalTrainId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_vocationaltraining = new Person_vocationaltraining();
		$obj_Person_vocationaltraining->VocationalTrainId = -1;
		$sql = "SELECT * FROM tbl_person_vocationaltraining WHERE VocationalTrainId=".$VocationalTrainId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_vocationaltraining->VocationalTrainId= $row["VocationalTrainId"];
		$obj_Person_vocationaltraining->FieldName= $row["FieldName"];
		$obj_Person_vocationaltraining->CourseName= $row["CourseName"];
		$obj_Person_vocationaltraining->InstituteId= $row["InstituteId"];
		$obj_Person_vocationaltraining->StartDate= $row["StartDate"];
		$obj_Person_vocationaltraining->EndDate= $row["EndDate"];
		$obj_Person_vocationaltraining->CertificateType= $row["CertificateType"];
		$obj_Person_vocationaltraining->PersonId= $row["PersonId"];

        }
		
		if($obj_Person_vocationaltraining->VocationalTrainId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_vocationaltraining;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_vocationaltrainingListByVocationalTrainId($VocationalTrainId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_vocationaltrainingList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_vocationaltraining WHERE VocationalTrainId=".$VocationalTrainId." ORDER BY VocationalTrainId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_vocationaltraining = new Person_vocationaltraining();
		$obj_Person_vocationaltraining->VocationalTrainId= $row["VocationalTrainId"];
		$obj_Person_vocationaltraining->FieldName= $row["FieldName"];
		$obj_Person_vocationaltraining->CourseName= $row["CourseName"];
		$obj_Person_vocationaltraining->InstituteId= $row["InstituteId"];
		$obj_Person_vocationaltraining->StartDate= $row["StartDate"];
		$obj_Person_vocationaltraining->EndDate= $row["EndDate"];
		$obj_Person_vocationaltraining->CertificateType= $row["CertificateType"];
		$obj_Person_vocationaltraining->PersonId= $row["PersonId"];

        array_push($arr_Person_vocationaltrainingList, $obj_Person_vocationaltraining);
        }
		
		if(count($arr_Person_vocationaltrainingList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_vocationaltrainingList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePerson_vocationaltraining($VocationalTrainId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_vocationaltraining WHERE VocationalTrainId=".$VocationalTrainId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_vocationaltraining)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_vocationaltraining SET ". 
	"VocationalTrainId=".common::noSqlInject($obj_Person_vocationaltraining->VocationalTrainId).","."FieldName="."'".common::noSqlInject($obj_Person_vocationaltraining->FieldName)."'".","."CourseName="."'".common::noSqlInject($obj_Person_vocationaltraining->CourseName)."'".","."InstituteId=".common::noSqlInject($obj_Person_vocationaltraining->InstituteId).","."StartDate="."'".common::noSqlInject($obj_Person_vocationaltraining->StartDate)."'".","."EndDate="."'".common::noSqlInject($obj_Person_vocationaltraining->EndDate)."'".","."CertificateType="."'".common::noSqlInject($obj_Person_vocationaltraining->CertificateType)."'".","."PersonId=".common::noSqlInject($obj_Person_vocationaltraining->PersonId).	        
	" WHERE  VocationalTrainId=".$obj_Person_vocationaltraining->VocationalTrainId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_vocationaltraining;
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
	
	public static function disablePerson_vocationaltraining($VocationalTrainId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_vocationaltraining SET Status=0 WHERE  VocationalTrainId=".$VocationalTrainId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_vocationaltraining;
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
