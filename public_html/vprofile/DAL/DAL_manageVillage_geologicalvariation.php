<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_geologicalvariation
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_geologicalvariation($obj_Village_geologicalvariation)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_geologicalvariation->TblId = DAL_manageVillage_geologicalvariation::getLastVillage_geologicalvariationId()+1;
		
		 $sql = "INSERT INTO tbl_village_geologicalvariation (TblId,VillageId,Variation,Description,PrimaryGeoLayerTypeId,SoilTypeId) 
		VALUES (".
		common::noSqlInject($obj_Village_geologicalvariation->TblId).",".common::noSqlInject($obj_Village_geologicalvariation->VillageId).","."'".common::noSqlInject($obj_Village_geologicalvariation->Variation)."'".","."'".common::noSqlInject($obj_Village_geologicalvariation->Description)."'".",".common::noSqlInject($obj_Village_geologicalvariation->PrimaryGeoLayerTypeId).",".common::noSqlInject($obj_Village_geologicalvariation->SoilTypeId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_geologicalvariation;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_geologicalvariationId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(TblId) as maxId FROM  tbl_village_geologicalvariation";
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

    public static function getVillage_geologicalvariationList()
    {
    	  $db = config::dbconfig();

        $arr_Village_geologicalvariationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_geologicalvariation ORDER BY TblId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_geologicalvariation = new Village_geologicalvariation();
		$obj_Village_geologicalvariation->TblId= $row["TblId"];
		$obj_Village_geologicalvariation->VillageId= $row["VillageId"];
		$obj_Village_geologicalvariation->Variation= $row["Variation"];
		$obj_Village_geologicalvariation->Description= $row["Description"];
		$obj_Village_geologicalvariation->PrimaryGeoLayerTypeId= $row["PrimaryGeoLayerTypeId"];
		$obj_Village_geologicalvariation->SoilTypeId= $row["SoilTypeId"];

        array_push($arr_Village_geologicalvariationList, $obj_Village_geologicalvariation);
        }
		
		if(count($arr_Village_geologicalvariationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_geologicalvariationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_geologicalvariationByTblId($TblId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_geologicalvariation = new Village_geologicalvariation();
		$obj_Village_geologicalvariation->TblId = -1;
		$sql = "SELECT * FROM tbl_village_geologicalvariation WHERE TblId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_geologicalvariation->TblId= $row["TblId"];
		$obj_Village_geologicalvariation->VillageId= $row["VillageId"];
		$obj_Village_geologicalvariation->Variation= $row["Variation"];
		$obj_Village_geologicalvariation->Description= $row["Description"];
		$obj_Village_geologicalvariation->PrimaryGeoLayerTypeId= $row["PrimaryGeoLayerTypeId"];
		$obj_Village_geologicalvariation->SoilTypeId= $row["SoilTypeId"];

        }
		
		if($obj_Village_geologicalvariation->TblId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_geologicalvariation;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_geologicalvariationListByTblId($TblId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_geologicalvariationList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_geologicalvariation WHERE TblId=".$TblId." ORDER BY TblId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_geologicalvariation = new Village_geologicalvariation();
		$obj_Village_geologicalvariation->TblId= $row["TblId"];
		$obj_Village_geologicalvariation->VillageId= $row["VillageId"];
		$obj_Village_geologicalvariation->Variation= $row["Variation"];
		$obj_Village_geologicalvariation->Description= $row["Description"];
		$obj_Village_geologicalvariation->PrimaryGeoLayerTypeId= $row["PrimaryGeoLayerTypeId"];
		$obj_Village_geologicalvariation->SoilTypeId= $row["SoilTypeId"];

        array_push($arr_Village_geologicalvariationList, $obj_Village_geologicalvariation);
        }
		
		if(count($arr_Village_geologicalvariationList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_geologicalvariationList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_geologicalvariation($TblId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_geologicalvariation WHERE TblId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_geologicalvariation)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_geologicalvariation SET ". 
	"TblId=".common::noSqlInject($obj_Village_geologicalvariation->TblId).","."VillageId=".common::noSqlInject($obj_Village_geologicalvariation->VillageId).","."Variation="."'".common::noSqlInject($obj_Village_geologicalvariation->Variation)."'".","."Description="."'".common::noSqlInject($obj_Village_geologicalvariation->Description)."'".","."PrimaryGeoLayerTypeId=".common::noSqlInject($obj_Village_geologicalvariation->PrimaryGeoLayerTypeId).","."SoilTypeId=".common::noSqlInject($obj_Village_geologicalvariation->SoilTypeId).	        
	" WHERE  TblId=".$obj_Village_geologicalvariation->TblId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_geologicalvariation;
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
	
	public static function disableVillage_geologicalvariation($TblId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_geologicalvariation SET Status=0 WHERE  TblId=".$TblId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_geologicalvariation;
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
