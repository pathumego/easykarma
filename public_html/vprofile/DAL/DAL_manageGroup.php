<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageGroup
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addGroup($obj_Group)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Group->GroupId = DAL_manageGroup::getLastGroupId()+1;
		
		 $sql = "INSERT INTO tbl_group (GroupId,GroupName,GroupPrimaryType,GroupMissionTypeId,GroupAddress) 
		VALUES (".
		common::noSqlInject($obj_Group->GroupId).","."'".common::noSqlInject($obj_Group->GroupName)."'".",".common::noSqlInject($obj_Group->GroupPrimaryType).",".common::noSqlInject($obj_Group->GroupMissionTypeId).","."'".common::noSqlInject($obj_Group->GroupAddress)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Group;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastGroupId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(GroupId) as maxId FROM  tbl_group";
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

    public static function getGroupList()
    {
    	  $db = config::dbconfig();

        $arr_GroupList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_group ORDER BY GroupId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Group = new Group();
		$obj_Group->GroupId= $row["GroupId"];
		$obj_Group->GroupName= $row["GroupName"];
		$obj_Group->GroupPrimaryType= $row["GroupPrimaryType"];
		$obj_Group->GroupMissionTypeId= $row["GroupMissionTypeId"];
		$obj_Group->GroupAddress= $row["GroupAddress"];

        array_push($arr_GroupList, $obj_Group);
        }
		
		if(count($arr_GroupList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_GroupList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getGroupByGroupId($GroupId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Group = new Group();
		$obj_Group->GroupId = -1;
		$sql = "SELECT * FROM tbl_group WHERE GroupId=".$GroupId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Group->GroupId= $row["GroupId"];
		$obj_Group->GroupName= $row["GroupName"];
		$obj_Group->GroupPrimaryType= $row["GroupPrimaryType"];
		$obj_Group->GroupMissionTypeId= $row["GroupMissionTypeId"];
		$obj_Group->GroupAddress= $row["GroupAddress"];

        }
		
		if($obj_Group->GroupId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Group;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getGroupListByGroupId($GroupId)
    {
    		
        $db = config::dbconfig();

        $arr_GroupList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_group WHERE GroupId=".$GroupId." ORDER BY GroupId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Group = new Group();
		$obj_Group->GroupId= $row["GroupId"];
		$obj_Group->GroupName= $row["GroupName"];
		$obj_Group->GroupPrimaryType= $row["GroupPrimaryType"];
		$obj_Group->GroupMissionTypeId= $row["GroupMissionTypeId"];
		$obj_Group->GroupAddress= $row["GroupAddress"];

        array_push($arr_GroupList, $obj_Group);
        }
		
		if(count($arr_GroupList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_GroupList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteGroup($GroupId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_group WHERE GroupId=".$GroupId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Group)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_group SET ". 
	"GroupId=".common::noSqlInject($obj_Group->GroupId).","."GroupName="."'".common::noSqlInject($obj_Group->GroupName)."'".","."GroupPrimaryType=".common::noSqlInject($obj_Group->GroupPrimaryType).","."GroupMissionTypeId=".common::noSqlInject($obj_Group->GroupMissionTypeId).","."GroupAddress="."'".common::noSqlInject($obj_Group->GroupAddress)."'".	        
	" WHERE  GroupId=".$obj_Group->GroupId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Group;
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
	
	public static function disableGroup($GroupId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_group SET Status=0 WHERE  GroupId=".$GroupId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Group;
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
