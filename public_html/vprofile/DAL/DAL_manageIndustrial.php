<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageIndustrial
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addIndustrial($obj_Industrial)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Industrial->IndustrialId = DAL_manageIndustrial::getLastIndustrialId()+1;
		
		 $sql = "INSERT INTO tbl_industrial (IndustrialId,IndustrialName,Description) 
		VALUES (".
		common::noSqlInject($obj_Industrial->IndustrialId).","."'".common::noSqlInject($obj_Industrial->IndustrialName)."'".","."'".common::noSqlInject($obj_Industrial->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Industrial;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastIndustrialId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(IndustrialId) as maxId FROM  tbl_industrial";
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

    public static function getIndustrialList()
    {
    	  $db = config::dbconfig();

        $arr_IndustrialList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_industrial ORDER BY IndustrialId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Industrial = new Industrial();
		$obj_Industrial->IndustrialId= $row["IndustrialId"];
		$obj_Industrial->IndustrialName= $row["IndustrialName"];
		$obj_Industrial->Description= $row["Description"];

        array_push($arr_IndustrialList, $obj_Industrial);
        }
		
		if(count($arr_IndustrialList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_IndustrialList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getIndustrialByIndustrialId($IndustrialId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Industrial = new Industrial();
		$obj_Industrial->IndustrialId = -1;
		$sql = "SELECT * FROM tbl_industrial WHERE IndustrialId=".$IndustrialId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Industrial->IndustrialId= $row["IndustrialId"];
		$obj_Industrial->IndustrialName= $row["IndustrialName"];
		$obj_Industrial->Description= $row["Description"];

        }
		
		if($obj_Industrial->IndustrialId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Industrial;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getIndustrialListByIndustrialId($IndustrialId)
    {
    		
        $db = config::dbconfig();

        $arr_IndustrialList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_industrial WHERE IndustrialId=".$IndustrialId." ORDER BY IndustrialId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Industrial = new Industrial();
		$obj_Industrial->IndustrialId= $row["IndustrialId"];
		$obj_Industrial->IndustrialName= $row["IndustrialName"];
		$obj_Industrial->Description= $row["Description"];

        array_push($arr_IndustrialList, $obj_Industrial);
        }
		
		if(count($arr_IndustrialList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_IndustrialList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteIndustrial($IndustrialId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_industrial WHERE IndustrialId=".$IndustrialId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Industrial)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Industrial SET ". 
	"IndustrialId=".common::noSqlInject($obj_Industrial->IndustrialId).","."IndustrialName="."'".common::noSqlInject($obj_Industrial->IndustrialName)."'".","."Description="."'".common::noSqlInject($obj_Industrial->Description)."'".	        
	" WHERE  IndustrialId=".$obj_Industrial->IndustrialId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Industrial;
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
	
	public static function disableIndustrial($IndustrialId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Industrial SET Status=0 WHERE  IndustrialId=".$IndustrialId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Industrial;
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
