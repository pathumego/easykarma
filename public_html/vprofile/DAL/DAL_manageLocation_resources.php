<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageLocation_resources
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addLocation_resources($obj_Location_resources)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Location_resources->ResourceId = DAL_manageLocation_resources::getLastLocation_resourcesId()+1;
		
		 $sql = "INSERT INTO tbl_location_resources (ResourceId,LocationId,ResourceType,ResourcePath) 
		VALUES (".
		common::noSqlInject($obj_Location_resources->ResourceId).",".common::noSqlInject($obj_Location_resources->LocationId).",".common::noSqlInject($obj_Location_resources->ResourceType).","."'".common::noSqlInject($obj_Location_resources->ResourcePath)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Location_resources;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastLocation_resourcesId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(ResourceId) as maxId FROM  tbl_location_resources";
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

    public static function getLocation_resourcesList()
    {
    	  $db = config::dbconfig();

        $arr_Location_resourcesList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_location_resources ORDER BY ResourceId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Location_resources = new Location_resources();
		$obj_Location_resources->ResourceId= $row["ResourceId"];
		$obj_Location_resources->LocationId= $row["LocationId"];
		$obj_Location_resources->ResourceType= $row["ResourceType"];
		$obj_Location_resources->ResourcePath= $row["ResourcePath"];

        array_push($arr_Location_resourcesList, $obj_Location_resources);
        }
		
		if(count($arr_Location_resourcesList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Location_resourcesList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getLocation_resourcesByResourceId($ResourceId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Location_resources = new Location_resources();
		$obj_Location_resources->ResourceId = -1;
		$sql = "SELECT * FROM tbl_location_resources WHERE ResourceId=".$ResourceId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Location_resources->ResourceId= $row["ResourceId"];
		$obj_Location_resources->LocationId= $row["LocationId"];
		$obj_Location_resources->ResourceType= $row["ResourceType"];
		$obj_Location_resources->ResourcePath= $row["ResourcePath"];

        }
		
		if($obj_Location_resources->ResourceId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Location_resources;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getLocation_resourcesListByResourceId($ResourceId)
    {
    		
        $db = config::dbconfig();

        $arr_Location_resourcesList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_location_resources WHERE ResourceId=".$ResourceId." ORDER BY ResourceId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Location_resources = new Location_resources();
		$obj_Location_resources->ResourceId= $row["ResourceId"];
		$obj_Location_resources->LocationId= $row["LocationId"];
		$obj_Location_resources->ResourceType= $row["ResourceType"];
		$obj_Location_resources->ResourcePath= $row["ResourcePath"];

        array_push($arr_Location_resourcesList, $obj_Location_resources);
        }
		
		if(count($arr_Location_resourcesList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Location_resourcesList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteLocation_resources($ResourceId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_location_resources WHERE ResourceId=".$ResourceId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Location_resources)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Location_resources SET ". 
	"ResourceId=".common::noSqlInject($obj_Location_resources->ResourceId).","."LocationId=".common::noSqlInject($obj_Location_resources->LocationId).","."ResourceType=".common::noSqlInject($obj_Location_resources->ResourceType).","."ResourcePath="."'".common::noSqlInject($obj_Location_resources->ResourcePath)."'".	        
	" WHERE  ResourceId=".$obj_Location_resources->ResourceId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Location_resources;
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
	
	public static function disableLocation_resources($ResourceId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Location_resources SET Status=0 WHERE  ResourceId=".$ResourceId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Location_resources;
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
