<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_traditionalknowledge
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_traditionalknowledge($obj_Village_traditionalknowledge)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_traditionalknowledge->TblId = DAL_manageVillage_traditionalknowledge::getLastVillage_traditionalknowledgeId()+1;
		
		 $sql = "INSERT INTO tbl_village_traditionalknowledge (TblId,VillageId,TraditionalKnowledgeCategoryID,Discription) 
		VALUES (".
		common::noSqlInject($obj_Village_traditionalknowledge->TblId).",".common::noSqlInject($obj_Village_traditionalknowledge->VillageId).",".common::noSqlInject($obj_Village_traditionalknowledge->TraditionalKnowledgeCategoryID).","."'".common::noSqlInject($obj_Village_traditionalknowledge->Discription)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_traditionalknowledge;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_traditionalknowledgeId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(TblId) as maxId FROM  tbl_village_traditionalknowledge";
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

    public static function getVillage_traditionalknowledgeList()
    {
    	  $db = config::dbconfig();

        $arr_Village_traditionalknowledgeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_traditionalknowledge ORDER BY TblId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_traditionalknowledge = new Village_traditionalknowledge();
		$obj_Village_traditionalknowledge->TblId= $row["TblId"];
		$obj_Village_traditionalknowledge->VillageId= $row["VillageId"];
		$obj_Village_traditionalknowledge->TraditionalKnowledgeCategoryID= $row["TraditionalKnowledgeCategoryID"];
		$obj_Village_traditionalknowledge->Discription= $row["Discription"];

        array_push($arr_Village_traditionalknowledgeList, $obj_Village_traditionalknowledge);
        }
		
		if(count($arr_Village_traditionalknowledgeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_traditionalknowledgeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_traditionalknowledgeByTblId($TblId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_traditionalknowledge = new Village_traditionalknowledge();
		$obj_Village_traditionalknowledge->TblId = -1;
		$sql = "SELECT * FROM tbl_village_traditionalknowledge WHERE TblId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_traditionalknowledge->TblId= $row["TblId"];
		$obj_Village_traditionalknowledge->VillageId= $row["VillageId"];
		$obj_Village_traditionalknowledge->TraditionalKnowledgeCategoryID= $row["TraditionalKnowledgeCategoryID"];
		$obj_Village_traditionalknowledge->Discription= $row["Discription"];

        }
		
		if($obj_Village_traditionalknowledge->TblId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_traditionalknowledge;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_traditionalknowledgeListByTblId($TblId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_traditionalknowledgeList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_traditionalknowledge WHERE TblId=".$TblId." ORDER BY TblId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_traditionalknowledge = new Village_traditionalknowledge();
		$obj_Village_traditionalknowledge->TblId= $row["TblId"];
		$obj_Village_traditionalknowledge->VillageId= $row["VillageId"];
		$obj_Village_traditionalknowledge->TraditionalKnowledgeCategoryID= $row["TraditionalKnowledgeCategoryID"];
		$obj_Village_traditionalknowledge->Discription= $row["Discription"];

        array_push($arr_Village_traditionalknowledgeList, $obj_Village_traditionalknowledge);
        }
		
		if(count($arr_Village_traditionalknowledgeList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_traditionalknowledgeList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_traditionalknowledge($TblId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_traditionalknowledge WHERE TblId=".$TblId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_traditionalknowledge)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_traditionalknowledge SET ". 
	"TblId=".common::noSqlInject($obj_Village_traditionalknowledge->TblId).","."VillageId=".common::noSqlInject($obj_Village_traditionalknowledge->VillageId).","."TraditionalKnowledgeCategoryID=".common::noSqlInject($obj_Village_traditionalknowledge->TraditionalKnowledgeCategoryID).","."Discription="."'".common::noSqlInject($obj_Village_traditionalknowledge->Discription)."'".	        
	" WHERE  TblId=".$obj_Village_traditionalknowledge->TblId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_traditionalknowledge;
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
	
	public static function disableVillage_traditionalknowledge($TblId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_traditionalknowledge SET Status=0 WHERE  TblId=".$TblId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_traditionalknowledge;
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
