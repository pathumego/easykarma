<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageSoiltype
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addSoiltype($obj_Soiltype)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Soiltype->SoilTypeId = DAL_manageSoiltype::getLastSoiltypeId()+1;
		
		 $sql = "INSERT INTO tbl_soiltype (SoilTypeId,SoilTypeName,Description) 
		VALUES (".common::noSqlInject($obj_Soiltype->SoilTypeId).","."'".common::noSqlInject($obj_Soiltype->SoilTypeName)."'".","."'".common::noSqlInject($obj_Soiltype->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Soiltype;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastSoiltypeId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(SoilTypeId) as maxId FROM  tbl_soiltype";
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

    public static function getSoiltypeList()
    {
    	  $db = config::dbconfig();

        $arr_SoiltypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_soiltype ORDER BY SoilTypeId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Soiltype = new Soiltype();
		$obj_Soiltype->TblId= $row["SoilTypeId"];
		$obj_Soiltype->SoilTypeId= $row["SoilTypeId"];
		$obj_Soiltype->SoilTypeName= $row["SoilTypeName"];
		$obj_Soiltype->Description= $row["Description"];

        array_push($arr_SoiltypeList, $obj_Soiltype);
        }
		
		if(count($arr_SoiltypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_SoiltypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getSoiltypeByTblId($TblId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Soiltype = new Soiltype();
		$obj_Soiltype->SoilTypeId = -1;
		$sql = "SELECT * FROM tbl_soiltype WHERE SoilTypeId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Soiltype->TblId= $row["SoilTypeId"];
		$obj_Soiltype->SoilTypeId= $row["SoilTypeId"];
		$obj_Soiltype->SoilTypeName= $row["SoilTypeName"];
		$obj_Soiltype->Description= $row["Description"];

        }
		
		if($obj_Soiltype->TblId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Soiltype;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getSoiltypeListByTblId($TblId)
    {
    		
        $db = config::dbconfig();

        $arr_SoiltypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_soiltype WHERE SoilTypeId=".$TblId." ORDER BY SoilTypeId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Soiltype = new Soiltype();
		$obj_Soiltype->TblId= $row["SoilTypeId"];
		$obj_Soiltype->SoilTypeId= $row["SoilTypeId"];
		$obj_Soiltype->SoilTypeName= $row["SoilTypeName"];
		$obj_Soiltype->Description= $row["Description"];

        array_push($arr_SoiltypeList, $obj_Soiltype);
        }
		
		if(count($arr_SoiltypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_SoiltypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteSoiltype($TblId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_soiltype WHERE SoilTypeId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Soiltype)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Soiltype SET SoilTypeId=".common::noSqlInject($obj_Soiltype->SoilTypeId).","."SoilTypeName="."'".common::noSqlInject($obj_Soiltype->SoilTypeName)."'".","."Description="."'".common::noSqlInject($obj_Soiltype->Description)."'".	        
	" WHERE  TblId=".$obj_Soiltype->TblId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Soiltype;
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
	
	public static function disableSoiltype($TblId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Soiltype SET Status=0 WHERE  SoilTypeId=".$TblId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Soiltype;
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
