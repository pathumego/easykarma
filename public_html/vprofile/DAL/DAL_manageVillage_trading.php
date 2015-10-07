<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_trading
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_trading($obj_Village_trading)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_trading->BusinessId = DAL_manageVillage_trading::getLastVillage_tradingId()+1;
		
		 $sql = "INSERT INTO tbl_village_trading (TradingId,VillageId,BusinessId,Description) 
		VALUES (".
		common::noSqlInject($obj_Village_trading->TradingId).",".common::noSqlInject($obj_Village_trading->VillageId).",".common::noSqlInject($obj_Village_trading->BusinessId).","."'".common::noSqlInject($obj_Village_trading->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_trading;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_tradingId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(BusinessId) as maxId FROM  tbl_village_trading";
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

    public static function getVillage_tradingList()
    {
    	  $db = config::dbconfig();

        $arr_Village_tradingList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_trading ORDER BY BusinessId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_trading = new Village_trading();
		$obj_Village_trading->TradingId= $row["TradingId"];
		$obj_Village_trading->VillageId= $row["VillageId"];
		$obj_Village_trading->BusinessId= $row["BusinessId"];
		$obj_Village_trading->Description= $row["Description"];

        array_push($arr_Village_tradingList, $obj_Village_trading);
        }
		
		if(count($arr_Village_tradingList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_tradingList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_tradingByBusinessId($BusinessId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_trading = new Village_trading();
		$obj_Village_trading->BusinessId = -1;
		$sql = "SELECT * FROM tbl_village_trading WHERE BusinessId=".$BusinessId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_trading->TradingId= $row["TradingId"];
		$obj_Village_trading->VillageId= $row["VillageId"];
		$obj_Village_trading->BusinessId= $row["BusinessId"];
		$obj_Village_trading->Description= $row["Description"];

        }
		
		if($obj_Village_trading->BusinessId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_trading;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_tradingListByBusinessId($BusinessId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_tradingList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_trading WHERE BusinessId=".$BusinessId." ORDER BY BusinessId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_trading = new Village_trading();
		$obj_Village_trading->TradingId= $row["TradingId"];
		$obj_Village_trading->VillageId= $row["VillageId"];
		$obj_Village_trading->BusinessId= $row["BusinessId"];
		$obj_Village_trading->Description= $row["Description"];

        array_push($arr_Village_tradingList, $obj_Village_trading);
        }
		
		if(count($arr_Village_tradingList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_tradingList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_trading($BusinessId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_trading WHERE BusinessId=".$BusinessId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_trading)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_trading SET ". 
	"TradingId=".common::noSqlInject($obj_Village_trading->TradingId).","."VillageId=".common::noSqlInject($obj_Village_trading->VillageId).","."BusinessId=".common::noSqlInject($obj_Village_trading->BusinessId).","."Description="."'".common::noSqlInject($obj_Village_trading->Description)."'".	        
	" WHERE  BusinessId=".$obj_Village_trading->BusinessId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_trading;
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
	
	public static function disableVillage_trading($BusinessId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_trading SET Status=0 WHERE  BusinessId=".$BusinessId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_trading;
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
