<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_transport
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_transport($obj_Village_transport)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_transport->VillageId = DAL_manageVillage_transport::getLastVillage_transportId()+1;
		
		 $sql = "INSERT INTO tbl_village_transport (TransportId,VillageId,Description) 
		VALUES (".
		common::noSqlInject($obj_Village_transport->TransportId).",".common::noSqlInject($obj_Village_transport->VillageId).","."'".common::noSqlInject($obj_Village_transport->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_transport;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_transportId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(VillageId) as maxId FROM  tbl_village_transport";
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

    public static function getVillage_transportList()
    {
    	  $db = config::dbconfig();

        $arr_Village_transportList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_transport ORDER BY VillageId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_transport = new Village_transport();
		$obj_Village_transport->TransportId= $row["TransportId"];
		$obj_Village_transport->VillageId= $row["VillageId"];
		$obj_Village_transport->Description= $row["Description"];

        array_push($arr_Village_transportList, $obj_Village_transport);
        }
		
		if(count($arr_Village_transportList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_transportList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_transportByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_transport = new Village_transport();
		$obj_Village_transport->VillageId = -1;
		$sql = "SELECT * FROM tbl_village_transport WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_transport->TransportId= $row["TransportId"];
		$obj_Village_transport->VillageId= $row["VillageId"];
		$obj_Village_transport->Description= $row["Description"];

        }
		
		if($obj_Village_transport->VillageId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_transport;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_transportListByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_transportList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_transport WHERE VillageId=".$VillageId." ORDER BY VillageId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_transport = new Village_transport();
		$obj_Village_transport->TransportId= $row["TransportId"];
		$obj_Village_transport->VillageId= $row["VillageId"];
		$obj_Village_transport->Description= $row["Description"];

        array_push($arr_Village_transportList, $obj_Village_transport);
        }
		
		if(count($arr_Village_transportList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_transportList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_transport($VillageId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_transport WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_transport)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_transport SET ". 
	"TransportId=".common::noSqlInject($obj_Village_transport->TransportId).","."VillageId=".common::noSqlInject($obj_Village_transport->VillageId).","."Description="."'".common::noSqlInject($obj_Village_transport->Description)."'".	        
	" WHERE  VillageId=".$obj_Village_transport->VillageId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_transport;
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
	
	public static function disableVillage_transport($VillageId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_transport SET Status=0 WHERE  VillageId=".$VillageId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_transport;
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
