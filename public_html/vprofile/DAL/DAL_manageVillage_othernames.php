<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_othernames
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_othernames($obj_Village_othernames)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_othernames->VillageId = DAL_manageVillage_othernames::getLastVillage_othernamesId()+1;
		
		 $sql = "INSERT INTO tbl_village_othernames (VillageId,VillageNames) 
		VALUES (".
		common::noSqlInject($obj_Village_othernames->VillageId).","."'".common::noSqlInject($obj_Village_othernames->VillageNames)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_othernames;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_othernamesId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(VillageId) as maxId FROM  tbl_village_othernames";
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

    public static function getVillage_othernamesList()
    {
    	  $db = config::dbconfig();

        $arr_Village_othernamesList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_othernames ORDER BY VillageId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_othernames = new Village_othernames();
		$obj_Village_othernames->VillageId= $row["VillageId"];
		$obj_Village_othernames->VillageNames= $row["VillageNames"];

        array_push($arr_Village_othernamesList, $obj_Village_othernames);
        }
		
		if(count($arr_Village_othernamesList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_othernamesList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_othernamesByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_othernames = new Village_othernames();
		$obj_Village_othernames->VillageId = -1;
		$sql = "SELECT * FROM tbl_village_othernames WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_othernames->VillageId= $row["VillageId"];
		$obj_Village_othernames->VillageNames= $row["VillageNames"];

        }
		
		if($obj_Village_othernames->VillageId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_othernames;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_othernamesListByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_othernamesList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_othernames WHERE VillageId=".$VillageId." ORDER BY VillageId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_othernames = new Village_othernames();
		$obj_Village_othernames->VillageId= $row["VillageId"];
		$obj_Village_othernames->VillageNames= $row["VillageNames"];

        array_push($arr_Village_othernamesList, $obj_Village_othernames);
        }
		
		if(count($arr_Village_othernamesList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_othernamesList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_othernames($VillageId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_othernames WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_othernames)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_othernames SET ". 
	"VillageId=".common::noSqlInject($obj_Village_othernames->VillageId).","."VillageNames="."'".common::noSqlInject($obj_Village_othernames->VillageNames)."'".	        
	" WHERE  VillageId=".$obj_Village_othernames->VillageId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_othernames;
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
	
	public static function disableVillage_othernames($VillageId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_othernames SET Status=0 WHERE  VillageId=".$VillageId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_othernames;
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
