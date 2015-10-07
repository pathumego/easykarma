<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageBusiness
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addBusiness($obj_Business)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Business->BusinessId = DAL_manageBusiness::getLastBusinessId()+1;
		
		 $sql = "INSERT INTO tbl_business (BusinessId,Name,Description,Address,telephone,fax,website,email,BusinessTypeId,BusinessSubTypeId) 
		VALUES (".
		common::noSqlInject($obj_Business->BusinessId).","."'".common::noSqlInject($obj_Business->Name)."'".","."'".common::noSqlInject($obj_Business->Description)."'".","."'".common::noSqlInject($obj_Business->Address)."'".","."'".common::noSqlInject($obj_Business->telephone)."'".","."'".common::noSqlInject($obj_Business->fax)."'".","."'".common::noSqlInject($obj_Business->website)."'".","."'".common::noSqlInject($obj_Business->email)."'".",".common::noSqlInject($obj_Business->BusinessTypeId).",".common::noSqlInject($obj_Business->BusinessSubTypeId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Business;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastBusinessId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(BusinessId) as maxId FROM  tbl_business";
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

    public static function getBusinessList()
    {
    	  $db = config::dbconfig();

        $arr_BusinessList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_business ORDER BY BusinessId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Business = new Business();
		$obj_Business->BusinessId= $row["BusinessId"];
		$obj_Business->Name= $row["Name"];
		$obj_Business->Description= $row["Description"];
		$obj_Business->Address= $row["Address"];
		$obj_Business->telephone= $row["telephone"];
		$obj_Business->fax= $row["fax"];
		$obj_Business->website= $row["website"];
		$obj_Business->email= $row["email"];
		$obj_Business->BusinessTypeId= $row["BusinessTypeId"];
		$obj_Business->BusinessSubTypeId= $row["BusinessSubTypeId"];

        array_push($arr_BusinessList, $obj_Business);
        }
		
		if(count($arr_BusinessList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_BusinessList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getBusinessByBusinessId($BusinessId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Business = new Business();
		$obj_Business->BusinessId = -1;
		$sql = "SELECT * FROM tbl_business WHERE BusinessId=".$BusinessId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Business->BusinessId= $row["BusinessId"];
		$obj_Business->Name= $row["Name"];
		$obj_Business->Description= $row["Description"];
		$obj_Business->Address= $row["Address"];
		$obj_Business->telephone= $row["telephone"];
		$obj_Business->fax= $row["fax"];
		$obj_Business->website= $row["website"];
		$obj_Business->email= $row["email"];
		$obj_Business->BusinessTypeId= $row["BusinessTypeId"];
		$obj_Business->BusinessSubTypeId= $row["BusinessSubTypeId"];

        }
		
		if($obj_Business->BusinessId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Business;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getBusinessListByBusinessId($BusinessId)
    {
    		
        $db = config::dbconfig();

        $arr_BusinessList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_business WHERE BusinessId=".$BusinessId." ORDER BY BusinessId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Business = new Business();
		$obj_Business->BusinessId= $row["BusinessId"];
		$obj_Business->Name= $row["Name"];
		$obj_Business->Description= $row["Description"];
		$obj_Business->Address= $row["Address"];
		$obj_Business->telephone= $row["telephone"];
		$obj_Business->fax= $row["fax"];
		$obj_Business->website= $row["website"];
		$obj_Business->email= $row["email"];
		$obj_Business->BusinessTypeId= $row["BusinessTypeId"];
		$obj_Business->BusinessSubTypeId= $row["BusinessSubTypeId"];

        array_push($arr_BusinessList, $obj_Business);
        }
		
		if(count($arr_BusinessList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_BusinessList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteBusiness($BusinessId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_business WHERE BusinessId=".$BusinessId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Business)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_business SET ". 
	"BusinessId=".common::noSqlInject($obj_Business->BusinessId).","."Name="."'".common::noSqlInject($obj_Business->Name)."'".","."Description="."'".common::noSqlInject($obj_Business->Description)."'".","."Address="."'".common::noSqlInject($obj_Business->Address)."'".","."telephone="."'".common::noSqlInject($obj_Business->telephone)."'".","."fax="."'".common::noSqlInject($obj_Business->fax)."'".","."website="."'".common::noSqlInject($obj_Business->website)."'".","."email="."'".common::noSqlInject($obj_Business->email)."'".","."BusinessTypeId=".common::noSqlInject($obj_Business->BusinessTypeId).","."BusinessSubTypeId=".common::noSqlInject($obj_Business->BusinessSubTypeId).	        
	" WHERE  BusinessId=".$obj_Business->BusinessId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Business;
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
	
	public static function disableBusiness($BusinessId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_business SET Status=0 WHERE  BusinessId=".$BusinessId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Business;
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
