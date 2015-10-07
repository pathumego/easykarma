<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageForesttype
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addForesttype($obj_Foresttype)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Foresttype->ForestTypeId = DAL_manageForesttype::getLastForesttypeId()+1;
		
		 $sql = "INSERT INTO tbl_foresttype (ForestTypeId,Name,Description) 
		VALUES (".
		common::noSqlInject($obj_Foresttype->ForestTypeId).","."'".common::noSqlInject($obj_Foresttype->Name)."'".","."'".common::noSqlInject($obj_Foresttype->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Foresttype;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastForesttypeId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(ForestTypeId) as maxId FROM  tbl_foresttype";
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

    public static function getForesttypeList()
    {
    	  $db = config::dbconfig();

        $arr_ForesttypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_foresttype ORDER BY ForestTypeId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Foresttype = new Foresttype();
		$obj_Foresttype->ForestTypeId= $row["ForestTypeId"];
		$obj_Foresttype->Name= $row["Name"];
		$obj_Foresttype->Description= $row["Description"];

        array_push($arr_ForesttypeList, $obj_Foresttype);
        }
		
		if(count($arr_ForesttypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_ForesttypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getForesttypeByForestTypeId($ForestTypeId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Foresttype = new Foresttype();
		$obj_Foresttype->ForestTypeId = -1;
		$sql = "SELECT * FROM tbl_foresttype WHERE ForestTypeId=".$ForestTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Foresttype->ForestTypeId= $row["ForestTypeId"];
		$obj_Foresttype->Name= $row["Name"];
		$obj_Foresttype->Description= $row["Description"];

        }
		
		if($obj_Foresttype->ForestTypeId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Foresttype;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getForesttypeListByForestTypeId($ForestTypeId)
    {
    		
        $db = config::dbconfig();

        $arr_ForesttypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_foresttype WHERE ForestTypeId=".$ForestTypeId." ORDER BY ForestTypeId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Foresttype = new Foresttype();
		$obj_Foresttype->ForestTypeId= $row["ForestTypeId"];
		$obj_Foresttype->Name= $row["Name"];
		$obj_Foresttype->Description= $row["Description"];

        array_push($arr_ForesttypeList, $obj_Foresttype);
        }
		
		if(count($arr_ForesttypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_ForesttypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteForesttype($ForestTypeId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_foresttype WHERE ForestTypeId=".$ForestTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Foresttype)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Foresttype SET ". 
	"ForestTypeId=".common::noSqlInject($obj_Foresttype->ForestTypeId).","."Name="."'".common::noSqlInject($obj_Foresttype->Name)."'".","."Description="."'".common::noSqlInject($obj_Foresttype->Description)."'".	        
	" WHERE  ForestTypeId=".$obj_Foresttype->ForestTypeId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Foresttype;
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
	
	public static function disableForesttype($ForestTypeId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Foresttype SET Status=0 WHERE  ForestTypeId=".$ForestTypeId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Foresttype;
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
