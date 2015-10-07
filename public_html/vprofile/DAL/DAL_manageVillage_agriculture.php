<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_agriculture
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_agriculture($obj_Village_agriculture)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_agriculture->BusinessId = DAL_manageVillage_agriculture::getLastVillage_agricultureId()+1;
		
		 $sql = "INSERT INTO tbl_village_agriculture (AgricultureId,VillageId,BusinessId,Description) 
		VALUES (".
		common::noSqlInject($obj_Village_agriculture->AgricultureId).",".common::noSqlInject($obj_Village_agriculture->VillageId).",".common::noSqlInject($obj_Village_agriculture->BusinessId).","."'".common::noSqlInject($obj_Village_agriculture->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_agriculture;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_agricultureId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(BusinessId) as maxId FROM  tbl_village_agriculture";
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

    public static function getVillage_agricultureList()
    {
    	  $db = config::dbconfig();

        $arr_Village_agricultureList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_agriculture ORDER BY BusinessId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_agriculture = new Village_agriculture();
		$obj_Village_agriculture->AgricultureId= $row["AgricultureId"];
		$obj_Village_agriculture->VillageId= $row["VillageId"];
		$obj_Village_agriculture->BusinessId= $row["BusinessId"];
		$obj_Village_agriculture->Description= $row["Description"];

        array_push($arr_Village_agricultureList, $obj_Village_agriculture);
        }
		
		if(count($arr_Village_agricultureList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_agricultureList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_agricultureByBusinessId($BusinessId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_agriculture = new Village_agriculture();
		$obj_Village_agriculture->BusinessId = -1;
		$sql = "SELECT * FROM tbl_village_agriculture WHERE BusinessId=".$BusinessId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_agriculture->AgricultureId= $row["AgricultureId"];
		$obj_Village_agriculture->VillageId= $row["VillageId"];
		$obj_Village_agriculture->BusinessId= $row["BusinessId"];
		$obj_Village_agriculture->Description= $row["Description"];

        }
		
		if($obj_Village_agriculture->BusinessId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_agriculture;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_agricultureListByBusinessId($BusinessId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_agricultureList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_agriculture WHERE BusinessId=".$BusinessId." ORDER BY BusinessId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_agriculture = new Village_agriculture();
		$obj_Village_agriculture->AgricultureId= $row["AgricultureId"];
		$obj_Village_agriculture->VillageId= $row["VillageId"];
		$obj_Village_agriculture->BusinessId= $row["BusinessId"];
		$obj_Village_agriculture->Description= $row["Description"];

        array_push($arr_Village_agricultureList, $obj_Village_agriculture);
        }
		
		if(count($arr_Village_agricultureList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_agricultureList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_agriculture($BusinessId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_agriculture WHERE BusinessId=".$BusinessId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_agriculture)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_agriculture SET ". 
	"AgricultureId=".common::noSqlInject($obj_Village_agriculture->AgricultureId).","."VillageId=".common::noSqlInject($obj_Village_agriculture->VillageId).","."BusinessId=".common::noSqlInject($obj_Village_agriculture->BusinessId).","."Description="."'".common::noSqlInject($obj_Village_agriculture->Description)."'".	        
	" WHERE  BusinessId=".$obj_Village_agriculture->BusinessId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_agriculture;
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
	
	public static function disableVillage_agriculture($BusinessId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_agriculture SET Status=0 WHERE  BusinessId=".$BusinessId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_agriculture;
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
