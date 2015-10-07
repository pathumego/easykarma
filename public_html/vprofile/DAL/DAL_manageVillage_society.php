<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_society
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_society($obj_Village_society)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_society->VillageSocietyId = DAL_manageVillage_society::getLastVillage_societyId()+1;
		
		 $sql = "INSERT INTO tbl_village_society (SocietyId,VillageId,VillageSocietyId) 
		VALUES (".
		common::noSqlInject($obj_Village_society->SocietyId).",".common::noSqlInject($obj_Village_society->VillageId).",".common::noSqlInject($obj_Village_society->VillageSocietyId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_society;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_societyId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(VillageSocietyId) as maxId FROM  tbl_village_society";
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

    public static function getVillage_societyList()
    {
    	  $db = config::dbconfig();

        $arr_Village_societyList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_society ORDER BY VillageSocietyId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_society = new Village_society();
		$obj_Village_society->SocietyId= $row["SocietyId"];
		$obj_Village_society->VillageId= $row["VillageId"];
		$obj_Village_society->VillageSocietyId= $row["VillageSocietyId"];

        array_push($arr_Village_societyList, $obj_Village_society);
        }
		
		if(count($arr_Village_societyList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_societyList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_societyByVillageSocietyId($VillageSocietyId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_society = new Village_society();
		$obj_Village_society->VillageSocietyId = -1;
		$sql = "SELECT * FROM tbl_village_society WHERE VillageSocietyId=".$VillageSocietyId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_society->SocietyId= $row["SocietyId"];
		$obj_Village_society->VillageId= $row["VillageId"];
		$obj_Village_society->VillageSocietyId= $row["VillageSocietyId"];

        }
		
		if($obj_Village_society->VillageSocietyId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_society;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_societyListByVillageSocietyId($VillageSocietyId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_societyList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_society WHERE VillageSocietyId=".$VillageSocietyId." ORDER BY VillageSocietyId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_society = new Village_society();
		$obj_Village_society->SocietyId= $row["SocietyId"];
		$obj_Village_society->VillageId= $row["VillageId"];
		$obj_Village_society->VillageSocietyId= $row["VillageSocietyId"];

        array_push($arr_Village_societyList, $obj_Village_society);
        }
		
		if(count($arr_Village_societyList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_societyList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_society($VillageSocietyId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_society WHERE VillageSocietyId=".$VillageSocietyId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_society)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_society SET ". 
	"SocietyId=".common::noSqlInject($obj_Village_society->SocietyId).","."VillageId=".common::noSqlInject($obj_Village_society->VillageId).","."VillageSocietyId=".common::noSqlInject($obj_Village_society->VillageSocietyId).	        
	" WHERE  VillageSocietyId=".$obj_Village_society->VillageSocietyId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_society;
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
	
	public static function disableVillage_society($VillageSocietyId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_society SET Status=0 WHERE  VillageSocietyId=".$VillageSocietyId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_society;
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
