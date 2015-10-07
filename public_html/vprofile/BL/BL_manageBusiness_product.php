<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Business_product.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageBusiness_product.php");


class BL_manageBusiness_product
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageBusiness_product::addBusiness_product($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageBusiness_product::deleteBusiness_product($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageBusiness_product::updateBusiness_product($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addBusiness_product($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newBusiness_product = new Business_product();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newBusiness_product->BusinessId = $packet[1];
		$obj_newBusiness_product->ProductId = $packet[2];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Business_product = DAL_manageBusiness_product::addBusiness_product($obj_newBusiness_product);
            if ($obj_retResult_Business_product->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Business_product->data->wsGetBusiness_productData();
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

    public static function addBusiness_product2($BusinessId,$ProductId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newBusiness_product = new Business_product();
		
		$obj_newuser->setBusiness_product($BusinessId,$ProductId);
       // $isExist = BL_manageBusiness_product::isExist($obj_newBusiness_product->id);

        if (!$isExist)
        {
            $obj_retResult_Business_product = DAL_manageBusiness_product::addBusiness_product($obj_newBusiness_product);
            if ($obj_retResult_Business_product->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Business_product->data;
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
            $obj_retResult->msg = "Sorry! Business_product already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateBusiness_product($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Business_product = new Business_product();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Business_product->BusinessId = $packet[0];
		$obj_Business_product->ProductId = $packet[1];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Business_product = DAL_manageBusiness_product::update($obj_Business_product);

        if ($obj_retResult_Business_product->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Business_product updation is Success";
			$retrunUserpacket = $obj_retResult_Business_product->data->wsGetBusiness_productData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Business_product updation is Failed";
			$result_Business_product = DAL_manageBusiness_product::getBusiness_productByProductId($obj_Business_product->ProductId);
			if($result_Business_product->type ==1)
			{
			$retrunUserpacket = $result_Business_product->data->wsGetBusiness_productData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateBusiness_product2($BusinessId,$ProductId)
    {
        $obj_retResult = new returnResult();
        $obj_newBusiness_product = new Business_product();
	
		$obj_newBusiness_product->BusinessId=$BusinessId;
		$obj_newBusiness_product->ProductId=$ProductId;

	   
        $issuccess = DAL_manageBusiness_product::updateBusiness_product($obj_newBusiness_product);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageBusiness_product::getBusiness_productByProductId($obj_newBusiness_product->ProductId);
            $obj_retResult->msg = "Business_product updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Business_product updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getBusiness_productList()
    {
        $obj_retResult = DAL_manageBusiness_product::getBusiness_productList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getBusiness_productList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageBusiness_product::getAllBusiness_product($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageBusiness_product::searchBusiness_productByProductId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Business_product List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>BusinessId</th>";
		$html .= "<th>ProductId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Business_productList as $obj_Business_product)
            {               

                    $html .= $obj_Business_product->drawTableViewBusiness_product(); 
                
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

	public static function deleteBusiness_product($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$ProductId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_ProductId =0;
			
			$retResult = BL_manageBusiness_product::getBusiness_productListByProductId($ProductId);
			if($retResult->type ==1)
			{
			
			$obj_Business_product = $retResult->data[0];			
			$obj_result2 = DAL_manageBusiness_product::deleteBusiness_product($obj_Business_product->ProductId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_ProductId = $obj_Business_product->ProductId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Business_product";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Business_product you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Business_product->ProductId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getBusiness_productListByProductId($ProductId)
    {
        $obj_retResult = DAL_manageBusiness_product::getBusiness_productListByProductId($ProductId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildBusiness_product($ProductId,$ChildProductId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageBusiness_product::getBusiness_productListByProductId($ChildProductId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Business_productList = $obj_retResult->data;
				$obj_Business_product = $arr_Business_productList[0];
				
				$arrParentIds = explode(",",$obj_Business_product->Url);
				
				foreach($arrParentIds as $Business_productParentId)
				{
					if($Business_productParentId == $ProductId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>