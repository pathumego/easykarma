<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_enterance
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_enterance($obj_Village_enterance)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_enterance->TblId = DAL_manageVillage_enterance::getLastVillage_enteranceId()+1;
		
		 $sql = "INSERT INTO tbl_village_enterance (TblId,VillageId,Direction,Description) 
		VALUES (".
		common::noSqlInject($obj_Village_enterance->TblId).",".common::noSqlInject($obj_Village_enterance->VillageId).","."'".common::noSqlInject($obj_Village_enterance->Direction)."'".","."'".common::noSqlInject($obj_Village_enterance->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_enterance;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_enteranceId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(TblId) as maxId FROM  tbl_village_enterance";
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

    public static function getVillage_enteranceList()
    {
    	  $db = config::dbconfig();

        $arr_Village_enteranceList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_enterance ORDER BY TblId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_enterance = new Village_enterance();
		$obj_Village_enterance->TblId= $row["TblId"];
		$obj_Village_enterance->VillageId= $row["VillageId"];
		$obj_Village_enterance->Direction= $row["Direction"];
		$obj_Village_enterance->Description= $row["Description"];

        array_push($arr_Village_enteranceList, $obj_Village_enterance);
        }
		
		if(count($arr_Village_enteranceList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_enteranceList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_enteranceByTblId($TblId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_enterance = new Village_enterance();
		$obj_Village_enterance->TblId = -1;
		$sql = "SELECT * FROM tbl_village_enterance WHERE TblId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_enterance->TblId= $row["TblId"];
		$obj_Village_enterance->VillageId= $row["VillageId"];
		$obj_Village_enterance->Direction= $row["Direction"];
		$obj_Village_enterance->Description= $row["Description"];

        }
		
		if($obj_Village_enterance->TblId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_enterance;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_enteranceListByTblId($TblId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_enteranceList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_enterance WHERE TblId=".$TblId." ORDER BY TblId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_enterance = new Village_enterance();
		$obj_Village_enterance->TblId= $row["TblId"];
		$obj_Village_enterance->VillageId= $row["VillageId"];
		$obj_Village_enterance->Direction= $row["Direction"];
		$obj_Village_enterance->Description= $row["Description"];

        array_push($arr_Village_enteranceList, $obj_Village_enterance);
        }
		
		if(count($arr_Village_enteranceList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_enteranceList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_enterance($TblId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_enterance WHERE TblId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_enterance)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_enterance SET ". 
	"TblId=".common::noSqlInject($obj_Village_enterance->TblId).","."VillageId=".common::noSqlInject($obj_Village_enterance->VillageId).","."Direction="."'".common::noSqlInject($obj_Village_enterance->Direction)."'".","."Description="."'".common::noSqlInject($obj_Village_enterance->Description)."'".	        
	" WHERE  TblId=".$obj_Village_enterance->TblId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_enterance;
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
	
	public static function disableVillage_enterance($TblId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_enterance SET Status=0 WHERE  TblId=".$TblId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_enterance;
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
