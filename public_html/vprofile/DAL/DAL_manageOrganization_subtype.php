<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageOrganization_subtype
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addOrganization_subtype($obj_Organization_subtype)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Organization_subtype->OrganizationSubTypeId = DAL_manageOrganization_subtype::getLastOrganization_subtypeId()+1;
		
		 $sql = "INSERT INTO tbl_organization_subtype (OrganizationSubTypeId,OrganizationSubTypeName,Description) 
		VALUES (".
		common::noSqlInject($obj_Organization_subtype->OrganizationSubTypeId).","."'".common::noSqlInject($obj_Organization_subtype->OrganizationSubTypeName)."'".","."'".common::noSqlInject($obj_Organization_subtype->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Organization_subtype;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastOrganization_subtypeId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(OrganizationSubTypeId) as maxId FROM  tbl_organization_subtype";
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

    public static function getOrganization_subtypeList()
    {
    	  $db = config::dbconfig();

        $arr_Organization_subtypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_organization_subtype ORDER BY OrganizationSubTypeId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Organization_subtype = new Organization_subtype();
		$obj_Organization_subtype->OrganizationSubTypeId= $row["OrganizationSubTypeId"];
		$obj_Organization_subtype->OrganizationSubTypeName= $row["OrganizationSubTypeName"];
		$obj_Organization_subtype->Description= $row["Description"];

        array_push($arr_Organization_subtypeList, $obj_Organization_subtype);
        }
		
		if(count($arr_Organization_subtypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Organization_subtypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getOrganization_subtypeByOrganizationSubTypeId($OrganizationSubTypeId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Organization_subtype = new Organization_subtype();
		$obj_Organization_subtype->OrganizationSubTypeId = -1;
		$sql = "SELECT * FROM tbl_organization_subtype WHERE OrganizationSubTypeId=".$OrganizationSubTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Organization_subtype->OrganizationSubTypeId= $row["OrganizationSubTypeId"];
		$obj_Organization_subtype->OrganizationSubTypeName= $row["OrganizationSubTypeName"];
		$obj_Organization_subtype->Description= $row["Description"];

        }
		
		if($obj_Organization_subtype->OrganizationSubTypeId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Organization_subtype;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getOrganization_subtypeListByOrganizationSubTypeId($OrganizationSubTypeId)
    {
    		
        $db = config::dbconfig();

        $arr_Organization_subtypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_organization_subtype WHERE OrganizationSubTypeId=".$OrganizationSubTypeId." ORDER BY OrganizationSubTypeId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Organization_subtype = new Organization_subtype();
		$obj_Organization_subtype->OrganizationSubTypeId= $row["OrganizationSubTypeId"];
		$obj_Organization_subtype->OrganizationSubTypeName= $row["OrganizationSubTypeName"];
		$obj_Organization_subtype->Description= $row["Description"];

        array_push($arr_Organization_subtypeList, $obj_Organization_subtype);
        }
		
		if(count($arr_Organization_subtypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Organization_subtypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteOrganization_subtype($OrganizationSubTypeId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_organization_subtype WHERE OrganizationSubTypeId=".$OrganizationSubTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Organization_subtype)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Organization_subtype SET ". 
	"OrganizationSubTypeId=".common::noSqlInject($obj_Organization_subtype->OrganizationSubTypeId).","."OrganizationSubTypeName="."'".common::noSqlInject($obj_Organization_subtype->OrganizationSubTypeName)."'".","."Description="."'".common::noSqlInject($obj_Organization_subtype->Description)."'".	        
	" WHERE  OrganizationSubTypeId=".$obj_Organization_subtype->OrganizationSubTypeId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Organization_subtype;
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
	
	public static function disableOrganization_subtype($OrganizationSubTypeId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Organization_subtype SET Status=0 WHERE  OrganizationSubTypeId=".$OrganizationSubTypeId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Organization_subtype;
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
