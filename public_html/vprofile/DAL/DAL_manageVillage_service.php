<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_service
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_service($obj_Village_service)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_service->BusinessId = DAL_manageVillage_service::getLastVillage_serviceId()+1;
		
		 $sql = "INSERT INTO tbl_village_service (ServiceId,VillageId,BusinessId,Description) 
		VALUES (".
		common::noSqlInject($obj_Village_service->ServiceId).",".common::noSqlInject($obj_Village_service->VillageId).",".common::noSqlInject($obj_Village_service->BusinessId).","."'".common::noSqlInject($obj_Village_service->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_service;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_serviceId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(BusinessId) as maxId FROM  tbl_village_service";
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

    public static function getVillage_serviceList()
    {
    	  $db = config::dbconfig();

        $arr_Village_serviceList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_service ORDER BY BusinessId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_service = new Village_service();
		$obj_Village_service->ServiceId= $row["ServiceId"];
		$obj_Village_service->VillageId= $row["VillageId"];
		$obj_Village_service->BusinessId= $row["BusinessId"];
		$obj_Village_service->Description= $row["Description"];

        array_push($arr_Village_serviceList, $obj_Village_service);
        }
		
		if(count($arr_Village_serviceList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_serviceList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_serviceByBusinessId($BusinessId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_service = new Village_service();
		$obj_Village_service->BusinessId = -1;
		$sql = "SELECT * FROM tbl_village_service WHERE BusinessId=".$BusinessId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_service->ServiceId= $row["ServiceId"];
		$obj_Village_service->VillageId= $row["VillageId"];
		$obj_Village_service->BusinessId= $row["BusinessId"];
		$obj_Village_service->Description= $row["Description"];

        }
		
		if($obj_Village_service->BusinessId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_service;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_serviceListByBusinessId($BusinessId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_serviceList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_service WHERE BusinessId=".$BusinessId." ORDER BY BusinessId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_service = new Village_service();
		$obj_Village_service->ServiceId= $row["ServiceId"];
		$obj_Village_service->VillageId= $row["VillageId"];
		$obj_Village_service->BusinessId= $row["BusinessId"];
		$obj_Village_service->Description= $row["Description"];

        array_push($arr_Village_serviceList, $obj_Village_service);
        }
		
		if(count($arr_Village_serviceList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_serviceList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_service($BusinessId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_service WHERE BusinessId=".$BusinessId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_service)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_service SET ". 
	"ServiceId=".common::noSqlInject($obj_Village_service->ServiceId).","."VillageId=".common::noSqlInject($obj_Village_service->VillageId).","."BusinessId=".common::noSqlInject($obj_Village_service->BusinessId).","."Description="."'".common::noSqlInject($obj_Village_service->Description)."'".	        
	" WHERE  BusinessId=".$obj_Village_service->BusinessId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_service;
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
	
	public static function disableVillage_service($BusinessId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_service SET Status=0 WHERE  BusinessId=".$BusinessId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_service;
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
