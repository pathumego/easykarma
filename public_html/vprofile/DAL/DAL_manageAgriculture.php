<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageAgriculture
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addAgriculture($obj_Agriculture)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Agriculture->AgricultureId = DAL_manageAgriculture::getLastAgricultureId()+1;
		
		 $sql = "INSERT INTO tbl_agriculture (AgricultureId,AgricultureName,Description) 
		VALUES (".
		common::noSqlInject($obj_Agriculture->AgricultureId).","."'".common::noSqlInject($obj_Agriculture->AgricultureName)."'".","."'".common::noSqlInject($obj_Agriculture->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Agriculture;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastAgricultureId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(AgricultureId) as maxId FROM  tbl_agriculture";
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

    public static function getAgricultureList()
    {
    	  $db = config::dbconfig();

        $arr_AgricultureList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_agriculture ORDER BY AgricultureId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Agriculture = new Agriculture();
		$obj_Agriculture->AgricultureId= $row["AgricultureId"];
		$obj_Agriculture->AgricultureName= $row["AgricultureName"];
		$obj_Agriculture->Description= $row["Description"];

        array_push($arr_AgricultureList, $obj_Agriculture);
        }
		
		if(count($arr_AgricultureList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_AgricultureList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getAgricultureByAgricultureId($AgricultureId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Agriculture = new Agriculture();
		$obj_Agriculture->AgricultureId = -1;
		$sql = "SELECT * FROM tbl_agriculture WHERE AgricultureId=".$AgricultureId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Agriculture->AgricultureId= $row["AgricultureId"];
		$obj_Agriculture->AgricultureName= $row["AgricultureName"];
		$obj_Agriculture->Description= $row["Description"];

        }
		
		if($obj_Agriculture->AgricultureId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Agriculture;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getAgricultureListByAgricultureId($AgricultureId)
    {
    		
        $db = config::dbconfig();

        $arr_AgricultureList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_agriculture WHERE AgricultureId=".$AgricultureId." ORDER BY AgricultureId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Agriculture = new Agriculture();
		$obj_Agriculture->AgricultureId= $row["AgricultureId"];
		$obj_Agriculture->AgricultureName= $row["AgricultureName"];
		$obj_Agriculture->Description= $row["Description"];

        array_push($arr_AgricultureList, $obj_Agriculture);
        }
		
		if(count($arr_AgricultureList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_AgricultureList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteAgriculture($AgricultureId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_agriculture WHERE AgricultureId=".$AgricultureId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Agriculture)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Agriculture SET ". 
	"AgricultureId=".common::noSqlInject($obj_Agriculture->AgricultureId).","."AgricultureName="."'".common::noSqlInject($obj_Agriculture->AgricultureName)."'".","."Description="."'".common::noSqlInject($obj_Agriculture->Description)."'".	        
	" WHERE  AgricultureId=".$obj_Agriculture->AgricultureId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Agriculture;
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
	
	public static function disableAgriculture($AgricultureId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Agriculture SET Status=0 WHERE  AgricultureId=".$AgricultureId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Agriculture;
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
