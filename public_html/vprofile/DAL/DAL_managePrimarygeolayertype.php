<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePrimarygeolayertype
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPrimarygeolayertype($obj_Primarygeolayertype)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Primarygeolayertype->PrimaryGeoLayerTypeId = DAL_managePrimarygeolayertype::getLastPrimarygeolayertypeId()+1;
		
		 $sql = "INSERT INTO tbl_primarygeolayertype (PrimaryGeoLayerTypeId,PrimaryGeoLayerName,Description) 
		VALUES (".
		common::noSqlInject($obj_Primarygeolayertype->PrimaryGeoLayerTypeId).","."'".common::noSqlInject($obj_Primarygeolayertype->PrimaryGeoLayerName)."'".","."'".common::noSqlInject($obj_Primarygeolayertype->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Primarygeolayertype;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPrimarygeolayertypeId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(PrimaryGeoLayerTypeId) as maxId FROM  tbl_primarygeolayertype";
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

    public static function getPrimarygeolayertypeList()
    {
    	  $db = config::dbconfig();

        $arr_PrimarygeolayertypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_primarygeolayertype ORDER BY PrimaryGeoLayerTypeId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Primarygeolayertype = new Primarygeolayertype();
		$obj_Primarygeolayertype->PrimaryGeoLayerTypeId= $row["PrimaryGeoLayerTypeId"];
		$obj_Primarygeolayertype->PrimaryGeoLayerName= $row["PrimaryGeoLayerName"];
		$obj_Primarygeolayertype->Description= $row["Description"];

        array_push($arr_PrimarygeolayertypeList, $obj_Primarygeolayertype);
        }
		
		if(count($arr_PrimarygeolayertypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_PrimarygeolayertypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPrimarygeolayertypeByPrimaryGeoLayerTypeId($PrimaryGeoLayerTypeId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Primarygeolayertype = new Primarygeolayertype();
		$obj_Primarygeolayertype->PrimaryGeoLayerTypeId = -1;
		$sql = "SELECT * FROM tbl_primarygeolayertype WHERE PrimaryGeoLayerTypeId=".$PrimaryGeoLayerTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Primarygeolayertype->PrimaryGeoLayerTypeId= $row["PrimaryGeoLayerTypeId"];
		$obj_Primarygeolayertype->PrimaryGeoLayerName= $row["PrimaryGeoLayerName"];
		$obj_Primarygeolayertype->Description= $row["Description"];

        }
		
		if($obj_Primarygeolayertype->PrimaryGeoLayerTypeId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Primarygeolayertype;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPrimarygeolayertypeListByPrimaryGeoLayerTypeId($PrimaryGeoLayerTypeId)
    {
    		
        $db = config::dbconfig();

        $arr_PrimarygeolayertypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_primarygeolayertype WHERE PrimaryGeoLayerTypeId=".$PrimaryGeoLayerTypeId." ORDER BY PrimaryGeoLayerTypeId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Primarygeolayertype = new Primarygeolayertype();
		$obj_Primarygeolayertype->PrimaryGeoLayerTypeId= $row["PrimaryGeoLayerTypeId"];
		$obj_Primarygeolayertype->PrimaryGeoLayerName= $row["PrimaryGeoLayerName"];
		$obj_Primarygeolayertype->Description= $row["Description"];

        array_push($arr_PrimarygeolayertypeList, $obj_Primarygeolayertype);
        }
		
		if(count($arr_PrimarygeolayertypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_PrimarygeolayertypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePrimarygeolayertype($PrimaryGeoLayerTypeId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_primarygeolayertype WHERE PrimaryGeoLayerTypeId=".$PrimaryGeoLayerTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Primarygeolayertype)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Primarygeolayertype SET ". 
	"PrimaryGeoLayerTypeId=".common::noSqlInject($obj_Primarygeolayertype->PrimaryGeoLayerTypeId).","."PrimaryGeoLayerName="."'".common::noSqlInject($obj_Primarygeolayertype->PrimaryGeoLayerName)."'".","."Description="."'".common::noSqlInject($obj_Primarygeolayertype->Description)."'".	        
	" WHERE  PrimaryGeoLayerTypeId=".$obj_Primarygeolayertype->PrimaryGeoLayerTypeId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Primarygeolayertype;
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
	
	public static function disablePrimarygeolayertype($PrimaryGeoLayerTypeId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Primarygeolayertype SET Status=0 WHERE  PrimaryGeoLayerTypeId=".$PrimaryGeoLayerTypeId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Primarygeolayertype;
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
