<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_telephone
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_telephone($obj_Person_telephone)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_telephone->PhoneId = DAL_managePerson_telephone::getLastPerson_telephoneId()+1;
		
		 $sql = "INSERT INTO tbl_person_telephone (PhoneId,PhoneNumber,Type,PersonId) 
		VALUES (".
		common::noSqlInject($obj_Person_telephone->PhoneId).","."'".common::noSqlInject($obj_Person_telephone->PhoneNumber)."'".",".common::noSqlInject($obj_Person_telephone->Type).",".common::noSqlInject($obj_Person_telephone->PersonId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_telephone;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_telephoneId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(PhoneId) as maxId FROM  tbl_person_telephone";
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

    public static function getPerson_telephoneList()
    {
    	  $db = config::dbconfig();

        $arr_Person_telephoneList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_telephone ORDER BY PhoneId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_telephone = new Person_telephone();
		$obj_Person_telephone->PhoneId= $row["PhoneId"];
		$obj_Person_telephone->PhoneNumber= $row["PhoneNumber"];
		$obj_Person_telephone->Type= $row["Type"];
		$obj_Person_telephone->PersonId= $row["PersonId"];

        array_push($arr_Person_telephoneList, $obj_Person_telephone);
        }
		
		if(count($arr_Person_telephoneList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_telephoneList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_telephoneByPhoneId($PhoneId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_telephone = new Person_telephone();
		$obj_Person_telephone->PhoneId = -1;
		$sql = "SELECT * FROM tbl_person_telephone WHERE PhoneId=".$PhoneId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_telephone->PhoneId= $row["PhoneId"];
		$obj_Person_telephone->PhoneNumber= $row["PhoneNumber"];
		$obj_Person_telephone->Type= $row["Type"];
		$obj_Person_telephone->PersonId= $row["PersonId"];

        }
		
		if($obj_Person_telephone->PhoneId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_telephone;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_telephoneListByPhoneId($PhoneId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_telephoneList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_telephone WHERE PhoneId=".$PhoneId." ORDER BY PhoneId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_telephone = new Person_telephone();
		$obj_Person_telephone->PhoneId= $row["PhoneId"];
		$obj_Person_telephone->PhoneNumber= $row["PhoneNumber"];
		$obj_Person_telephone->Type= $row["Type"];
		$obj_Person_telephone->PersonId= $row["PersonId"];

        array_push($arr_Person_telephoneList, $obj_Person_telephone);
        }
		
		if(count($arr_Person_telephoneList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_telephoneList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePerson_telephone($PhoneId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_telephone WHERE PhoneId=".$PhoneId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_telephone)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_telephone SET ". 
	"PhoneId=".common::noSqlInject($obj_Person_telephone->PhoneId).","."PhoneNumber="."'".common::noSqlInject($obj_Person_telephone->PhoneNumber)."'".","."Type=".common::noSqlInject($obj_Person_telephone->Type).","."PersonId=".common::noSqlInject($obj_Person_telephone->PersonId).	        
	" WHERE  PhoneId=".$obj_Person_telephone->PhoneId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_telephone;
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
	
	public static function disablePerson_telephone($PhoneId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_telephone SET Status=0 WHERE  PhoneId=".$PhoneId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_telephone;
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
