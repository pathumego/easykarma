<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_managePerson_address
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addPerson_address($obj_Person_address)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Person_address->AddressId = DAL_managePerson_address::getLastPerson_addressId()+1;
		
		 $sql = "INSERT INTO tbl_person_address (AddressId,Address,AddressType,VillageId,PersonId) 
		VALUES (".
		common::noSqlInject($obj_Person_address->AddressId).","."'".common::noSqlInject($obj_Person_address->Address)."'".",".common::noSqlInject($obj_Person_address->AddressType).",".common::noSqlInject($obj_Person_address->VillageId).",".common::noSqlInject($obj_Person_address->PersonId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Person_address;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastPerson_addressId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(AddressId) as maxId FROM  tbl_person_address";
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

    public static function getPerson_addressList()
    {
    	  $db = config::dbconfig();

        $arr_Person_addressList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_address ORDER BY AddressId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_address = new Person_address();
		$obj_Person_address->AddressId= $row["AddressId"];
		$obj_Person_address->Address= $row["Address"];
		$obj_Person_address->AddressType= $row["AddressType"];
		$obj_Person_address->VillageId= $row["VillageId"];
		$obj_Person_address->PersonId= $row["PersonId"];

        array_push($arr_Person_addressList, $obj_Person_address);
        }
		
		if(count($arr_Person_addressList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_addressList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_addressByAddressId($AddressId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Person_address = new Person_address();
		$sql = "SELECT * FROM tbl_person_address WHERE AddressId=".$AddressId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Person_address->AddressId= $row["AddressId"];
		$obj_Person_address->Address= $row["Address"];
		$obj_Person_address->AddressType= $row["AddressType"];
		$obj_Person_address->VillageId= $row["VillageId"];
		$obj_Person_address->PersonId= $row["PersonId"];

        }
		
		if(count($arr_Person_addressList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_address;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_addressListByPersonId($PersonId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_addressList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_address WHERE PersonId=".$PersonId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_address = new Person_address();
		$obj_Person_address->AddressId= $row["AddressId"];
		$obj_Person_address->Address= $row["Address"];
		$obj_Person_address->AddressType= $row["AddressType"];
		$obj_Person_address->VillageId= $row["VillageId"];
		$obj_Person_address->PersonId= $row["PersonId"];

        array_push($arr_Person_addressList, $obj_Person_address);
        }
		
		if(count($arr_Person_addressList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_addressList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }	
	//---------------------------------------------------------------------------------------------------------

    public static function getPerson_addressListByAddressId($AddressId)
    {
    		
        $db = config::dbconfig();

        $arr_Person_addressList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_person_address WHERE AddressId=".$AddressId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Person_address = new Person_address();
		$obj_Person_address->AddressId= $row["AddressId"];
		$obj_Person_address->Address= $row["Address"];
		$obj_Person_address->AddressType= $row["AddressType"];
		$obj_Person_address->VillageId= $row["VillageId"];
		$obj_Person_address->PersonId= $row["PersonId"];

        array_push($arr_Person_addressList, $obj_Person_address);
        }
		
		if(count($arr_Person_addressList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Person_addressList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function delete($AddressId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_person_address WHERE AddressId=".$AddressId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Person_address)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_person_address SET ". 
	"AddressId=".common::noSqlInject($obj_Person_address->AddressId).","."Address="."'".common::noSqlInject($obj_Person_address->Address)."'".","."AddressType=".common::noSqlInject($obj_Person_address->AddressType).","."VillageId=".common::noSqlInject($obj_Person_address->VillageId).","."PersonId=".common::noSqlInject($obj_Person_address->PersonId).	        
	" WHERE  AddressId=".$obj_Person_address->AddressId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_address;
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
	
	public static function disablePerson_address($AddressId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_person_address SET Status=0 WHERE  AddressId=".$AddressId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Person_address;
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