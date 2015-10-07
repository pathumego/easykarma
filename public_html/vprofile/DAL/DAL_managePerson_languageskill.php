<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_languageskill
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_languageskill($obj_Person_languageskill)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_languageskill->LangSkillId = DAL_managePerson_languageskill::getLastPerson_languageskillId()+1;
		
		 $sql = "INSERT INTO tbl_person_languageskill (LangSkillId,PersonId,Language,SkillType,Grade) 
		VALUES (".
		common::noSqlInject($obj_Person_languageskill->LangSkillId).",".common::noSqlInject($obj_Person_languageskill->PersonId).","."'".common::noSqlInject($obj_Person_languageskill->Language)."'".","."'".common::noSqlInject($obj_Person_languageskill->SkillType)."'".","."'".common::noSqlInject($obj_Person_languageskill->Grade)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_languageskill;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_languageskillId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(LangSkillId) as maxId FROM  tbl_person_languageskill";
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

    public static function getPerson_languageskillList()
    {
    	  $db = config::dbconfig();

        $arr_Person_languageskillList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_languageskill ORDER BY LangSkillId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_languageskill = new Person_languageskill();
		$obj_Person_languageskill->LangSkillId= $row["LangSkillId"];
		$obj_Person_languageskill->PersonId= $row["PersonId"];
		$obj_Person_languageskill->Language= $row["Language"];
		$obj_Person_languageskill->SkillType= $row["SkillType"];
		$obj_Person_languageskill->Grade= $row["Grade"];

        array_push($arr_Person_languageskillList, $obj_Person_languageskill);
        }
		
		if(count($arr_Person_languageskillList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_languageskillList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_languageskillByLangSkillId($LangSkillId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_languageskill = new Person_languageskill();
		$obj_Person_languageskill->LangSkillId = -1;
		$sql = "SELECT * FROM tbl_person_languageskill WHERE LangSkillId=".$LangSkillId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_languageskill->LangSkillId= $row["LangSkillId"];
		$obj_Person_languageskill->PersonId= $row["PersonId"];
		$obj_Person_languageskill->Language= $row["Language"];
		$obj_Person_languageskill->SkillType= $row["SkillType"];
		$obj_Person_languageskill->Grade= $row["Grade"];

        }
		
		if($obj_Person_languageskill->LangSkillId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_languageskill;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_languageskillListByLangSkillId($LangSkillId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_languageskillList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_languageskill WHERE LangSkillId=".$LangSkillId." ORDER BY LangSkillId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_languageskill = new Person_languageskill();
		$obj_Person_languageskill->LangSkillId= $row["LangSkillId"];
		$obj_Person_languageskill->PersonId= $row["PersonId"];
		$obj_Person_languageskill->Language= $row["Language"];
		$obj_Person_languageskill->SkillType= $row["SkillType"];
		$obj_Person_languageskill->Grade= $row["Grade"];

        array_push($arr_Person_languageskillList, $obj_Person_languageskill);
        }
		
		if(count($arr_Person_languageskillList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_languageskillList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePerson_languageskill($LangSkillId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_languageskill WHERE LangSkillId=".$LangSkillId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_languageskill)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_languageskill SET ". 
	"LangSkillId=".common::noSqlInject($obj_Person_languageskill->LangSkillId).","."PersonId=".common::noSqlInject($obj_Person_languageskill->PersonId).","."Language="."'".common::noSqlInject($obj_Person_languageskill->Language)."'".","."SkillType="."'".common::noSqlInject($obj_Person_languageskill->SkillType)."'".","."Grade="."'".common::noSqlInject($obj_Person_languageskill->Grade)."'".	        
	" WHERE  LangSkillId=".$obj_Person_languageskill->LangSkillId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_languageskill;
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
	
	public static function disablePerson_languageskill($LangSkillId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_languageskill SET Status=0 WHERE  LangSkillId=".$LangSkillId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_languageskill;
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
