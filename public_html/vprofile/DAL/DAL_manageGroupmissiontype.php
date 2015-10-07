<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageGroupmissiontype
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addGroupmissiontype($obj_Groupmissiontype)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Groupmissiontype->GroupMissionTypeId = DAL_manageGroupmissiontype::getLastGroupmissiontypeId()+1;
		
		 $sql = "INSERT INTO tbl_groupmissiontype (GroupMissionTypeId,GroupMissionTypeName,Description) 
		VALUES (".
		common::noSqlInject($obj_Groupmissiontype->GroupMissionTypeId).","."'".common::noSqlInject($obj_Groupmissiontype->GroupMissionTypeName)."'".","."'".common::noSqlInject($obj_Groupmissiontype->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Groupmissiontype;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastGroupmissiontypeId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(GroupMissionTypeId) as maxId FROM  tbl_groupmissiontype";
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

    public static function getGroupmissiontypeList()
    {
    	  $db = config::dbconfig();

        $arr_GroupmissiontypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_groupmissiontype ORDER BY GroupMissionTypeId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Groupmissiontype = new Groupmissiontype();
		$obj_Groupmissiontype->GroupMissionTypeId= $row["GroupMissionTypeId"];
		$obj_Groupmissiontype->GroupMissionTypeName= $row["GroupMissionTypeName"];
		$obj_Groupmissiontype->Description= $row["Description"];

        array_push($arr_GroupmissiontypeList, $obj_Groupmissiontype);
        }
		
		if(count($arr_GroupmissiontypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_GroupmissiontypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getGroupmissiontypeByGroupMissionTypeId($GroupMissionTypeId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Groupmissiontype = new Groupmissiontype();
		$obj_Groupmissiontype->GroupMissionTypeId = -1;
		$sql = "SELECT * FROM tbl_groupmissiontype WHERE GroupMissionTypeId=".$GroupMissionTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Groupmissiontype->GroupMissionTypeId= $row["GroupMissionTypeId"];
		$obj_Groupmissiontype->GroupMissionTypeName= $row["GroupMissionTypeName"];
		$obj_Groupmissiontype->Description= $row["Description"];

        }
		
		if($obj_Groupmissiontype->GroupMissionTypeId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Groupmissiontype;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getGroupmissiontypeListByGroupMissionTypeId($GroupMissionTypeId)
    {
    		
        $db = config::dbconfig();

        $arr_GroupmissiontypeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_groupmissiontype WHERE GroupMissionTypeId=".$GroupMissionTypeId." ORDER BY GroupMissionTypeId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Groupmissiontype = new Groupmissiontype();
		$obj_Groupmissiontype->GroupMissionTypeId= $row["GroupMissionTypeId"];
		$obj_Groupmissiontype->GroupMissionTypeName= $row["GroupMissionTypeName"];
		$obj_Groupmissiontype->Description= $row["Description"];

        array_push($arr_GroupmissiontypeList, $obj_Groupmissiontype);
        }
		
		if(count($arr_GroupmissiontypeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_GroupmissiontypeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteGroupmissiontype($GroupMissionTypeId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_groupmissiontype WHERE GroupMissionTypeId=".$GroupMissionTypeId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Groupmissiontype)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_groupmissiontype SET ". 
	"GroupMissionTypeId=".common::noSqlInject($obj_Groupmissiontype->GroupMissionTypeId).","."GroupMissionTypeName="."'".common::noSqlInject($obj_Groupmissiontype->GroupMissionTypeName)."'".","."Description="."'".common::noSqlInject($obj_Groupmissiontype->Description)."'".	        
	" WHERE  GroupMissionTypeId=".$obj_Groupmissiontype->GroupMissionTypeId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Groupmissiontype;
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
	
	public static function disableGroupmissiontype($GroupMissionTypeId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_groupmissiontype SET Status=0 WHERE  GroupMissionTypeId=".$GroupMissionTypeId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Groupmissiontype;
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
