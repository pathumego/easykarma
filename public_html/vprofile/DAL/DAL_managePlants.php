<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePlants
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPlants($obj_Plants)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Plants->PlantId = DAL_managePlants::getLastPlantsId()+1;
		
		 $sql = "INSERT INTO tbl_plants (PlantId,Name,Description,BioName) 
		VALUES (".
		common::noSqlInject($obj_Plants->PlantId).","."'".common::noSqlInject($obj_Plants->Name)."'".","."'".common::noSqlInject($obj_Plants->Description)."'".","."'".common::noSqlInject($obj_Plants->BioName)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Plants;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPlantsId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(PlantId) as maxId FROM  tbl_plants";
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

    public static function getPlantsList()
    {
    	  $db = config::dbconfig();

        $arr_PlantsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_plants ORDER BY PlantId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Plants = new Plants();
		$obj_Plants->PlantId= $row["PlantId"];
		$obj_Plants->Name= $row["Name"];
		$obj_Plants->Description= $row["Description"];
		$obj_Plants->BioName= $row["BioName"];

        array_push($arr_PlantsList, $obj_Plants);
        }
		
		if(count($arr_PlantsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_PlantsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPlantsByPlantId($PlantId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Plants = new Plants();
		$obj_Plants->PlantId = -1;
		$sql = "SELECT * FROM tbl_plants WHERE PlantId=".$PlantId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Plants->PlantId= $row["PlantId"];
		$obj_Plants->Name= $row["Name"];
		$obj_Plants->Description= $row["Description"];
		$obj_Plants->BioName= $row["BioName"];

        }
		
		if($obj_Plants->PlantId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Plants;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPlantsListByPlantId($PlantId)
    {
    		
        $db = config::dbconfig();

        $arr_PlantsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_plants WHERE PlantId=".$PlantId." ORDER BY PlantId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Plants = new Plants();
		$obj_Plants->PlantId= $row["PlantId"];
		$obj_Plants->Name= $row["Name"];
		$obj_Plants->Description= $row["Description"];
		$obj_Plants->BioName= $row["BioName"];

        array_push($arr_PlantsList, $obj_Plants);
        }
		
		if(count($arr_PlantsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_PlantsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePlants($PlantId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_plants WHERE PlantId=".$PlantId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Plants)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Plants SET ". 
	"PlantId=".common::noSqlInject($obj_Plants->PlantId).","."Name="."'".common::noSqlInject($obj_Plants->Name)."'".","."Description="."'".common::noSqlInject($obj_Plants->Description)."'".","."BioName="."'".common::noSqlInject($obj_Plants->BioName)."'".	        
	" WHERE  PlantId=".$obj_Plants->PlantId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Plants;
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
	
	public static function disablePlants($PlantId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Plants SET Status=0 WHERE  PlantId=".$PlantId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Plants;
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
