<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_plant
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_plant($obj_Village_plant)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_plant->VillageId = DAL_manageVillage_plant::getLastVillage_plantId()+1;
		
		 $sql = "INSERT INTO tbl_village_plant (PlantId,VillageId) 
		VALUES (".
		common::noSqlInject($obj_Village_plant->PlantId).",".common::noSqlInject($obj_Village_plant->VillageId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_plant;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_plantId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(VillageId) as maxId FROM  tbl_village_plant";
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

    public static function getVillage_plantList()
    {
    	  $db = config::dbconfig();

        $arr_Village_plantList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_plant ORDER BY VillageId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_plant = new Village_plant();
		$obj_Village_plant->PlantId= $row["PlantId"];
		$obj_Village_plant->VillageId= $row["VillageId"];

        array_push($arr_Village_plantList, $obj_Village_plant);
        }
		
		if(count($arr_Village_plantList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_plantList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_plantByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_plant = new Village_plant();
		$obj_Village_plant->VillageId = -1;
		$sql = "SELECT * FROM tbl_village_plant WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_plant->PlantId= $row["PlantId"];
		$obj_Village_plant->VillageId= $row["VillageId"];

        }
		
		if($obj_Village_plant->VillageId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_plant;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_plantListByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_plantList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_plant WHERE VillageId=".$VillageId." ORDER BY VillageId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_plant = new Village_plant();
		$obj_Village_plant->PlantId= $row["PlantId"];
		$obj_Village_plant->VillageId= $row["VillageId"];

        array_push($arr_Village_plantList, $obj_Village_plant);
        }
		
		if(count($arr_Village_plantList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_plantList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_plant($VillageId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_plant WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_plant)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_plant SET ". 
	"PlantId=".common::noSqlInject($obj_Village_plant->PlantId).","."VillageId=".common::noSqlInject($obj_Village_plant->VillageId).	        
	" WHERE  VillageId=".$obj_Village_plant->VillageId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_plant;
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
	
	public static function disableVillage_plant($VillageId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_plant SET Status=0 WHERE  VillageId=".$VillageId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_plant;
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
