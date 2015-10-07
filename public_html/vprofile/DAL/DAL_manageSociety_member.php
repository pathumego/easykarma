<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageSociety_member
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addSociety_member($obj_Society_member)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Society_member->MemberId = DAL_manageSociety_member::getLastSociety_memberId()+1;
		
		 $sql = "INSERT INTO tbl_society_member (VillageSocietyId,MemberId,MemberType,MemberDate,Description) 
		VALUES (".
		common::noSqlInject($obj_Society_member->VillageSocietyId).",".common::noSqlInject($obj_Society_member->MemberId).","."'".common::noSqlInject($obj_Society_member->MemberType)."'".","."'".common::noSqlInject($obj_Society_member->MemberDate)."'".","."'".common::noSqlInject($obj_Society_member->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Society_member;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastSociety_memberId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(MemberId) as maxId FROM  tbl_society_member";
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

    public static function getSociety_memberList()
    {
    	  $db = config::dbconfig();

        $arr_Society_memberList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_society_member ORDER BY MemberId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Society_member = new Society_member();
		$obj_Society_member->VillageSocietyId= $row["VillageSocietyId"];
		$obj_Society_member->MemberId= $row["MemberId"];
		$obj_Society_member->MemberType= $row["MemberType"];
		$obj_Society_member->MemberDate= $row["MemberDate"];
		$obj_Society_member->Description= $row["Description"];

        array_push($arr_Society_memberList, $obj_Society_member);
        }
		
		if(count($arr_Society_memberList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Society_memberList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getSociety_memberByMemberId($MemberId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Society_member = new Society_member();
		$obj_Society_member->MemberId = -1;
		$sql = "SELECT * FROM tbl_society_member WHERE MemberId=".$MemberId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Society_member->VillageSocietyId= $row["VillageSocietyId"];
		$obj_Society_member->MemberId= $row["MemberId"];
		$obj_Society_member->MemberType= $row["MemberType"];
		$obj_Society_member->MemberDate= $row["MemberDate"];
		$obj_Society_member->Description= $row["Description"];

        }
		
		if($obj_Society_member->MemberId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Society_member;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getSociety_memberListByMemberId($MemberId)
    {
    		
        $db = config::dbconfig();

        $arr_Society_memberList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_society_member WHERE MemberId=".$MemberId." ORDER BY MemberId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Society_member = new Society_member();
		$obj_Society_member->VillageSocietyId= $row["VillageSocietyId"];
		$obj_Society_member->MemberId= $row["MemberId"];
		$obj_Society_member->MemberType= $row["MemberType"];
		$obj_Society_member->MemberDate= $row["MemberDate"];
		$obj_Society_member->Description= $row["Description"];

        array_push($arr_Society_memberList, $obj_Society_member);
        }
		
		if(count($arr_Society_memberList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Society_memberList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteSociety_member($MemberId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_society_member WHERE MemberId=".$MemberId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Society_member)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Society_member SET ". 
	"VillageSocietyId=".common::noSqlInject($obj_Society_member->VillageSocietyId).","."MemberId=".common::noSqlInject($obj_Society_member->MemberId).","."MemberType="."'".common::noSqlInject($obj_Society_member->MemberType)."'".","."MemberDate="."'".common::noSqlInject($obj_Society_member->MemberDate)."'".","."Description="."'".common::noSqlInject($obj_Society_member->Description)."'".	        
	" WHERE  MemberId=".$obj_Society_member->MemberId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Society_member;
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
	
	public static function disableSociety_member($MemberId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Society_member SET Status=0 WHERE  MemberId=".$MemberId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Society_member;
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
