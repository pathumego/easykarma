<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_industrial
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_industrial($obj_Village_industrial)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_industrial->BusinessId = DAL_manageVillage_industrial::getLastVillage_industrialId()+1;
		
		 $sql = "INSERT INTO tbl_village_industrial (IndustrialId,VillageId,BusinessId,Description) 
		VALUES (".
		common::noSqlInject($obj_Village_industrial->IndustrialId).",".common::noSqlInject($obj_Village_industrial->VillageId).",".common::noSqlInject($obj_Village_industrial->BusinessId).","."'".common::noSqlInject($obj_Village_industrial->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_industrial;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_industrialId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(BusinessId) as maxId FROM  tbl_village_industrial";
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

    public static function getVillage_industrialList()
    {
    	  $db = config::dbconfig();

        $arr_Village_industrialList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_industrial ORDER BY BusinessId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_industrial = new Village_industrial();
		$obj_Village_industrial->IndustrialId= $row["IndustrialId"];
		$obj_Village_industrial->VillageId= $row["VillageId"];
		$obj_Village_industrial->BusinessId= $row["BusinessId"];
		$obj_Village_industrial->Description= $row["Description"];

        array_push($arr_Village_industrialList, $obj_Village_industrial);
        }
		
		if(count($arr_Village_industrialList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_industrialList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_industrialByBusinessId($BusinessId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_industrial = new Village_industrial();
		$obj_Village_industrial->BusinessId = -1;
		$sql = "SELECT * FROM tbl_village_industrial WHERE BusinessId=".$BusinessId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_industrial->IndustrialId= $row["IndustrialId"];
		$obj_Village_industrial->VillageId= $row["VillageId"];
		$obj_Village_industrial->BusinessId= $row["BusinessId"];
		$obj_Village_industrial->Description= $row["Description"];

        }
		
		if($obj_Village_industrial->BusinessId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_industrial;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_industrialListByBusinessId($BusinessId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_industrialList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_industrial WHERE BusinessId=".$BusinessId." ORDER BY BusinessId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_industrial = new Village_industrial();
		$obj_Village_industrial->IndustrialId= $row["IndustrialId"];
		$obj_Village_industrial->VillageId= $row["VillageId"];
		$obj_Village_industrial->BusinessId= $row["BusinessId"];
		$obj_Village_industrial->Description= $row["Description"];

        array_push($arr_Village_industrialList, $obj_Village_industrial);
        }
		
		if(count($arr_Village_industrialList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_industrialList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_industrial($BusinessId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_industrial WHERE BusinessId=".$BusinessId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_industrial)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_industrial SET ". 
	"IndustrialId=".common::noSqlInject($obj_Village_industrial->IndustrialId).","."VillageId=".common::noSqlInject($obj_Village_industrial->VillageId).","."BusinessId=".common::noSqlInject($obj_Village_industrial->BusinessId).","."Description="."'".common::noSqlInject($obj_Village_industrial->Description)."'".	        
	" WHERE  BusinessId=".$obj_Village_industrial->BusinessId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_industrial;
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
	
	public static function disableVillage_industrial($BusinessId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_industrial SET Status=0 WHERE  BusinessId=".$BusinessId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_industrial;
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
