<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_neartowns
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_neartowns($obj_Village_neartowns)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_neartowns->TownId = DAL_manageVillage_neartowns::getLastVillage_neartownsId()+1;
		
		 $sql = "INSERT INTO tbl_village_neartowns (VillageId,TownId,Distance,Description) 
		VALUES (".
		common::noSqlInject($obj_Village_neartowns->VillageId).",".common::noSqlInject($obj_Village_neartowns->TownId).",".common::noSqlInject($obj_Village_neartowns->Distance).","."'".common::noSqlInject($obj_Village_neartowns->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_neartowns;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_neartownsId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(TownId) as maxId FROM  tbl_village_neartowns";
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

    public static function getVillage_neartownsList()
    {
    	  $db = config::dbconfig();

        $arr_Village_neartownsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_neartowns ORDER BY TownId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_neartowns = new Village_neartowns();
		$obj_Village_neartowns->VillageId= $row["VillageId"];
		$obj_Village_neartowns->TownId= $row["TownId"];
		$obj_Village_neartowns->Distance= $row["Distance"];
		$obj_Village_neartowns->Description= $row["Description"];

        array_push($arr_Village_neartownsList, $obj_Village_neartowns);
        }
		
		if(count($arr_Village_neartownsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_neartownsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_neartownsByTownId($TownId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_neartowns = new Village_neartowns();
		$obj_Village_neartowns->TownId = -1;
		$sql = "SELECT * FROM tbl_village_neartowns WHERE TownId=".$TownId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_neartowns->VillageId= $row["VillageId"];
		$obj_Village_neartowns->TownId= $row["TownId"];
		$obj_Village_neartowns->Distance= $row["Distance"];
		$obj_Village_neartowns->Description= $row["Description"];

        }
		
		if($obj_Village_neartowns->TownId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_neartowns;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_neartownsListByTownId($TownId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_neartownsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_neartowns WHERE TownId=".$TownId." ORDER BY TownId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_neartowns = new Village_neartowns();
		$obj_Village_neartowns->VillageId= $row["VillageId"];
		$obj_Village_neartowns->TownId= $row["TownId"];
		$obj_Village_neartowns->Distance= $row["Distance"];
		$obj_Village_neartowns->Description= $row["Description"];

        array_push($arr_Village_neartownsList, $obj_Village_neartowns);
        }
		
		if(count($arr_Village_neartownsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_neartownsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_neartowns($TownId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_neartowns WHERE TownId=".$TownId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_neartowns)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_neartowns SET ". 
	"VillageId=".common::noSqlInject($obj_Village_neartowns->VillageId).","."TownId=".common::noSqlInject($obj_Village_neartowns->TownId).","."Distance=".common::noSqlInject($obj_Village_neartowns->Distance).","."Description="."'".common::noSqlInject($obj_Village_neartowns->Description)."'".	        
	" WHERE  TownId=".$obj_Village_neartowns->TownId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_neartowns;
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
	
	public static function disableVillage_neartowns($TownId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_neartowns SET Status=0 WHERE  TownId=".$TownId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_neartowns;
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
