<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageTalent
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addTalent($obj_Talent)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Talent->TalentId = DAL_manageTalent::getLastTalentId()+1;
		
		 $sql = "INSERT INTO tbl_talent (TalentId,TalentType,TalentField,Description,TalentName) 
		VALUES (".
		common::noSqlInject($obj_Talent->TalentId).",".common::noSqlInject($obj_Talent->TalentType).","."'".common::noSqlInject($obj_Talent->TalentField)."'".","."'".common::noSqlInject($obj_Talent->Description)."'".","."'".common::noSqlInject($obj_Talent->TalentName)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Talent;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastTalentId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(TalentId) as maxId FROM  tbl_talent";
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

    public static function getTalentList()
    {
    	  $db = config::dbconfig();

        $arr_TalentList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_talent ORDER BY TalentId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Talent = new Talent();
		$obj_Talent->TalentId= $row["TalentId"];
		$obj_Talent->TalentType= $row["TalentType"];
		$obj_Talent->TalentField= $row["TalentField"];
		$obj_Talent->Description= $row["Description"];
		$obj_Talent->TalentName= $row["TalentName"];

        array_push($arr_TalentList, $obj_Talent);
        }
		
		if(count($arr_TalentList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_TalentList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTalentByTalentId($TalentId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Talent = new Talent();
		$obj_Talent->TalentId = -1;
		$sql = "SELECT * FROM tbl_talent WHERE TalentId=".$TalentId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Talent->TalentId= $row["TalentId"];
		$obj_Talent->TalentType= $row["TalentType"];
		$obj_Talent->TalentField= $row["TalentField"];
		$obj_Talent->Description= $row["Description"];
		$obj_Talent->TalentName= $row["TalentName"];

        }
		
		if($obj_Talent->TalentId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Talent;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTalentListByTalentId($TalentId)
    {
    		
        $db = config::dbconfig();

        $arr_TalentList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_talent WHERE TalentId=".$TalentId." ORDER BY TalentId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Talent = new Talent();
		$obj_Talent->TalentId= $row["TalentId"];
		$obj_Talent->TalentType= $row["TalentType"];
		$obj_Talent->TalentField= $row["TalentField"];
		$obj_Talent->Description= $row["Description"];
		$obj_Talent->TalentName= $row["TalentName"];

        array_push($arr_TalentList, $obj_Talent);
        }
		
		if(count($arr_TalentList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_TalentList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteTalent($TalentId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_talent WHERE TalentId=".$TalentId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Talent)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Talent SET ". 
	"TalentId=".common::noSqlInject($obj_Talent->TalentId).","."TalentType=".common::noSqlInject($obj_Talent->TalentType).","."TalentField="."'".common::noSqlInject($obj_Talent->TalentField)."'".","."Description="."'".common::noSqlInject($obj_Talent->Description)."'".","."TalentName="."'".common::noSqlInject($obj_Talent->TalentName)."'".	        
	" WHERE  TalentId=".$obj_Talent->TalentId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Talent;
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
	
	public static function disableTalent($TalentId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Talent SET Status=0 WHERE  TalentId=".$TalentId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Talent;
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
