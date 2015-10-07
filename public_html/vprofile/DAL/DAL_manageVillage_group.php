<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_group
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_group($obj_Village_group)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_group->VillageId = DAL_manageVillage_group::getLastVillage_groupId()+1;
		
		 $sql = "INSERT INTO tbl_village_group (GroupId,VillageId) 
		VALUES (".
		common::noSqlInject($obj_Village_group->GroupId).","."'".common::noSqlInject($obj_Village_group->VillageId)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_group;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_groupId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(VillageId) as maxId FROM  tbl_village_group";
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

    public static function getVillage_groupList()
    {
    	  $db = config::dbconfig();

        $arr_Village_groupList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_group ORDER BY VillageId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_group = new Village_group();
		$obj_Village_group->GroupId= $row["GroupId"];
		$obj_Village_group->VillageId= $row["VillageId"];

        array_push($arr_Village_groupList, $obj_Village_group);
        }
		
		if(count($arr_Village_groupList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_groupList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_groupByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_group = new Village_group();
		$obj_Village_group->VillageId = -1;
		$sql = "SELECT * FROM tbl_village_group WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_group->GroupId= $row["GroupId"];
		$obj_Village_group->VillageId= $row["VillageId"];

        }
		
		if($obj_Village_group->VillageId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_group;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_groupListByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_groupList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_group WHERE VillageId=".$VillageId." ORDER BY VillageId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_group = new Village_group();
		$obj_Village_group->GroupId= $row["GroupId"];
		$obj_Village_group->VillageId= $row["VillageId"];

        array_push($arr_Village_groupList, $obj_Village_group);
        }
		
		if(count($arr_Village_groupList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_groupList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_group($VillageId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_group WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_group)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_group SET ". 
	"GroupId=".common::noSqlInject($obj_Village_group->GroupId).","."VillageId="."'".common::noSqlInject($obj_Village_group->VillageId)."'".	        
	" WHERE  VillageId=".$obj_Village_group->VillageId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_group;
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
	
	public static function disableVillage_group($VillageId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_group SET Status=0 WHERE  VillageId=".$VillageId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_group;
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
