<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageOrganization
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addOrganization($obj_Organization)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Organization->OrganizationId = DAL_manageOrganization::getLastOrganizationId()+1;
		
		 $sql = "INSERT INTO tbl_organization (OrganizationId,Name,Description,Address,telephone,fax,website,email,OrganizationTypeId,OrganizationSubTypeId) 
		VALUES (".
		common::noSqlInject($obj_Organization->OrganizationId).","."'".common::noSqlInject($obj_Organization->Name)."'".","."'".common::noSqlInject($obj_Organization->Description)."'".","."'".common::noSqlInject($obj_Organization->Address)."'".","."'".common::noSqlInject($obj_Organization->telephone)."'".","."'".common::noSqlInject($obj_Organization->fax)."'".","."'".common::noSqlInject($obj_Organization->website)."'".","."'".common::noSqlInject($obj_Organization->email)."'".",".common::noSqlInject($obj_Organization->OrganizationTypeId).",".common::noSqlInject($obj_Organization->OrganizationSubTypeId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Organization;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastOrganizationId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(OrganizationId) as maxId FROM  tbl_organization";
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

    public static function getOrganizationList()
    {
    	  $db = config::dbconfig();

        $arr_OrganizationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_organization ORDER BY OrganizationId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Organization = new Organization();
		$obj_Organization->OrganizationId= $row["OrganizationId"];
		$obj_Organization->Name= $row["Name"];
		$obj_Organization->Description= $row["Description"];
		$obj_Organization->Address= $row["Address"];
		$obj_Organization->telephone= $row["telephone"];
		$obj_Organization->fax= $row["fax"];
		$obj_Organization->website= $row["website"];
		$obj_Organization->email= $row["email"];
		$obj_Organization->OrganizationTypeId= $row["OrganizationTypeId"];
		$obj_Organization->OrganizationSubTypeId= $row["OrganizationSubTypeId"];

        array_push($arr_OrganizationList, $obj_Organization);
        }
		
		if(count($arr_OrganizationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_OrganizationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getOrganizationByOrganizationId($OrganizationId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Organization = new Organization();
		$obj_Organization->OrganizationId = -1;
		$sql = "SELECT * FROM tbl_organization WHERE OrganizationId=".$OrganizationId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Organization->OrganizationId= $row["OrganizationId"];
		$obj_Organization->Name= $row["Name"];
		$obj_Organization->Description= $row["Description"];
		$obj_Organization->Address= $row["Address"];
		$obj_Organization->telephone= $row["telephone"];
		$obj_Organization->fax= $row["fax"];
		$obj_Organization->website= $row["website"];
		$obj_Organization->email= $row["email"];
		$obj_Organization->OrganizationTypeId= $row["OrganizationTypeId"];
		$obj_Organization->OrganizationSubTypeId= $row["OrganizationSubTypeId"];

        }
		
		if($obj_Organization->OrganizationId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Organization;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getOrganizationListByOrganizationId($OrganizationId)
    {
    		
        $db = config::dbconfig();

        $arr_OrganizationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_organization WHERE OrganizationId=".$OrganizationId." ORDER BY OrganizationId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Organization = new Organization();
		$obj_Organization->OrganizationId= $row["OrganizationId"];
		$obj_Organization->Name= $row["Name"];
		$obj_Organization->Description= $row["Description"];
		$obj_Organization->Address= $row["Address"];
		$obj_Organization->telephone= $row["telephone"];
		$obj_Organization->fax= $row["fax"];
		$obj_Organization->website= $row["website"];
		$obj_Organization->email= $row["email"];
		$obj_Organization->OrganizationTypeId= $row["OrganizationTypeId"];
		$obj_Organization->OrganizationSubTypeId= $row["OrganizationSubTypeId"];

        array_push($arr_OrganizationList, $obj_Organization);
        }
		
		if(count($arr_OrganizationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_OrganizationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteOrganization($OrganizationId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_organization WHERE OrganizationId=".$OrganizationId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Organization)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Organization SET ". 
	"OrganizationId=".common::noSqlInject($obj_Organization->OrganizationId).","."Name="."'".common::noSqlInject($obj_Organization->Name)."'".","."Description="."'".common::noSqlInject($obj_Organization->Description)."'".","."Address="."'".common::noSqlInject($obj_Organization->Address)."'".","."telephone="."'".common::noSqlInject($obj_Organization->telephone)."'".","."fax="."'".common::noSqlInject($obj_Organization->fax)."'".","."website="."'".common::noSqlInject($obj_Organization->website)."'".","."email="."'".common::noSqlInject($obj_Organization->email)."'".","."OrganizationTypeId=".common::noSqlInject($obj_Organization->OrganizationTypeId).","."OrganizationSubTypeId=".common::noSqlInject($obj_Organization->OrganizationSubTypeId).	        
	" WHERE  OrganizationId=".$obj_Organization->OrganizationId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Organization;
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
	
	public static function disableOrganization($OrganizationId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Organization SET Status=0 WHERE  OrganizationId=".$OrganizationId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Organization;
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
