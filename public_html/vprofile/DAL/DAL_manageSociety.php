<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageSociety
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addSociety($obj_Society)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Society->SocietyId = DAL_manageSociety::getLastSocietyId()+1;
		
		 $sql = "INSERT INTO tbl_society (SocietyId,Name,Description,Mission,SocietyTypeId,SocietyAddress) 
		VALUES (".
		common::noSqlInject($obj_Society->SocietyId).","."'".common::noSqlInject($obj_Society->Name)."'".","."'".common::noSqlInject($obj_Society->Description)."'".","."'".common::noSqlInject($obj_Society->Mission)."'".",".common::noSqlInject($obj_Society->SocietyTypeId).","."'".common::noSqlInject($obj_Society->SocietyAddress)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Society;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastSocietyId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(SocietyId) as maxId FROM  tbl_society";
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

    public static function getSocietyList()
    {
    	  $db = config::dbconfig();

        $arr_SocietyList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_society ORDER BY SocietyId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Society = new Society();
		$obj_Society->SocietyId= $row["SocietyId"];
		$obj_Society->Name= $row["Name"];
		$obj_Society->Description= $row["Description"];
		$obj_Society->Mission= $row["Mission"];
		$obj_Society->SocietyTypeId= $row["SocietyTypeId"];
		$obj_Society->SocietyAddress= $row["SocietyAddress"];

        array_push($arr_SocietyList, $obj_Society);
        }
		
		if(count($arr_SocietyList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_SocietyList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getSocietyBySocietyId($SocietyId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Society = new Society();
		$obj_Society->SocietyId = -1;
		$sql = "SELECT * FROM tbl_society WHERE SocietyId=".$SocietyId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Society->SocietyId= $row["SocietyId"];
		$obj_Society->Name= $row["Name"];
		$obj_Society->Description= $row["Description"];
		$obj_Society->Mission= $row["Mission"];
		$obj_Society->SocietyTypeId= $row["SocietyTypeId"];
		$obj_Society->SocietyAddress= $row["SocietyAddress"];

        }
		
		if($obj_Society->SocietyId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Society;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getSocietyListBySocietyId($SocietyId)
    {
    		
        $db = config::dbconfig();

        $arr_SocietyList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_society WHERE SocietyId=".$SocietyId." ORDER BY SocietyId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Society = new Society();
		$obj_Society->SocietyId= $row["SocietyId"];
		$obj_Society->Name= $row["Name"];
		$obj_Society->Description= $row["Description"];
		$obj_Society->Mission= $row["Mission"];
		$obj_Society->SocietyTypeId= $row["SocietyTypeId"];
		$obj_Society->SocietyAddress= $row["SocietyAddress"];

        array_push($arr_SocietyList, $obj_Society);
        }
		
		if(count($arr_SocietyList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_SocietyList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteSociety($SocietyId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_society WHERE SocietyId=".$SocietyId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Society)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Society SET ". 
	"SocietyId=".common::noSqlInject($obj_Society->SocietyId).","."Name="."'".common::noSqlInject($obj_Society->Name)."'".","."Description="."'".common::noSqlInject($obj_Society->Description)."'".","."Mission="."'".common::noSqlInject($obj_Society->Mission)."'".","."SocietyTypeId=".common::noSqlInject($obj_Society->SocietyTypeId).","."SocietyAddress="."'".common::noSqlInject($obj_Society->SocietyAddress)."'".	        
	" WHERE  SocietyId=".$obj_Society->SocietyId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Society;
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
	
	public static function disableSociety($SocietyId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Society SET Status=0 WHERE  SocietyId=".$SocietyId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Society;
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
