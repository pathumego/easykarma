<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageGeographytype
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addGeographytype($obj_Geographytype)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Geographytype->GeogrophyTypeId = DAL_manageGeographytype::getLastGeographytypeId()+1;
		
		 $sql = "INSERT INTO tbl_geographytype (GeogrophyTypeId,Name,Description) 
		VALUES (".
		common::noSqlInject($obj_Geographytype->GeogrophyTypeId).","."'".common::noSqlInject($obj_Geographytype->Name)."'".","."'".common::noSqlInject($obj_Geographytype->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Geographytype;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastGeographytypeId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(GeogrophyTypeId) as maxId FROM  tbl_geographytype";
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

    public static function getGeographytypeList()
    {
    	  $db = config::dbconfig();

        $arr_GeographytypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_geographytype ORDER BY GeogrophyTypeId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Geographytype = new Geographytype();
		$obj_Geographytype->GeogrophyTypeId= $row["GeogrophyTypeId"];
		$obj_Geographytype->Name= $row["Name"];
		$obj_Geographytype->Description= $row["Description"];

        array_push($arr_GeographytypeList, $obj_Geographytype);
        }
		
		if(count($arr_GeographytypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_GeographytypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getGeographytypeByGeogrophyTypeId($GeogrophyTypeId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Geographytype = new Geographytype();
		$obj_Geographytype->GeogrophyTypeId = -1;
		$sql = "SELECT * FROM tbl_geographytype WHERE GeogrophyTypeId=".$GeogrophyTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Geographytype->GeogrophyTypeId= $row["GeogrophyTypeId"];
		$obj_Geographytype->Name= $row["Name"];
		$obj_Geographytype->Description= $row["Description"];

        }
		
		if($obj_Geographytype->GeogrophyTypeId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Geographytype;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getGeographytypeListByGeogrophyTypeId($GeogrophyTypeId)
    {
    		
        $db = config::dbconfig();

        $arr_GeographytypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_geographytype WHERE GeogrophyTypeId=".$GeogrophyTypeId." ORDER BY GeogrophyTypeId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Geographytype = new Geographytype();
		$obj_Geographytype->GeogrophyTypeId= $row["GeogrophyTypeId"];
		$obj_Geographytype->Name= $row["Name"];
		$obj_Geographytype->Description= $row["Description"];

        array_push($arr_GeographytypeList, $obj_Geographytype);
        }
		
		if(count($arr_GeographytypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_GeographytypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteGeographytype($GeogrophyTypeId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_geographytype WHERE GeogrophyTypeId=".$GeogrophyTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Geographytype)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Geographytype SET ". 
	"GeogrophyTypeId=".common::noSqlInject($obj_Geographytype->GeogrophyTypeId).","."Name="."'".common::noSqlInject($obj_Geographytype->Name)."'".","."Description="."'".common::noSqlInject($obj_Geographytype->Description)."'".	        
	" WHERE  GeogrophyTypeId=".$obj_Geographytype->GeogrophyTypeId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Geographytype;
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
	
	public static function disableGeographytype($GeogrophyTypeId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Geographytype SET Status=0 WHERE  GeogrophyTypeId=".$GeogrophyTypeId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Geographytype;
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
