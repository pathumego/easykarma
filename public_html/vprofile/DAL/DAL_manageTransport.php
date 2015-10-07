<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageTransport
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addTransport($obj_Transport)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Transport->TransportId = DAL_manageTransport::getLastTransportId()+1;
		
		 $sql = "INSERT INTO tbl_transport (TransportId,TransportName,TransportType,Description) 
		VALUES (".
		common::noSqlInject($obj_Transport->TransportId).","."'".common::noSqlInject($obj_Transport->TransportName)."'".","."'".common::noSqlInject($obj_Transport->TransportType)."'".","."'".common::noSqlInject($obj_Transport->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Transport;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastTransportId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(TransportId) as maxId FROM  tbl_transport";
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

    public static function getTransportList()
    {
    	  $db = config::dbconfig();

        $arr_TransportList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_transport ORDER BY TransportId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Transport = new Transport();
		$obj_Transport->TransportId= $row["TransportId"];
		$obj_Transport->TransportName= $row["TransportName"];
		$obj_Transport->TransportType= $row["TransportType"];
		$obj_Transport->Description= $row["Description"];

        array_push($arr_TransportList, $obj_Transport);
        }
		
		if(count($arr_TransportList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_TransportList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTransportByTransportId($TransportId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Transport = new Transport();
		$obj_Transport->TransportId = -1;
		$sql = "SELECT * FROM tbl_transport WHERE TransportId=".$TransportId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Transport->TransportId= $row["TransportId"];
		$obj_Transport->TransportName= $row["TransportName"];
		$obj_Transport->TransportType= $row["TransportType"];
		$obj_Transport->Description= $row["Description"];

        }
		
		if($obj_Transport->TransportId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Transport;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTransportListByTransportId($TransportId)
    {
    		
        $db = config::dbconfig();

        $arr_TransportList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_transport WHERE TransportId=".$TransportId." ORDER BY TransportId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Transport = new Transport();
		$obj_Transport->TransportId= $row["TransportId"];
		$obj_Transport->TransportName= $row["TransportName"];
		$obj_Transport->TransportType= $row["TransportType"];
		$obj_Transport->Description= $row["Description"];

        array_push($arr_TransportList, $obj_Transport);
        }
		
		if(count($arr_TransportList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_TransportList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteTransport($TransportId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_transport WHERE TransportId=".$TransportId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Transport)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Transport SET ". 
	"TransportId=".common::noSqlInject($obj_Transport->TransportId).","."TransportName="."'".common::noSqlInject($obj_Transport->TransportName)."'".","."TransportType="."'".common::noSqlInject($obj_Transport->TransportType)."'".","."Description="."'".common::noSqlInject($obj_Transport->Description)."'".	        
	" WHERE  TransportId=".$obj_Transport->TransportId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Transport;
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
	
	public static function disableTransport($TransportId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Transport SET Status=0 WHERE  TransportId=".$TransportId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Transport;
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
