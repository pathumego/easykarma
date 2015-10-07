<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageOrganizationtype
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addOrganizationtype($obj_Organizationtype)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Organizationtype->OrganizationTypeId = DAL_manageOrganizationtype::getLastOrganizationtypeId()+1;
		
		 $sql = "INSERT INTO tbl_organizationtype (OrganizationTypeId,OrganizationTypeName,Description) 
		VALUES (".
		common::noSqlInject($obj_Organizationtype->OrganizationTypeId).","."'".common::noSqlInject($obj_Organizationtype->OrganizationTypeName)."'".","."'".common::noSqlInject($obj_Organizationtype->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Organizationtype;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastOrganizationtypeId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(OrganizationTypeId) as maxId FROM  tbl_organizationtype";
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

    public static function getOrganizationtypeList()
    {
    	  $db = config::dbconfig();

        $arr_OrganizationtypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_organizationtype ORDER BY OrganizationTypeId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Organizationtype = new Organizationtype();
		$obj_Organizationtype->OrganizationTypeId= $row["OrganizationTypeId"];
		$obj_Organizationtype->OrganizationTypeName= $row["OrganizationTypeName"];
		$obj_Organizationtype->Description= $row["Description"];

        array_push($arr_OrganizationtypeList, $obj_Organizationtype);
        }
		
		if(count($arr_OrganizationtypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_OrganizationtypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getOrganizationtypeByOrganizationTypeId($OrganizationTypeId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Organizationtype = new Organizationtype();
		$obj_Organizationtype->OrganizationTypeId = -1;
		$sql = "SELECT * FROM tbl_organizationtype WHERE OrganizationTypeId=".$OrganizationTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Organizationtype->OrganizationTypeId= $row["OrganizationTypeId"];
		$obj_Organizationtype->OrganizationTypeName= $row["OrganizationTypeName"];
		$obj_Organizationtype->Description= $row["Description"];

        }
		
		if($obj_Organizationtype->OrganizationTypeId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Organizationtype;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getOrganizationtypeListByOrganizationTypeId($OrganizationTypeId)
    {
    		
        $db = config::dbconfig();

        $arr_OrganizationtypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_organizationtype WHERE OrganizationTypeId=".$OrganizationTypeId." ORDER BY OrganizationTypeId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Organizationtype = new Organizationtype();
		$obj_Organizationtype->OrganizationTypeId= $row["OrganizationTypeId"];
		$obj_Organizationtype->OrganizationTypeName= $row["OrganizationTypeName"];
		$obj_Organizationtype->Description= $row["Description"];

        array_push($arr_OrganizationtypeList, $obj_Organizationtype);
        }
		
		if(count($arr_OrganizationtypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_OrganizationtypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteOrganizationtype($OrganizationTypeId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_organizationtype WHERE OrganizationTypeId=".$OrganizationTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Organizationtype)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Organizationtype SET ". 
	"OrganizationTypeId=".common::noSqlInject($obj_Organizationtype->OrganizationTypeId).","."OrganizationTypeName="."'".common::noSqlInject($obj_Organizationtype->OrganizationTypeName)."'".","."Description="."'".common::noSqlInject($obj_Organizationtype->Description)."'".	        
	" WHERE  OrganizationTypeId=".$obj_Organizationtype->OrganizationTypeId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Organizationtype;
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
	
	public static function disableOrganizationtype($OrganizationTypeId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Organizationtype SET Status=0 WHERE  OrganizationTypeId=".$OrganizationTypeId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Organizationtype;
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
