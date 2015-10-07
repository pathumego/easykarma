<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageLocation
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addLocation($obj_Location)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Location->LocationId = DAL_manageLocation::getLastLocationId()+1;
		
		 $sql = "INSERT INTO tbl_location (LocationId,Name,LocationType,Description) 
		VALUES (".
		common::noSqlInject($obj_Location->LocationId).","."'".common::noSqlInject($obj_Location->Name)."'".","."'".common::noSqlInject($obj_Location->LocationType)."'".","."'".common::noSqlInject($obj_Location->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Location;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastLocationId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(LocationId) as maxId FROM  tbl_location";
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

    public static function getLocationList()
    {
    	  $db = config::dbconfig();

        $arr_LocationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_location ORDER BY LocationId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Location = new Location();
		$obj_Location->LocationId= $row["LocationId"];
		$obj_Location->Name= $row["Name"];
		$obj_Location->LocationType= $row["LocationType"];
		$obj_Location->Description= $row["Description"];

        array_push($arr_LocationList, $obj_Location);
        }
		
		if(count($arr_LocationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_LocationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getLocationByLocationId($LocationId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Location = new Location();
		$obj_Location->LocationId = -1;
		$sql = "SELECT * FROM tbl_location WHERE LocationId=".$LocationId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Location->LocationId= $row["LocationId"];
		$obj_Location->Name= $row["Name"];
		$obj_Location->LocationType= $row["LocationType"];
		$obj_Location->Description= $row["Description"];

        }
		
		if($obj_Location->LocationId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Location;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getLocationListByLocationId($LocationId)
    {
    		
        $db = config::dbconfig();

        $arr_LocationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_location WHERE LocationId=".$LocationId." ORDER BY LocationId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Location = new Location();
		$obj_Location->LocationId= $row["LocationId"];
		$obj_Location->Name= $row["Name"];
		$obj_Location->LocationType= $row["LocationType"];
		$obj_Location->Description= $row["Description"];

        array_push($arr_LocationList, $obj_Location);
        }
		
		if(count($arr_LocationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_LocationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteLocation($LocationId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_location WHERE LocationId=".$LocationId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Location)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Location SET ". 
	"LocationId=".common::noSqlInject($obj_Location->LocationId).","."Name="."'".common::noSqlInject($obj_Location->Name)."'".","."LocationType="."'".common::noSqlInject($obj_Location->LocationType)."'".","."Description="."'".common::noSqlInject($obj_Location->Description)."'".	        
	" WHERE  LocationId=".$obj_Location->LocationId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Location;
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
	
	public static function disableLocation($LocationId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Location SET Status=0 WHERE  LocationId=".$LocationId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Location;
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
