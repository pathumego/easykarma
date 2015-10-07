<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageTrading
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addTrading($obj_Trading)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Trading->tradingId = DAL_manageTrading::getLastTradingId()+1;
		
		 $sql = "INSERT INTO tbl_trading (tradingId,tradingName,tradingType,Description) 
		VALUES (".
		common::noSqlInject($obj_Trading->tradingId).","."'".common::noSqlInject($obj_Trading->tradingName)."'".","."'".common::noSqlInject($obj_Trading->tradingType)."'".","."'".common::noSqlInject($obj_Trading->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Trading;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastTradingId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(tradingId) as maxId FROM  tbl_trading";
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

    public static function getTradingList()
    {
    	  $db = config::dbconfig();

        $arr_TradingList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_trading ORDER BY tradingId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Trading = new Trading();
		$obj_Trading->tradingId= $row["tradingId"];
		$obj_Trading->tradingName= $row["tradingName"];
		$obj_Trading->tradingType= $row["tradingType"];
		$obj_Trading->Description= $row["Description"];

        array_push($arr_TradingList, $obj_Trading);
        }
		
		if(count($arr_TradingList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_TradingList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTradingBytradingId($tradingId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Trading = new Trading();
		$obj_Trading->tradingId = -1;
		$sql = "SELECT * FROM tbl_trading WHERE tradingId=".$tradingId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Trading->tradingId= $row["tradingId"];
		$obj_Trading->tradingName= $row["tradingName"];
		$obj_Trading->tradingType= $row["tradingType"];
		$obj_Trading->Description= $row["Description"];

        }
		
		if($obj_Trading->tradingId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Trading;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTradingListBytradingId($tradingId)
    {
    		
        $db = config::dbconfig();

        $arr_TradingList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_trading WHERE tradingId=".$tradingId." ORDER BY tradingId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Trading = new Trading();
		$obj_Trading->tradingId= $row["tradingId"];
		$obj_Trading->tradingName= $row["tradingName"];
		$obj_Trading->tradingType= $row["tradingType"];
		$obj_Trading->Description= $row["Description"];

        array_push($arr_TradingList, $obj_Trading);
        }
		
		if(count($arr_TradingList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_TradingList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteTrading($tradingId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_trading WHERE tradingId=".$tradingId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Trading)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Trading SET ". 
	"tradingId=".common::noSqlInject($obj_Trading->tradingId).","."tradingName="."'".common::noSqlInject($obj_Trading->tradingName)."'".","."tradingType="."'".common::noSqlInject($obj_Trading->tradingType)."'".","."Description="."'".common::noSqlInject($obj_Trading->Description)."'".	        
	" WHERE  tradingId=".$obj_Trading->tradingId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Trading;
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
	
	public static function disableTrading($tradingId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Trading SET Status=0 WHERE  tradingId=".$tradingId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Trading;
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
