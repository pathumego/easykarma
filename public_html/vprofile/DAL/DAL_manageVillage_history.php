<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_history
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_history($obj_Village_history)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_history->TblId = DAL_manageVillage_history::getLastVillage_historyId()+1;
		
		 $sql = "INSERT INTO tbl_village_history (TblId,VillageId,DescriptionType,Description) 
		VALUES (".
		common::noSqlInject($obj_Village_history->TblId).",".common::noSqlInject($obj_Village_history->VillageId).","."'".common::noSqlInject($obj_Village_history->DescriptionType)."'".","."'".common::noSqlInject($obj_Village_history->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_history;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_historyId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(TblId) as maxId FROM  tbl_village_history";
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

    public static function getVillage_historyList()
    {
    	  $db = config::dbconfig();

        $arr_Village_historyList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_history ORDER BY TblId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_history = new Village_history();
		$obj_Village_history->TblId= $row["TblId"];
		$obj_Village_history->VillageId= $row["VillageId"];
		$obj_Village_history->DescriptionType= $row["DescriptionType"];
		$obj_Village_history->Description= $row["Description"];

        array_push($arr_Village_historyList, $obj_Village_history);
        }
		
		if(count($arr_Village_historyList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_historyList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_historyByTblId($TblId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_history = new Village_history();
		$obj_Village_history->TblId = -1;
		$sql = "SELECT * FROM tbl_village_history WHERE TblId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_history->TblId= $row["TblId"];
		$obj_Village_history->VillageId= $row["VillageId"];
		$obj_Village_history->DescriptionType= $row["DescriptionType"];
		$obj_Village_history->Description= $row["Description"];

        }
		
		if($obj_Village_history->TblId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_history;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_historyListByTblId($TblId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_historyList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_history WHERE TblId=".$TblId." ORDER BY TblId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_history = new Village_history();
		$obj_Village_history->TblId= $row["TblId"];
		$obj_Village_history->VillageId= $row["VillageId"];
		$obj_Village_history->DescriptionType= $row["DescriptionType"];
		$obj_Village_history->Description= $row["Description"];

        array_push($arr_Village_historyList, $obj_Village_history);
        }
		
		if(count($arr_Village_historyList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_historyList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_history($TblId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_history WHERE TblId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_history)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_history SET ". 
	"TblId=".common::noSqlInject($obj_Village_history->TblId).","."VillageId=".common::noSqlInject($obj_Village_history->VillageId).","."DescriptionType="."'".common::noSqlInject($obj_Village_history->DescriptionType)."'".","."Description="."'".common::noSqlInject($obj_Village_history->Description)."'".	        
	" WHERE  TblId=".$obj_Village_history->TblId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_history;
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
	
	public static function disableVillage_history($TblId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_history SET Status=0 WHERE  TblId=".$TblId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_history;
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
