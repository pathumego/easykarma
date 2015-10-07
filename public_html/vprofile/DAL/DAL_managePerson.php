<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson($obj_Person)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person->PersonId = DAL_managePerson::getLastPersonId()+1;
		
	 $sql = "INSERT INTO tbl_person (PersonId,FullName,NickName,OtherNames,DrivingLicenceNo,PassportNo,PermanentAddress,Email,Website,Description,Gender,DOB,Height,Weight,HairColor,EyeColor,BloodType,Occupation,MonthlyIncome,FutureTargets,FutureNeeds,DOD,NIC,Status) 
		VALUES (".
		common::noSqlInject($obj_Person->PersonId).","."'".common::noSqlInject($obj_Person->FullName)."'".","."'".common::noSqlInject($obj_Person->NickName)."'".","."'".common::noSqlInject($obj_Person->OtherNames)."'".","."'".common::noSqlInject($obj_Person->DrivingLicenceNo)."'".","."'".common::noSqlInject($obj_Person->PassportNo)."'".","."'".common::noSqlInject($obj_Person->PermanentAddress)."'".","."'".common::noSqlInject($obj_Person->Email)."'".","."'".common::noSqlInject($obj_Person->Website)."'".","."'".common::noSqlInject($obj_Person->Description)."'".",".common::noSqlInject($obj_Person->Gender).","."'".common::noSqlInject($obj_Person->DOB)."'".",".common::noSqlInject($obj_Person->Height).",".common::noSqlInject($obj_Person->Weight).","."'".common::noSqlInject($obj_Person->HairColor)."'".","."'".common::noSqlInject($obj_Person->EyeColor)."'".","."'".common::noSqlInject($obj_Person->BloodType)."'".","."'".common::noSqlInject($obj_Person->Occupation)."'".",".common::noSqlInject($obj_Person->MonthlyIncome).","."'".common::noSqlInject($obj_Person->FutureTargets)."'".","."'".common::noSqlInject($obj_Person->FutureNeeds)."'".","."'".common::noSqlInject($obj_Person->DOD)."'".","."'".common::noSqlInject($obj_Person->NIC)."'".",".common::noSqlInject($obj_Person->Status).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPersonId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(PersonId) as maxId FROM  tbl_person";
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

    public static function getPersonList()
    {
    	  $db = config::dbconfig();

        $arr_PersonList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person ORDER BY PersonId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person = new Person();
		$obj_Person->PersonId= $row["PersonId"];
		$obj_Person->FullName= $row["FullName"];
		$obj_Person->NickName= $row["NickName"];
		$obj_Person->OtherNames= $row["OtherNames"];
		$obj_Person->DrivingLicenceNo= $row["DrivingLicenceNo"];
		$obj_Person->PassportNo= $row["PassportNo"];
		$obj_Person->PermanentAddress= $row["PermanentAddress"];
		$obj_Person->Email= $row["Email"];
		$obj_Person->Website= $row["Website"];
		$obj_Person->Description= $row["Description"];
		$obj_Person->Gender= $row["Gender"];
		$obj_Person->DOB= $row["DOB"];
		$obj_Person->Height= $row["Height"];
		$obj_Person->Weight= $row["Weight"];
		$obj_Person->HairColor= $row["HairColor"];
		$obj_Person->EyeColor= $row["EyeColor"];
		$obj_Person->BloodType= $row["BloodType"];
		$obj_Person->Occupation= $row["Occupation"];
		$obj_Person->MonthlyIncome= $row["MonthlyIncome"];
		$obj_Person->FutureTargets= $row["FutureTargets"];
		$obj_Person->FutureNeeds= $row["FutureNeeds"];
		$obj_Person->DOD= $row["DOD"];
		$obj_Person->Picture= $row["Picture"];
		$obj_Person->NIC= $row["NIC"];
		$obj_Person->Status= $row["Status"];

        array_push($arr_PersonList, $obj_Person);
        }
		
		if(count($arr_PersonList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_PersonList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPersonByPersonId($PersonId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person = new Person();
		$sql = "SELECT * FROM tbl_person WHERE PersonId=".$PersonId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person->PersonId= $row["PersonId"];
		$obj_Person->FullName= $row["FullName"];
		$obj_Person->NickName= $row["NickName"];
		$obj_Person->OtherNames= $row["OtherNames"];
		$obj_Person->DrivingLicenceNo= $row["DrivingLicenceNo"];
		$obj_Person->PassportNo= $row["PassportNo"];
		$obj_Person->PermanentAddress= $row["PermanentAddress"];
		$obj_Person->Email= $row["Email"];
		$obj_Person->Website= $row["Website"];
		$obj_Person->Description= $row["Description"];
		$obj_Person->Gender= $row["Gender"];
		$obj_Person->DOB= $row["DOB"];
		$obj_Person->Height= $row["Height"];
		$obj_Person->Weight= $row["Weight"];
		$obj_Person->HairColor= $row["HairColor"];
		$obj_Person->EyeColor= $row["EyeColor"];
		$obj_Person->BloodType= $row["BloodType"];
		$obj_Person->Occupation= $row["Occupation"];
		$obj_Person->MonthlyIncome= $row["MonthlyIncome"];
		$obj_Person->FutureTargets= $row["FutureTargets"];
		$obj_Person->FutureNeeds= $row["FutureNeeds"];
		$obj_Person->DOD= $row["DOD"];
		$obj_Person->Picture= $row["Picture"];
		$obj_Person->NIC= $row["NIC"];
		$obj_Person->Status= $row["Status"];

        }
		
		if(count($arr_PersonList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPersonListByPersonId($PersonId)
    {
    		
        $db = config::dbconfig();

        $arr_PersonList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person WHERE PersonId=".$PersonId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person = new Person();
		$obj_Person->PersonId= $row["PersonId"];
		$obj_Person->FullName= $row["FullName"];
		$obj_Person->NickName= $row["NickName"];
		$obj_Person->OtherNames= $row["OtherNames"];
		$obj_Person->DrivingLicenceNo= $row["DrivingLicenceNo"];
		$obj_Person->PassportNo= $row["PassportNo"];
		$obj_Person->PermanentAddress= $row["PermanentAddress"];
		$obj_Person->Email= $row["Email"];
		$obj_Person->Website= $row["Website"];
		$obj_Person->Description= $row["Description"];
		$obj_Person->Gender= $row["Gender"];
		$obj_Person->DOB= $row["DOB"];
		$obj_Person->Height= $row["Height"];
		$obj_Person->Weight= $row["Weight"];
		$obj_Person->HairColor= $row["HairColor"];
		$obj_Person->EyeColor= $row["EyeColor"];
		$obj_Person->BloodType= $row["BloodType"];
		$obj_Person->Occupation= $row["Occupation"];
		$obj_Person->MonthlyIncome= $row["MonthlyIncome"];
		$obj_Person->FutureTargets= $row["FutureTargets"];
		$obj_Person->FutureNeeds= $row["FutureNeeds"];
		$obj_Person->DOD= $row["DOD"];
		$obj_Person->Picture= $row["Picture"];
		$obj_Person->NIC= $row["NIC"];
		$obj_Person->Status= $row["Status"];

        array_push($arr_PersonList, $obj_Person);
        }
		
		if(count($arr_PersonList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_PersonList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function delete($PersonId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person WHERE PersonId=".$PersonId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person SET ". 
	"PersonId=".common::noSqlInject($obj_Person->PersonId).","."FullName="."'".common::noSqlInject($obj_Person->FullName)."'".","."NickName="."'".common::noSqlInject($obj_Person->NickName)."'".","."OtherNames="."'".common::noSqlInject($obj_Person->OtherNames)."'".","."DrivingLicenceNo="."'".common::noSqlInject($obj_Person->DrivingLicenceNo)."'".","."PassportNo="."'".common::noSqlInject($obj_Person->PassportNo)."'".","."PermanentAddress="."'".common::noSqlInject($obj_Person->PermanentAddress)."'".","."Email="."'".common::noSqlInject($obj_Person->Email)."'".","."Website="."'".common::noSqlInject($obj_Person->Website)."'".","."Description="."'".common::noSqlInject($obj_Person->Description)."'".","."Gender=".common::noSqlInject($obj_Person->Gender).","."DOB="."'".common::noSqlInject($obj_Person->DOB)."'".","."Height=".common::noSqlInject($obj_Person->Height).","."Weight=".common::noSqlInject($obj_Person->Weight).","."HairColor="."'".common::noSqlInject($obj_Person->HairColor)."'".","."EyeColor="."'".common::noSqlInject($obj_Person->EyeColor)."'".","."BloodType="."'".common::noSqlInject($obj_Person->BloodType)."'".","."Occupation="."'".common::noSqlInject($obj_Person->Occupation)."'".","."MonthlyIncome=".common::noSqlInject($obj_Person->MonthlyIncome).","."FutureTargets="."'".common::noSqlInject($obj_Person->FutureTargets)."'".","."FutureNeeds="."'".common::noSqlInject($obj_Person->FutureNeeds)."'".","."DOD="."'".common::noSqlInject($obj_Person->DOD)."'".","."Picture="."'".common::noSqlInject($obj_Person->Picture)."'".","."NIC="."'".common::noSqlInject($obj_Person->NIC)."'".","."Status=".common::noSqlInject($obj_Person->Status).	        
	" WHERE  PersonId=".$obj_Person->PersonId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person;
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
	
	public static function disablePerson($PersonId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person SET Status=0 WHERE  PersonId=".$PersonId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person;
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