<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Product.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageProduct.php");


class BL_manageProduct
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageProduct::addProduct($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageProduct::deleteProduct($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageProduct::updateProduct($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addProduct($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newProduct = new Product();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newProduct->ProductId = $packet[1];
		$obj_newProduct->ProductName = $packet[2];
		$obj_newProduct->ExpireDuration = $packet[3];
		$obj_newProduct->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Product = DAL_manageProduct::addProduct($obj_newProduct);
            if ($obj_retResult_Product->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Product->data->wsGetProductData();
            }
            else
            {
                $obj_retResult->type = 0;
                $obj_retResult->msg = "Failed";
				
            }

       // }
       // else
       // {
       //     $obj_retResult->type = 0;
       //     $obj_retResult->msg = "Sorry! User already exist";
       // }
       
		}
		$returnPacket = array ($obj_retResult->type,$obj_retResult->msg,$dummyId);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
	}
    //---------------------------------------------------------------------------------------------------------

    public static function addProduct2($ProductId,$ProductName,$ExpireDuration,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newProduct = new Product();
		
		$obj_newuser->setProduct($ProductId,$ProductName,$ExpireDuration,$Description);
       // $isExist = BL_manageProduct::isExist($obj_newProduct->id);

        if (!$isExist)
        {
            $obj_retResult_Product = DAL_manageProduct::addProduct($obj_newProduct);
            if ($obj_retResult_Product->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Product->data;
            }
            else
            {
                $obj_retResult->type = 0;
                $obj_retResult->msg = "Failed";
				
            }

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Sorry! Product already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateProduct($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Product = new Product();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Product->ProductId = $packet[0];
		$obj_Product->ProductName = $packet[1];
		$obj_Product->ExpireDuration = $packet[2];
		$obj_Product->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Product = DAL_manageProduct::update($obj_Product);

        if ($obj_retResult_Product->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Product updation is Success";
			$retrunUserpacket = $obj_retResult_Product->data->wsGetProductData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Product updation is Failed";
			$result_Product = DAL_manageProduct::getProductByProductId($obj_Product->ProductId);
			if($result_Product->type ==1)
			{
			$retrunUserpacket = $result_Product->data->wsGetProductData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateProduct2($ProductId,$ProductName,$ExpireDuration,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newProduct = new Product();
	
		$obj_newProduct->ProductId=$ProductId;
		$obj_newProduct->ProductName=$ProductName;
		$obj_newProduct->ExpireDuration=$ExpireDuration;
		$obj_newProduct->Description=$Description;

	   
        $issuccess = DAL_manageProduct::updateProduct($obj_newProduct);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageProduct::getProductByProductId($obj_newProduct->ProductId);
            $obj_retResult->msg = "Product updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Product updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getProductList()
    {
        $obj_retResult = DAL_manageProduct::getProductList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getProductList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageProduct::getAllProduct($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageProduct::searchProductByProductId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Product List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>ProductId</th>";
		$html .= "<th>ProductName</th>";
		$html .= "<th>ExpireDuration</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_ProductList as $obj_Product)
            {               

                    $html .= $obj_Product->drawTableViewProduct(); 
                
            }
		$html .= "</table></div>";
        }
        else
        {
            $html = "No user found";

        }
        return $html;
    }
	
    //---------------------------------------------------------------------------------------------------------  

	public static function deleteProduct($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$ProductId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_ProductId =0;
			
			$retResult = BL_manageProduct::getProductListByProductId($ProductId);
			if($retResult->type ==1)
			{
			
			$obj_Product = $retResult->data[0];			
			$obj_result2 = DAL_manageProduct::deleteProduct($obj_Product->ProductId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_ProductId = $obj_Product->ProductId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Product";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Product you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Product->ProductId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getProductListByProductId($ProductId)
    {
        $obj_retResult = DAL_manageProduct::getProductListByProductId($ProductId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildProduct($ProductId,$ChildProductId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageProduct::getProductListByProductId($ChildProductId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_ProductList = $obj_retResult->data;
				$obj_Product = $arr_ProductList[0];
				
				$arrParentIds = explode(",",$obj_Product->Url);
				
				foreach($arrParentIds as $ProductParentId)
				{
					if($ProductParentId == $ProductId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>