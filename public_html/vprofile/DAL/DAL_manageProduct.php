<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageProduct
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addProduct($obj_Product)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Product->ProductId = DAL_manageProduct::getLastProductId()+1;
		
		 $sql = "INSERT INTO tbl_product (ProductId,ProductName,ExpireDuration,Description) 
		VALUES (".
		common::noSqlInject($obj_Product->ProductId).","."'".common::noSqlInject($obj_Product->ProductName)."'".","."'".common::noSqlInject($obj_Product->ExpireDuration)."'".","."'".common::noSqlInject($obj_Product->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Product;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastProductId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(ProductId) as maxId FROM  tbl_product";
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

    public static function getProductList()
    {
    	  $db = config::dbconfig();

        $arr_ProductList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_product ORDER BY ProductId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Product = new Product();
		$obj_Product->ProductId= $row["ProductId"];
		$obj_Product->ProductName= $row["ProductName"];
		$obj_Product->ExpireDuration= $row["ExpireDuration"];
		$obj_Product->Description= $row["Description"];

        array_push($arr_ProductList, $obj_Product);
        }
		
		if(count($arr_ProductList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_ProductList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getProductByProductId($ProductId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Product = new Product();
		$obj_Product->ProductId = -1;
		$sql = "SELECT * FROM tbl_product WHERE ProductId=".$ProductId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Product->ProductId= $row["ProductId"];
		$obj_Product->ProductName= $row["ProductName"];
		$obj_Product->ExpireDuration= $row["ExpireDuration"];
		$obj_Product->Description= $row["Description"];

        }
		
		if($obj_Product->ProductId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Product;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getProductListByProductId($ProductId)
    {
    		
        $db = config::dbconfig();

        $arr_ProductList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_product WHERE ProductId=".$ProductId." ORDER BY ProductId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Product = new Product();
		$obj_Product->ProductId= $row["ProductId"];
		$obj_Product->ProductName= $row["ProductName"];
		$obj_Product->ExpireDuration= $row["ExpireDuration"];
		$obj_Product->Description= $row["Description"];

        array_push($arr_ProductList, $obj_Product);
        }
		
		if(count($arr_ProductList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_ProductList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteProduct($ProductId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_product WHERE ProductId=".$ProductId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Product)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Product SET ". 
	"ProductId=".common::noSqlInject($obj_Product->ProductId).","."ProductName="."'".common::noSqlInject($obj_Product->ProductName)."'".","."ExpireDuration=".common::noSqlInject($obj_Product->ExpireDuration).","."Description="."'".common::noSqlInject($obj_Product->Description)."'".	        
	" WHERE  ProductId=".$obj_Product->ProductId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Product;
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
	
	public static function disableProduct($ProductId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Product SET Status=0 WHERE  ProductId=".$ProductId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Product;
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
