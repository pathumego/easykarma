<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageBusinesstype
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addBusinesstype($obj_Businesstype)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Businesstype->BusinessTypeId = DAL_manageBusinesstype::getLastBusinesstypeId()+1;
		
		 $sql = "INSERT INTO tbl_businesstype (BusinessTypeId,BusinessTypeName,Description) 
		VALUES (".
		common::noSqlInject($obj_Businesstype->BusinessTypeId).","."'".common::noSqlInject($obj_Businesstype->BusinessTypeName)."'".","."'".common::noSqlInject($obj_Businesstype->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Businesstype;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastBusinesstypeId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(BusinessTypeId) as maxId FROM  tbl_businesstype";
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

    public static function getBusinesstypeList()
    {
    	  $db = config::dbconfig();

        $arr_BusinesstypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_businesstype ORDER BY BusinessTypeId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Businesstype = new Businesstype();
		$obj_Businesstype->BusinessTypeId= $row["BusinessTypeId"];
		$obj_Businesstype->BusinessTypeName= $row["BusinessTypeName"];
		$obj_Businesstype->Description= $row["Description"];

        array_push($arr_BusinesstypeList, $obj_Businesstype);
        }
		
		if(count($arr_BusinesstypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_BusinesstypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getBusinesstypeByBusinessTypeId($BusinessTypeId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Businesstype = new Businesstype();
		$obj_Businesstype->BusinessTypeId = -1;
		$sql = "SELECT * FROM tbl_businesstype WHERE BusinessTypeId=".$BusinessTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Businesstype->BusinessTypeId= $row["BusinessTypeId"];
		$obj_Businesstype->BusinessTypeName= $row["BusinessTypeName"];
		$obj_Businesstype->Description= $row["Description"];

        }
		
		if($obj_Businesstype->BusinessTypeId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Businesstype;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getBusinesstypeListByBusinessTypeId($BusinessTypeId)
    {
    		
        $db = config::dbconfig();

        $arr_BusinesstypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_businesstype WHERE BusinessTypeId=".$BusinessTypeId." ORDER BY BusinessTypeId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Businesstype = new Businesstype();
		$obj_Businesstype->BusinessTypeId= $row["BusinessTypeId"];
		$obj_Businesstype->BusinessTypeName= $row["BusinessTypeName"];
		$obj_Businesstype->Description= $row["Description"];

        array_push($arr_BusinesstypeList, $obj_Businesstype);
        }
		
		if(count($arr_BusinesstypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_BusinesstypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteBusinesstype($BusinessTypeId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_businesstype WHERE BusinessTypeId=".$BusinessTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Businesstype)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_businesstype SET ". 
	"BusinessTypeId=".common::noSqlInject($obj_Businesstype->BusinessTypeId).","."BusinessTypeName="."'".common::noSqlInject($obj_Businesstype->BusinessTypeName)."'".","."Description="."'".common::noSqlInject($obj_Businesstype->Description)."'".	        
	" WHERE  BusinessTypeId=".$obj_Businesstype->BusinessTypeId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Businesstype;
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
	
	public static function disableBusinesstype($BusinessTypeId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_businesstype SET Status=0 WHERE  BusinessTypeId=".$BusinessTypeId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Businesstype;
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
