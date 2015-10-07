<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageBusiness_product
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addBusiness_product($obj_Business_product)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Business_product->ProductId = DAL_manageBusiness_product::getLastBusiness_productId()+1;
		
		 $sql = "INSERT INTO tbl_business_product (BusinessId,ProductId) 
		VALUES (".
		common::noSqlInject($obj_Business_product->BusinessId).",".common::noSqlInject($obj_Business_product->ProductId).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Business_product;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastBusiness_productId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(ProductId) as maxId FROM  tbl_business_product";
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

    public static function getBusiness_productList()
    {
    	  $db = config::dbconfig();

        $arr_Business_productList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_business_product ORDER BY ProductId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Business_product = new Business_product();
		$obj_Business_product->BusinessId= $row["BusinessId"];
		$obj_Business_product->ProductId= $row["ProductId"];

        array_push($arr_Business_productList, $obj_Business_product);
        }
		
		if(count($arr_Business_productList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Business_productList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getBusiness_productByProductId($ProductId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Business_product = new Business_product();
		$obj_Business_product->ProductId = -1;
		$sql = "SELECT * FROM tbl_business_product WHERE ProductId=".$ProductId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Business_product->BusinessId= $row["BusinessId"];
		$obj_Business_product->ProductId= $row["ProductId"];

        }
		
		if($obj_Business_product->ProductId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Business_product;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getBusiness_productListByProductId($ProductId)
    {
    		
        $db = config::dbconfig();

        $arr_Business_productList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_business_product WHERE ProductId=".$ProductId." ORDER BY ProductId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Business_product = new Business_product();
		$obj_Business_product->BusinessId= $row["BusinessId"];
		$obj_Business_product->ProductId= $row["ProductId"];

        array_push($arr_Business_productList, $obj_Business_product);
        }
		
		if(count($arr_Business_productList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Business_productList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteBusiness_product($ProductId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_business_product WHERE ProductId=".$ProductId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Business_product)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_business_product SET ". 
	"BusinessId=".common::noSqlInject($obj_Business_product->BusinessId).","."ProductId=".common::noSqlInject($obj_Business_product->ProductId).	        
	" WHERE  ProductId=".$obj_Business_product->ProductId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Business_product;
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
	
	public static function disableBusiness_product($ProductId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_business_product SET Status=0 WHERE  ProductId=".$ProductId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Business_product;
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
