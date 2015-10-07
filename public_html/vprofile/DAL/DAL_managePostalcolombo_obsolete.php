<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePostalcolombo
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPostalcolombo($obj_Postalcolombo)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
      //  $obj_Postalcolombo->col1 = DAL_managePostalcolombo::getLastPostalcolomboId()+1;
		
		 $sql = "INSERT INTO postalcolombo (col1,col2,col3) 
		VALUES (".
		"'".common::noSqlInject($obj_Postalcolombo->col1)."'".","."'".common::noSqlInject($obj_Postalcolombo->col2)."'".","."'".common::noSqlInject($obj_Postalcolombo->col3)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Postalcolombo;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPostalcolomboId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX() as maxId FROM  postalcolombo";
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

    public static function getPostalcolomboList()
    {
    	  $db = config::dbconfig();

        $arr_PostalcolomboList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM postalcolombo ORDER BY  DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Postalcolombo = new Postalcolombo();
		$obj_Postalcolombo->col1= $row["col1"];
		$obj_Postalcolombo->col2= $row["col2"];
		$obj_Postalcolombo->col3= $row["col3"];

        array_push($arr_PostalcolomboList, $obj_Postalcolombo);
        }
		
		if(count($arr_PostalcolomboList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_PostalcolomboList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPostalcolomboBy($c)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Postalcolombo = new Postalcolombo();
		$obj_Postalcolombo-> = -1;
		$sql = "SELECT * FROM postalcolombo WHERE =".$c;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Postalcolombo->col1= $row["col1"];
		$obj_Postalcolombo->col2= $row["col2"];
		$obj_Postalcolombo->col3= $row["col3"];

        }
		
		if($obj_Postalcolombo-> >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Postalcolombo;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPostalcolomboListBy($)
    {
    		
        $db = config::dbconfig();

        $arr_PostalcolomboList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM postalcolombo WHERE =".$." ORDER BY  DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Postalcolombo = new Postalcolombo();
		$obj_Postalcolombo->col1= $row["col1"];
		$obj_Postalcolombo->col2= $row["col2"];
		$obj_Postalcolombo->col3= $row["col3"];

        array_push($arr_PostalcolomboList, $obj_Postalcolombo);
        }
		
		if(count($arr_PostalcolomboList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_PostalcolomboList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePostalcolombo($)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM postalcolombo WHERE =".$;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Postalcolombo)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Postalcolombo SET ". 
	"col1="."'".common::noSqlInject($obj_Postalcolombo->col1)."'".","."col2="."'".common::noSqlInject($obj_Postalcolombo->col2)."'".","."col3="."'".common::noSqlInject($obj_Postalcolombo->col3)."'".	        
	" WHERE  =".$obj_Postalcolombo->;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Postalcolombo;
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
	
	public static function disablePostalcolombo($)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Postalcolombo SET Status=0 WHERE  =".$;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Postalcolombo;
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
