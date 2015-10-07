<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageService
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addService($obj_Service)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Service->ServiceId = DAL_manageService::getLastServiceId()+1;
		
		 $sql = "INSERT INTO tbl_service (ServiceId,ServiceName,Description) 
		VALUES (".
		common::noSqlInject($obj_Service->ServiceId).","."'".common::noSqlInject($obj_Service->ServiceName)."'".","."'".common::noSqlInject($obj_Service->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Service;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastServiceId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(ServiceId) as maxId FROM  tbl_service";
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

    public static function getServiceList()
    {
    	  $db = config::dbconfig();

        $arr_ServiceList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_service ORDER BY ServiceId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Service = new Service();
		$obj_Service->ServiceId= $row["ServiceId"];
		$obj_Service->ServiceName= $row["ServiceName"];
		$obj_Service->Description= $row["Description"];

        array_push($arr_ServiceList, $obj_Service);
        }
		
		if(count($arr_ServiceList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_ServiceList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getServiceByServiceId($ServiceId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Service = new Service();
		$obj_Service->ServiceId = -1;
		$sql = "SELECT * FROM tbl_service WHERE ServiceId=".$ServiceId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Service->ServiceId= $row["ServiceId"];
		$obj_Service->ServiceName= $row["ServiceName"];
		$obj_Service->Description= $row["Description"];

        }
		
		if($obj_Service->ServiceId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Service;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getServiceListByServiceId($ServiceId)
    {
    		
        $db = config::dbconfig();

        $arr_ServiceList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_service WHERE ServiceId=".$ServiceId." ORDER BY ServiceId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Service = new Service();
		$obj_Service->ServiceId= $row["ServiceId"];
		$obj_Service->ServiceName= $row["ServiceName"];
		$obj_Service->Description= $row["Description"];

        array_push($arr_ServiceList, $obj_Service);
        }
		
		if(count($arr_ServiceList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_ServiceList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteService($ServiceId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_service WHERE ServiceId=".$ServiceId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Service)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Service SET ". 
	"ServiceId=".common::noSqlInject($obj_Service->ServiceId).","."ServiceName="."'".common::noSqlInject($obj_Service->ServiceName)."'".","."Description="."'".common::noSqlInject($obj_Service->Description)."'".	        
	" WHERE  ServiceId=".$obj_Service->ServiceId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Service;
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
	
	public static function disableService($ServiceId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Service SET Status=0 WHERE  ServiceId=".$ServiceId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Service;
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
