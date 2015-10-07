<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_organization
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_organization($obj_Village_organization)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_organization->VillageId = DAL_manageVillage_organization::getLastVillage_organizationId()+1;
		
		 $sql = "INSERT INTO tbl_village_organization (OrganizationId,VillageId) 
		VALUES (".
		common::noSqlInject($obj_Village_organization->OrganizationId).",".common::noSqlInject($obj_Village_organization->VillageId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_organization;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_organizationId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(VillageId) as maxId FROM  tbl_village_organization";
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

    public static function getVillage_organizationList()
    {
    	  $db = config::dbconfig();

        $arr_Village_organizationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_organization ORDER BY VillageId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_organization = new Village_organization();
		$obj_Village_organization->OrganizationId= $row["OrganizationId"];
		$obj_Village_organization->VillageId= $row["VillageId"];

        array_push($arr_Village_organizationList, $obj_Village_organization);
        }
		
		if(count($arr_Village_organizationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_organizationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_organizationByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_organization = new Village_organization();
		$obj_Village_organization->VillageId = -1;
		$sql = "SELECT * FROM tbl_village_organization WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_organization->OrganizationId= $row["OrganizationId"];
		$obj_Village_organization->VillageId= $row["VillageId"];

        }
		
		if($obj_Village_organization->VillageId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_organization;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_organizationListByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_organizationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_organization WHERE VillageId=".$VillageId." ORDER BY VillageId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_organization = new Village_organization();
		$obj_Village_organization->OrganizationId= $row["OrganizationId"];
		$obj_Village_organization->VillageId= $row["VillageId"];

        array_push($arr_Village_organizationList, $obj_Village_organization);
        }
		
		if(count($arr_Village_organizationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_organizationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_organization($VillageId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_organization WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_organization)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_organization SET ". 
	"OrganizationId=".common::noSqlInject($obj_Village_organization->OrganizationId).","."VillageId=".common::noSqlInject($obj_Village_organization->VillageId).	        
	" WHERE  VillageId=".$obj_Village_organization->VillageId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_organization;
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
	
	public static function disableVillage_organization($VillageId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_organization SET Status=0 WHERE  VillageId=".$VillageId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_organization;
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
