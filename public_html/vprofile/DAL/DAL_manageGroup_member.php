<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageGroup_member
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addGroup_member($obj_Group_member)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Group_member->MemberId = DAL_manageGroup_member::getLastGroup_memberId()+1;
		
		 $sql = "INSERT INTO tbl_group_member (GroupId,MemberId,MemberType,MemberDate,Description) 
		VALUES (".
		common::noSqlInject($obj_Group_member->GroupId).",".common::noSqlInject($obj_Group_member->MemberId).","."'".common::noSqlInject($obj_Group_member->MemberType)."'".","."'".common::noSqlInject($obj_Group_member->MemberDate)."'".","."'".common::noSqlInject($obj_Group_member->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Group_member;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastGroup_memberId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(MemberId) as maxId FROM  tbl_group_member";
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

    public static function getGroup_memberList()
    {
    	  $db = config::dbconfig();

        $arr_Group_memberList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_group_member ORDER BY MemberId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Group_member = new Group_member();
		$obj_Group_member->GroupId= $row["GroupId"];
		$obj_Group_member->MemberId= $row["MemberId"];
		$obj_Group_member->MemberType= $row["MemberType"];
		$obj_Group_member->MemberDate= $row["MemberDate"];
		$obj_Group_member->Description= $row["Description"];

        array_push($arr_Group_memberList, $obj_Group_member);
        }
		
		if(count($arr_Group_memberList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Group_memberList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getGroup_memberByMemberId($MemberId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Group_member = new Group_member();
		$obj_Group_member->MemberId = -1;
		$sql = "SELECT * FROM tbl_group_member WHERE MemberId=".$MemberId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Group_member->GroupId= $row["GroupId"];
		$obj_Group_member->MemberId= $row["MemberId"];
		$obj_Group_member->MemberType= $row["MemberType"];
		$obj_Group_member->MemberDate= $row["MemberDate"];
		$obj_Group_member->Description= $row["Description"];

        }
		
		if($obj_Group_member->MemberId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Group_member;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getGroup_memberListByMemberId($MemberId)
    {
    		
        $db = config::dbconfig();

        $arr_Group_memberList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_group_member WHERE MemberId=".$MemberId." ORDER BY MemberId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Group_member = new Group_member();
		$obj_Group_member->GroupId= $row["GroupId"];
		$obj_Group_member->MemberId= $row["MemberId"];
		$obj_Group_member->MemberType= $row["MemberType"];
		$obj_Group_member->MemberDate= $row["MemberDate"];
		$obj_Group_member->Description= $row["Description"];

        array_push($arr_Group_memberList, $obj_Group_member);
        }
		
		if(count($arr_Group_memberList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Group_memberList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteGroup_member($MemberId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_group_member WHERE MemberId=".$MemberId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Group_member)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_group_member SET ". 
	"GroupId=".common::noSqlInject($obj_Group_member->GroupId).","."MemberId=".common::noSqlInject($obj_Group_member->MemberId).","."MemberType="."'".common::noSqlInject($obj_Group_member->MemberType)."'".","."MemberDate="."'".common::noSqlInject($obj_Group_member->MemberDate)."'".","."Description="."'".common::noSqlInject($obj_Group_member->Description)."'".	        
	" WHERE  MemberId=".$obj_Group_member->MemberId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Group_member;
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
	
	public static function disableGroup_member($MemberId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_group_member SET Status=0 WHERE  MemberId=".$MemberId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Group_member;
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
