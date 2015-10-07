<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageTraditionalknowledgecategory
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addTraditionalknowledgecategory($obj_Traditionalknowledgecategory)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Traditionalknowledgecategory->CategoryId = DAL_manageTraditionalknowledgecategory::getLastTraditionalknowledgecategoryId()+1;
		
		 $sql = "INSERT INTO tbl_traditionalknowledgecategory (CategoryId,CategoryName,Description) 
		VALUES (".
		common::noSqlInject($obj_Traditionalknowledgecategory->CategoryId).","."'".common::noSqlInject($obj_Traditionalknowledgecategory->CategoryName)."'".","."'".common::noSqlInject($obj_Traditionalknowledgecategory->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Traditionalknowledgecategory;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastTraditionalknowledgecategoryId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(CategoryId) as maxId FROM  tbl_traditionalknowledgecategory";
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

    public static function getTraditionalknowledgecategoryList()
    {
    	  $db = config::dbconfig();

        $arr_TraditionalknowledgecategoryList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_traditionalknowledgecategory ORDER BY CategoryId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
		$obj_Traditionalknowledgecategory->CategoryId= $row["CategoryId"];
		$obj_Traditionalknowledgecategory->CategoryName= $row["CategoryName"];
		$obj_Traditionalknowledgecategory->Description= $row["Description"];

        array_push($arr_TraditionalknowledgecategoryList, $obj_Traditionalknowledgecategory);
        }
		
		if(count($arr_TraditionalknowledgecategoryList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_TraditionalknowledgecategoryList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTraditionalknowledgecategoryByCategoryId($CategoryId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
		$obj_Traditionalknowledgecategory->CategoryId = -1;
		$sql = "SELECT * FROM tbl_traditionalknowledgecategory WHERE CategoryId=".$CategoryId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Traditionalknowledgecategory->CategoryId= $row["CategoryId"];
		$obj_Traditionalknowledgecategory->CategoryName= $row["CategoryName"];
		$obj_Traditionalknowledgecategory->Description= $row["Description"];

        }
		
		if($obj_Traditionalknowledgecategory->CategoryId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Traditionalknowledgecategory;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTraditionalknowledgecategoryListByCategoryId($CategoryId)
    {
    		
        $db = config::dbconfig();

        $arr_TraditionalknowledgecategoryList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_traditionalknowledgecategory WHERE CategoryId=".$CategoryId." ORDER BY CategoryId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
		$obj_Traditionalknowledgecategory->CategoryId= $row["CategoryId"];
		$obj_Traditionalknowledgecategory->CategoryName= $row["CategoryName"];
		$obj_Traditionalknowledgecategory->Description= $row["Description"];

        array_push($arr_TraditionalknowledgecategoryList, $obj_Traditionalknowledgecategory);
        }
		
		if(count($arr_TraditionalknowledgecategoryList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_TraditionalknowledgecategoryList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteTraditionalknowledgecategory($CategoryId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_traditionalknowledgecategory WHERE CategoryId=".$CategoryId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Traditionalknowledgecategory)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Traditionalknowledgecategory SET ". 
	"CategoryId=".common::noSqlInject($obj_Traditionalknowledgecategory->CategoryId).","."CategoryName="."'".common::noSqlInject($obj_Traditionalknowledgecategory->CategoryName)."'".","."Description="."'".common::noSqlInject($obj_Traditionalknowledgecategory->Description)."'".	        
	" WHERE  CategoryId=".$obj_Traditionalknowledgecategory->CategoryId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Traditionalknowledgecategory;
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
	
	public static function disableTraditionalknowledgecategory($CategoryId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Traditionalknowledgecategory SET Status=0 WHERE  CategoryId=".$CategoryId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Traditionalknowledgecategory;
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
