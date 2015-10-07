<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_climate
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_climate($obj_Village_climate)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_climate->ClimateId = DAL_manageVillage_climate::getLastVillage_climateId()+1;
		
		 $sql = "INSERT INTO tbl_village_climate (ClimateId,VillageId,ClimateReagion,RainFall,Temparature,Humidity) 
		VALUES (".
		common::noSqlInject($obj_Village_climate->ClimateId).",".common::noSqlInject($obj_Village_climate->VillageId).","."'".common::noSqlInject($obj_Village_climate->ClimateReagion)."'".",".common::noSqlInject($obj_Village_climate->RainFall).",".common::noSqlInject($obj_Village_climate->Temparature).",".common::noSqlInject($obj_Village_climate->Humidity).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_climate;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_climateId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(ClimateId) as maxId FROM  tbl_village_climate";
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

    public static function getVillage_climateList()
    {
    	  $db = config::dbconfig();

        $arr_Village_climateList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_climate ORDER BY ClimateId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_climate = new Village_climate();
		$obj_Village_climate->ClimateId= $row["ClimateId"];
		$obj_Village_climate->VillageId= $row["VillageId"];
		$obj_Village_climate->ClimateReagion= $row["ClimateReagion"];
		$obj_Village_climate->RainFall= $row["RainFall"];
		$obj_Village_climate->Temparature= $row["Temparature"];
		$obj_Village_climate->Humidity= $row["Humidity"];

        array_push($arr_Village_climateList, $obj_Village_climate);
        }
		
		if(count($arr_Village_climateList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_climateList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_climateByClimateId($ClimateId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_climate = new Village_climate();
		$obj_Village_climate->ClimateId = -1;
		$sql = "SELECT * FROM tbl_village_climate WHERE ClimateId=".$ClimateId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_climate->ClimateId= $row["ClimateId"];
		$obj_Village_climate->VillageId= $row["VillageId"];
		$obj_Village_climate->ClimateReagion= $row["ClimateReagion"];
		$obj_Village_climate->RainFall= $row["RainFall"];
		$obj_Village_climate->Temparature= $row["Temparature"];
		$obj_Village_climate->Humidity= $row["Humidity"];

        }
		
		if($obj_Village_climate->ClimateId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_climate;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_climateListByClimateId($ClimateId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_climateList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_climate WHERE ClimateId=".$ClimateId." ORDER BY ClimateId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_climate = new Village_climate();
		$obj_Village_climate->ClimateId= $row["ClimateId"];
		$obj_Village_climate->VillageId= $row["VillageId"];
		$obj_Village_climate->ClimateReagion= $row["ClimateReagion"];
		$obj_Village_climate->RainFall= $row["RainFall"];
		$obj_Village_climate->Temparature= $row["Temparature"];
		$obj_Village_climate->Humidity= $row["Humidity"];

        array_push($arr_Village_climateList, $obj_Village_climate);
        }
		
		if(count($arr_Village_climateList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_climateList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_climate($ClimateId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_climate WHERE ClimateId=".$ClimateId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_climate)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_climate SET ". 
	"ClimateId=".common::noSqlInject($obj_Village_climate->ClimateId).","."VillageId=".common::noSqlInject($obj_Village_climate->VillageId).","."ClimateReagion="."'".common::noSqlInject($obj_Village_climate->ClimateReagion)."'".","."RainFall=".common::noSqlInject($obj_Village_climate->RainFall).","."Temparature=".common::noSqlInject($obj_Village_climate->Temparature).","."Humidity=".common::noSqlInject($obj_Village_climate->Humidity).	        
	" WHERE  ClimateId=".$obj_Village_climate->ClimateId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_climate;
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
	
	public static function disableVillage_climate($ClimateId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_climate SET Status=0 WHERE  ClimateId=".$ClimateId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_climate;
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
