<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_property
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_property($obj_Person_property)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_property->PropertyId = DAL_managePerson_property::getLastPerson_propertyId()+1;
		
		 $sql = "INSERT INTO tbl_person_property (PropertyId,PropertyName,PropertyType,AssessValue,Description) 
		VALUES (".
		common::noSqlInject($obj_Person_property->PropertyId).","."'".common::noSqlInject($obj_Person_property->PropertyName)."'".",".common::noSqlInject($obj_Person_property->PropertyType).",".common::noSqlInject($obj_Person_property->AssessValue).","."'".common::noSqlInject($obj_Person_property->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_property;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_propertyId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(PropertyId) as maxId FROM  tbl_person_property";
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

    public static function getPerson_propertyList()
    {
    	  $db = config::dbconfig();

        $arr_Person_propertyList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_property ORDER BY PropertyId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_property = new Person_property();
		$obj_Person_property->PropertyId= $row["PropertyId"];
		$obj_Person_property->PropertyName= $row["PropertyName"];
		$obj_Person_property->PropertyType= $row["PropertyType"];
		$obj_Person_property->AssessValue= $row["AssessValue"];
		$obj_Person_property->Description= $row["Description"];

        array_push($arr_Person_propertyList, $obj_Person_property);
        }
		
		if(count($arr_Person_propertyList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_propertyList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_propertyByPropertyId($PropertyId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_property = new Person_property();
		$obj_Person_property->PropertyId = -1;
		$sql = "SELECT * FROM tbl_person_property WHERE PropertyId=".$PropertyId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_property->PropertyId= $row["PropertyId"];
		$obj_Person_property->PropertyName= $row["PropertyName"];
		$obj_Person_property->PropertyType= $row["PropertyType"];
		$obj_Person_property->AssessValue= $row["AssessValue"];
		$obj_Person_property->Description= $row["Description"];

        }
		
		if($obj_Person_property->PropertyId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_property;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_propertyListByPropertyId($PropertyId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_propertyList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_property WHERE PropertyId=".$PropertyId." ORDER BY PropertyId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_property = new Person_property();
		$obj_Person_property->PropertyId= $row["PropertyId"];
		$obj_Person_property->PropertyName= $row["PropertyName"];
		$obj_Person_property->PropertyType= $row["PropertyType"];
		$obj_Person_property->AssessValue= $row["AssessValue"];
		$obj_Person_property->Description= $row["Description"];

        array_push($arr_Person_propertyList, $obj_Person_property);
        }
		
		if(count($arr_Person_propertyList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_propertyList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deletePerson_property($PropertyId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_property WHERE PropertyId=".$PropertyId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_property)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_property SET ". 
	"PropertyId=".common::noSqlInject($obj_Person_property->PropertyId).","."PropertyName="."'".common::noSqlInject($obj_Person_property->PropertyName)."'".","."PropertyType=".common::noSqlInject($obj_Person_property->PropertyType).","."AssessValue=".common::noSqlInject($obj_Person_property->AssessValue).","."Description="."'".common::noSqlInject($obj_Person_property->Description)."'".	        
	" WHERE  PropertyId=".$obj_Person_property->PropertyId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_property;
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
	
	public static function disablePerson_property($PropertyId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_property SET Status=0 WHERE  PropertyId=".$PropertyId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_property;
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
