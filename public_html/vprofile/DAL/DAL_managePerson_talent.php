<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_talent
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_talent($obj_Person_talent)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_talent->TblId = DAL_managePerson_talent::getLastPerson_talentId()+1;
		
		 $sql = "INSERT INTO tbl_person_talent (TblId,PersonId,TalentId) 
		VALUES (".
		common::noSqlInject($obj_Person_talent->TblId).",".common::noSqlInject($obj_Person_talent->PersonId).",".common::noSqlInject($obj_Person_talent->TalentId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_talent;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_talentId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(TblId) as maxId FROM  tbl_person_talent";
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

    public static function getPerson_talentList()
    {
    	  $db = config::dbconfig();

        $arr_Person_talentList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_talent ORDER BY TblId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_talent = new Person_talent();
		$obj_Person_talent->TblId= $row["TblId"];
		$obj_Person_talent->PersonId= $row["PersonId"];
		$obj_Person_talent->TalentId= $row["TalentId"];

        array_push($arr_Person_talentList, $obj_Person_talent);
        }
		
		if(count($arr_Person_talentList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_talentList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_talentByTblId($TblId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_talent = new Person_talent();
		$obj_Person_talent->TblId = -1;
		$sql = "SELECT * FROM tbl_person_talent WHERE TblId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_talent->TblId= $row["TblId"];
		$obj_Person_talent->PersonId= $row["PersonId"];
		$obj_Person_talent->TalentId= $row["TalentId"];

        }
		
		if($obj_Person_talent->TblId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_talent;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_talentListByTblId($TblId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_talentList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_talent WHERE TblId=".$TblId." ORDER BY TblId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_talent = new Person_talent();
		$obj_Person_talent->TblId= $row["TblId"];
		$obj_Person_talent->PersonId= $row["PersonId"];
		$obj_Person_talent->TalentId= $row["TalentId"];

        array_push($arr_Person_talentList, $obj_Person_talent);
        }
		
		if(count($arr_Person_talentList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_talentList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePerson_talent($TblId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_talent WHERE TblId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_talent)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_talent SET ". 
	"TblId=".common::noSqlInject($obj_Person_talent->TblId).","."PersonId=".common::noSqlInject($obj_Person_talent->PersonId).","."TalentId=".common::noSqlInject($obj_Person_talent->TalentId).	        
	" WHERE  TblId=".$obj_Person_talent->TblId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_talent;
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
	
	public static function disablePerson_talent($TblId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_talent SET Status=0 WHERE  TblId=".$TblId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_talent;
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
