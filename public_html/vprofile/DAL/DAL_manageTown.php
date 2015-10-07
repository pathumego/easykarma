<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageTown
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addTown($obj_Town)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Town->TownId = DAL_manageTown::getLastTownId()+1;
		
		 $sql = "INSERT INTO tbl_town (TownId,TownName,Description) 
		VALUES (".
		common::noSqlInject($obj_Town->TownId).","."'".common::noSqlInject($obj_Town->TownName)."'".","."'".common::noSqlInject($obj_Town->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Town;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastTownId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(TownId) as maxId FROM  tbl_town";
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

    public static function getTownList()
    {
    	  $db = config::dbconfig();

        $arr_TownList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_town ORDER BY TownId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Town = new Town();
		$obj_Town->TownId= $row["TownId"];
		$obj_Town->TownName= $row["TownName"];
		$obj_Town->Description= $row["Description"];

        array_push($arr_TownList, $obj_Town);
        }
		
		if(count($arr_TownList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_TownList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTownByTownId($TownId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Town = new Town();
		$obj_Town->TownId = -1;
		$sql = "SELECT * FROM tbl_town WHERE TownId=".$TownId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Town->TownId= $row["TownId"];
		$obj_Town->TownName= $row["TownName"];
		$obj_Town->Description= $row["Description"];

        }
		
		if($obj_Town->TownId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Town;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTownListByTownId($TownId)
    {
    		
        $db = config::dbconfig();

        $arr_TownList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_town WHERE TownId=".$TownId." ORDER BY TownId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Town = new Town();
		$obj_Town->TownId= $row["TownId"];
		$obj_Town->TownName= $row["TownName"];
		$obj_Town->Description= $row["Description"];

        array_push($arr_TownList, $obj_Town);
        }
		
		if(count($arr_TownList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_TownList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteTown($TownId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_town WHERE TownId=".$TownId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Town)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Town SET ". 
	"TownId=".common::noSqlInject($obj_Town->TownId).","."TownName="."'".common::noSqlInject($obj_Town->TownName)."'".","."Description="."'".common::noSqlInject($obj_Town->Description)."'".	        
	" WHERE  TownId=".$obj_Town->TownId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Town;
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
	
	public static function disableTown($TownId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Town SET Status=0 WHERE  TownId=".$TownId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Town;
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
