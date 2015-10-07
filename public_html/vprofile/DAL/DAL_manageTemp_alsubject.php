<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageTemp_alsubject
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addTemp_alsubject($obj_Temp_alsubject)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Temp_alsubject-> = DAL_manageTemp_alsubject::getLastTemp_alsubjectId()+1;
		
		 $sql = "INSERT INTO tbl_temp_alsubject (col1,col2) 
		VALUES (".
		"'".common::noSqlInject($obj_Temp_alsubject->col1)."'".","."'".common::noSqlInject($obj_Temp_alsubject->col2)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Temp_alsubject;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastTemp_alsubjectId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX() as maxId FROM  tbl_temp_alsubject";
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

    public static function getTemp_alsubjectList()
    {
    	  $db = config::dbconfig();

        $arr_Temp_alsubjectList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_temp_alsubject ORDER BY  DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Temp_alsubject = new Temp_alsubject();
		$obj_Temp_alsubject->col1= $row["col1"];
		$obj_Temp_alsubject->col2= $row["col2"];

        array_push($arr_Temp_alsubjectList, $obj_Temp_alsubject);
        }
		
		if(count($arr_Temp_alsubjectList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Temp_alsubjectList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTemp_alsubjectBy($)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Temp_alsubject = new Temp_alsubject();
		$obj_Temp_alsubject-> = -1;
		$sql = "SELECT * FROM tbl_temp_alsubject WHERE =".$;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Temp_alsubject->col1= $row["col1"];
		$obj_Temp_alsubject->col2= $row["col2"];

        }
		
		if($obj_Temp_alsubject-> >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Temp_alsubject;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getTemp_alsubjectListBy($)
    {
    		
        $db = config::dbconfig();

        $arr_Temp_alsubjectList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_temp_alsubject WHERE =".$." ORDER BY  DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Temp_alsubject = new Temp_alsubject();
		$obj_Temp_alsubject->col1= $row["col1"];
		$obj_Temp_alsubject->col2= $row["col2"];

        array_push($arr_Temp_alsubjectList, $obj_Temp_alsubject);
        }
		
		if(count($arr_Temp_alsubjectList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Temp_alsubjectList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteTemp_alsubject($)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_temp_alsubject WHERE =".$;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Temp_alsubject)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Temp_alsubject SET ". 
	"col1="."'".common::noSqlInject($obj_Temp_alsubject->col1)."'".","."col2="."'".common::noSqlInject($obj_Temp_alsubject->col2)."'".	        
	" WHERE  =".$obj_Temp_alsubject->;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Temp_alsubject;
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
	
	public static function disableTemp_alsubject($)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Temp_alsubject SET Status=0 WHERE  =".$;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Temp_alsubject;
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
