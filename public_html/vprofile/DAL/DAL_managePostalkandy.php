<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePostalkandy
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPostalkandy($obj_Postalkandy)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Postalkandy-> = DAL_managePostalkandy::getLastPostalkandyId()+1;
		
		 $sql = "INSERT INTO postalkandy (col1,col2,col3) 
		VALUES (".
		"'".common::noSqlInject($obj_Postalkandy->col1)."'".","."'".common::noSqlInject($obj_Postalkandy->col2)."'".","."'".common::noSqlInject($obj_Postalkandy->col3)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Postalkandy;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPostalkandyId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX() as maxId FROM  postalkandy";
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

    public static function getPostalkandyList()
    {
    	  $db = config::dbconfig();

        $arr_PostalkandyList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM postalkandy ORDER BY  DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Postalkandy = new Postalkandy();
		$obj_Postalkandy->col1= $row["col1"];
		$obj_Postalkandy->col2= $row["col2"];
		$obj_Postalkandy->col3= $row["col3"];

        array_push($arr_PostalkandyList, $obj_Postalkandy);
        }
		
		if(count($arr_PostalkandyList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_PostalkandyList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPostalkandyBy($)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Postalkandy = new Postalkandy();
		$obj_Postalkandy-> = -1;
		$sql = "SELECT * FROM postalkandy WHERE =".$;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Postalkandy->col1= $row["col1"];
		$obj_Postalkandy->col2= $row["col2"];
		$obj_Postalkandy->col3= $row["col3"];

        }
		
		if($obj_Postalkandy-> >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Postalkandy;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPostalkandyListBy($)
    {
    		
        $db = config::dbconfig();

        $arr_PostalkandyList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM postalkandy WHERE =".$." ORDER BY  DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Postalkandy = new Postalkandy();
		$obj_Postalkandy->col1= $row["col1"];
		$obj_Postalkandy->col2= $row["col2"];
		$obj_Postalkandy->col3= $row["col3"];

        array_push($arr_PostalkandyList, $obj_Postalkandy);
        }
		
		if(count($arr_PostalkandyList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_PostalkandyList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePostalkandy($)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM postalkandy WHERE =".$;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Postalkandy)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Postalkandy SET ". 
	"col1="."'".common::noSqlInject($obj_Postalkandy->col1)."'".","."col2="."'".common::noSqlInject($obj_Postalkandy->col2)."'".","."col3="."'".common::noSqlInject($obj_Postalkandy->col3)."'".	        
	" WHERE  =".$obj_Postalkandy->;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Postalkandy;
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
	
	public static function disablePostalkandy($)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Postalkandy SET Status=0 WHERE  =".$;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Postalkandy;
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
