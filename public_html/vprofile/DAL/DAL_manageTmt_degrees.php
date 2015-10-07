<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageTmt_degrees
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addTmt_degrees($obj_Tmt_degrees)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Tmt_degrees-> = DAL_manageTmt_degrees::getLastTmt_degreesId()+1;
		
		 $sql = "INSERT INTO tbl_tmt_degrees (col1,col2) 
		VALUES (".
		"'".common::noSqlInject($obj_Tmt_degrees->col1)."'".","."'".common::noSqlInject($obj_Tmt_degrees->col2)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Tmt_degrees;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastTmt_degreesId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX() as maxId FROM  tbl_tmt_degrees";
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

    public static function getTmt_degreesList()
    {
    	  $db = config::dbconfig();

        $arr_Tmt_degreesList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_tmt_degrees ORDER BY  DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Tmt_degrees = new Tmt_degrees();
		$obj_Tmt_degrees->col1= $row["col1"];
		$obj_Tmt_degrees->col2= $row["col2"];

        array_push($arr_Tmt_degreesList, $obj_Tmt_degrees);
        }
		
		if(count($arr_Tmt_degreesList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Tmt_degreesList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTmt_degreesBy($)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Tmt_degrees = new Tmt_degrees();
		$obj_Tmt_degrees-> = -1;
		$sql = "SELECT * FROM tbl_tmt_degrees WHERE =".$;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Tmt_degrees->col1= $row["col1"];
		$obj_Tmt_degrees->col2= $row["col2"];

        }
		
		if($obj_Tmt_degrees-> >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Tmt_degrees;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTmt_degreesListBy($)
    {
    		
        $db = config::dbconfig();

        $arr_Tmt_degreesList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_tmt_degrees WHERE =".$." ORDER BY  DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Tmt_degrees = new Tmt_degrees();
		$obj_Tmt_degrees->col1= $row["col1"];
		$obj_Tmt_degrees->col2= $row["col2"];

        array_push($arr_Tmt_degreesList, $obj_Tmt_degrees);
        }
		
		if(count($arr_Tmt_degreesList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Tmt_degreesList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteTmt_degrees($)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_tmt_degrees WHERE =".$;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Tmt_degrees)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Tmt_degrees SET ". 
	"col1="."'".common::noSqlInject($obj_Tmt_degrees->col1)."'".","."col2="."'".common::noSqlInject($obj_Tmt_degrees->col2)."'".	        
	" WHERE  =".$obj_Tmt_degrees->;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Tmt_degrees;
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
	
	public static function disableTmt_degrees($)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Tmt_degrees SET Status=0 WHERE  =".$;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Tmt_degrees;
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
