<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage($obj_Village)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village->VillageId = DAL_manageVillage::getLastVillageId()+1;
		
		 $sql = "INSERT INTO tbl_village (VillageId,Name,VillageNumber,AgaDevision,District,Province,GeogrophyTypeId,ForestTypeId,ForestDescription,TraditionalKnowledge) 
		VALUES (".
		common::noSqlInject($obj_Village->VillageId).","."'".common::noSqlInject($obj_Village->Name)."'".",".common::noSqlInject($obj_Village->VillageNumber).","."'".common::noSqlInject($obj_Village->AgaDevision)."'".","."'".common::noSqlInject($obj_Village->District)."'".","."'".common::noSqlInject($obj_Village->Province)."'".",".common::noSqlInject($obj_Village->GeogrophyTypeId).",".common::noSqlInject($obj_Village->ForestTypeId).","."'".common::noSqlInject($obj_Village->ForestDescription)."'".","."'".common::noSqlInject($obj_Village->TraditionalKnowledge)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillageId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(VillageId) as maxId FROM  tbl_village";
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

    public static function getVillageList()
    {
    	  $db = config::dbconfig();

        $arr_VillageList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village ORDER BY VillageId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village = new Village();
		$obj_Village->VillageId= $row["VillageId"];
		$obj_Village->Name= $row["Name"];
		$obj_Village->VillageNumber= $row["VillageNumber"];
		$obj_Village->AgaDevision= $row["AgaDevision"];
		$obj_Village->District= $row["District"];
		$obj_Village->Province= $row["Province"];
		$obj_Village->GeogrophyTypeId= $row["GeogrophyTypeId"];
		$obj_Village->ForestTypeId= $row["ForestTypeId"];
		$obj_Village->ForestDescription= $row["ForestDescription"];
		$obj_Village->TraditionalKnowledge= $row["TraditionalKnowledge"];

        array_push($arr_VillageList, $obj_Village);
        }
		
		if(count($arr_VillageList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_VillageList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillageByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village = new Village();
		$obj_Village->VillageId = -1;
		$sql = "SELECT * FROM tbl_village WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village->VillageId= $row["VillageId"];
		$obj_Village->Name= $row["Name"];
		$obj_Village->VillageNumber= $row["VillageNumber"];
		$obj_Village->AgaDevision= $row["AgaDevision"];
		$obj_Village->District= $row["District"];
		$obj_Village->Province= $row["Province"];
		$obj_Village->GeogrophyTypeId= $row["GeogrophyTypeId"];
		$obj_Village->ForestTypeId= $row["ForestTypeId"];
		$obj_Village->ForestDescription= $row["ForestDescription"];
		$obj_Village->TraditionalKnowledge= $row["TraditionalKnowledge"];

        }
		
		if($obj_Village->VillageId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillageListByVillageId($VillageId)
    {
    		
        $db = config::dbconfig();

        $arr_VillageList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village WHERE VillageId=".$VillageId." ORDER BY VillageId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village = new Village();
		$obj_Village->VillageId= $row["VillageId"];
		$obj_Village->Name= $row["Name"];
		$obj_Village->VillageNumber= $row["VillageNumber"];
		$obj_Village->AgaDevision= $row["AgaDevision"];
		$obj_Village->District= $row["District"];
		$obj_Village->Province= $row["Province"];
		$obj_Village->GeogrophyTypeId= $row["GeogrophyTypeId"];
		$obj_Village->ForestTypeId= $row["ForestTypeId"];
		$obj_Village->ForestDescription= $row["ForestDescription"];
		$obj_Village->TraditionalKnowledge= $row["TraditionalKnowledge"];

        array_push($arr_VillageList, $obj_Village);
        }
		
		if(count($arr_VillageList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_VillageList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage($VillageId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village WHERE VillageId=".$VillageId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village SET ". 
	"VillageId=".common::noSqlInject($obj_Village->VillageId).","."Name="."'".common::noSqlInject($obj_Village->Name)."'".","."VillageNumber=".common::noSqlInject($obj_Village->VillageNumber).","."AgaDevision="."'".common::noSqlInject($obj_Village->AgaDevision)."'".","."District="."'".common::noSqlInject($obj_Village->District)."'".","."Province="."'".common::noSqlInject($obj_Village->Province)."'".","."GeogrophyTypeId=".common::noSqlInject($obj_Village->GeogrophyTypeId).","."ForestTypeId=".common::noSqlInject($obj_Village->ForestTypeId).","."ForestDescription="."'".common::noSqlInject($obj_Village->ForestDescription)."'".","."TraditionalKnowledge="."'".common::noSqlInject($obj_Village->TraditionalKnowledge)."'".	        
	" WHERE  VillageId=".$obj_Village->VillageId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village;
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
	
	public static function disableVillage($VillageId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village SET Status=0 WHERE  VillageId=".$VillageId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village;
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
