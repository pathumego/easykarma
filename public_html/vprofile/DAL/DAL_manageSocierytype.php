<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageSocierytype
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addSocierytype($obj_Socierytype)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Socierytype->SocieryTypeId = DAL_manageSocierytype::getLastSocierytypeId()+1;
		
		 $sql = "INSERT INTO tbl_socierytype (SocieryTypeId,SocieryTypeName,Description) 
		VALUES (".
		common::noSqlInject($obj_Socierytype->SocieryTypeId).","."'".common::noSqlInject($obj_Socierytype->SocieryTypeName)."'".","."'".common::noSqlInject($obj_Socierytype->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Socierytype;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastSocierytypeId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(SocieryTypeId) as maxId FROM  tbl_socierytype";
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

    public static function getSocierytypeList()
    {
    	  $db = config::dbconfig();

        $arr_SocierytypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_socierytype ORDER BY SocieryTypeId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Socierytype = new Socierytype();
		$obj_Socierytype->SocieryTypeId= $row["SocieryTypeId"];
		$obj_Socierytype->SocieryTypeName= $row["SocieryTypeName"];
		$obj_Socierytype->Description= $row["Description"];

        array_push($arr_SocierytypeList, $obj_Socierytype);
        }
		
		if(count($arr_SocierytypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_SocierytypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getSocierytypeBySocieryTypeId($SocieryTypeId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Socierytype = new Socierytype();
		$obj_Socierytype->SocieryTypeId = -1;
		$sql = "SELECT * FROM tbl_socierytype WHERE SocieryTypeId=".$SocieryTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Socierytype->SocieryTypeId= $row["SocieryTypeId"];
		$obj_Socierytype->SocieryTypeName= $row["SocieryTypeName"];
		$obj_Socierytype->Description= $row["Description"];

        }
		
		if($obj_Socierytype->SocieryTypeId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Socierytype;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getSocierytypeListBySocieryTypeId($SocieryTypeId)
    {
    		
        $db = config::dbconfig();

        $arr_SocierytypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_socierytype WHERE SocieryTypeId=".$SocieryTypeId." ORDER BY SocieryTypeId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Socierytype = new Socierytype();
		$obj_Socierytype->SocieryTypeId= $row["SocieryTypeId"];
		$obj_Socierytype->SocieryTypeName= $row["SocieryTypeName"];
		$obj_Socierytype->Description= $row["Description"];

        array_push($arr_SocierytypeList, $obj_Socierytype);
        }
		
		if(count($arr_SocierytypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_SocierytypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteSocierytype($SocieryTypeId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_socierytype WHERE SocieryTypeId=".$SocieryTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Socierytype)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Socierytype SET ". 
	"SocieryTypeId=".common::noSqlInject($obj_Socierytype->SocieryTypeId).","."SocieryTypeName="."'".common::noSqlInject($obj_Socierytype->SocieryTypeName)."'".","."Description="."'".common::noSqlInject($obj_Socierytype->Description)."'".	        
	" WHERE  SocieryTypeId=".$obj_Socierytype->SocieryTypeId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Socierytype;
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
	
	public static function disableSocierytype($SocieryTypeId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Socierytype SET Status=0 WHERE  SocieryTypeId=".$SocieryTypeId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Socierytype;
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
