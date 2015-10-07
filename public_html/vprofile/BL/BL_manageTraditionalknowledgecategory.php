<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Traditionalknowledgecategory.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageTraditionalknowledgecategory.php");


class BL_manageTraditionalknowledgecategory
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageTraditionalknowledgecategory::addTraditionalknowledgecategory($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageTraditionalknowledgecategory::deleteTraditionalknowledgecategory($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageTraditionalknowledgecategory::updateTraditionalknowledgecategory($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addTraditionalknowledgecategory($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newTraditionalknowledgecategory = new Traditionalknowledgecategory();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newTraditionalknowledgecategory->CategoryId = $packet[1];
		$obj_newTraditionalknowledgecategory->CategoryName = $packet[2];
		$obj_newTraditionalknowledgecategory->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Traditionalknowledgecategory = DAL_manageTraditionalknowledgecategory::addTraditionalknowledgecategory($obj_newTraditionalknowledgecategory);
            if ($obj_retResult_Traditionalknowledgecategory->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Traditionalknowledgecategory->data->wsGetTraditionalknowledgecategoryData();
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

    public static function addTraditionalknowledgecategory2($CategoryId,$CategoryName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newTraditionalknowledgecategory = new Traditionalknowledgecategory();
		
		$obj_newuser->setTraditionalknowledgecategory($CategoryId,$CategoryName,$Description);
       // $isExist = BL_manageTraditionalknowledgecategory::isExist($obj_newTraditionalknowledgecategory->id);

        if (!$isExist)
        {
            $obj_retResult_Traditionalknowledgecategory = DAL_manageTraditionalknowledgecategory::addTraditionalknowledgecategory($obj_newTraditionalknowledgecategory);
            if ($obj_retResult_Traditionalknowledgecategory->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Traditionalknowledgecategory->data;
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
            $obj_retResult->msg = "Sorry! Traditionalknowledgecategory already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateTraditionalknowledgecategory($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Traditionalknowledgecategory->CategoryId = $packet[0];
		$obj_Traditionalknowledgecategory->CategoryName = $packet[1];
		$obj_Traditionalknowledgecategory->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Traditionalknowledgecategory = DAL_manageTraditionalknowledgecategory::update($obj_Traditionalknowledgecategory);

        if ($obj_retResult_Traditionalknowledgecategory->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Traditionalknowledgecategory updation is Success";
			$retrunUserpacket = $obj_retResult_Traditionalknowledgecategory->data->wsGetTraditionalknowledgecategoryData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Traditionalknowledgecategory updation is Failed";
			$result_Traditionalknowledgecategory = DAL_manageTraditionalknowledgecategory::getTraditionalknowledgecategoryByCategoryId($obj_Traditionalknowledgecategory->CategoryId);
			if($result_Traditionalknowledgecategory->type ==1)
			{
			$retrunUserpacket = $result_Traditionalknowledgecategory->data->wsGetTraditionalknowledgecategoryData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateTraditionalknowledgecategory2($CategoryId,$CategoryName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newTraditionalknowledgecategory = new Traditionalknowledgecategory();
	
		$obj_newTraditionalknowledgecategory->CategoryId=$CategoryId;
		$obj_newTraditionalknowledgecategory->CategoryName=$CategoryName;
		$obj_newTraditionalknowledgecategory->Description=$Description;

	   
        $issuccess = DAL_manageTraditionalknowledgecategory::updateTraditionalknowledgecategory($obj_newTraditionalknowledgecategory);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageTraditionalknowledgecategory::getTraditionalknowledgecategoryByCategoryId($obj_newTraditionalknowledgecategory->CategoryId);
            $obj_retResult->msg = "Traditionalknowledgecategory updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Traditionalknowledgecategory updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getTraditionalknowledgecategoryList()
    {
        $obj_retResult = DAL_manageTraditionalknowledgecategory::getTraditionalknowledgecategoryList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getTraditionalknowledgecategoryList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageTraditionalknowledgecategory::getAllTraditionalknowledgecategory($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageTraditionalknowledgecategory::searchTraditionalknowledgecategoryByCategoryId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Traditionalknowledgecategory List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>CategoryId</th>";
		$html .= "<th>CategoryName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_TraditionalknowledgecategoryList as $obj_Traditionalknowledgecategory)
            {               

                    $html .= $obj_Traditionalknowledgecategory->drawTableViewTraditionalknowledgecategory(); 
                
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

	public static function deleteTraditionalknowledgecategory($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$CategoryId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_CategoryId =0;
			
			$retResult = BL_manageTraditionalknowledgecategory::getTraditionalknowledgecategoryListByCategoryId($CategoryId);
			if($retResult->type ==1)
			{
			
			$obj_Traditionalknowledgecategory = $retResult->data[0];			
			$obj_result2 = DAL_manageTraditionalknowledgecategory::deleteTraditionalknowledgecategory($obj_Traditionalknowledgecategory->CategoryId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_CategoryId = $obj_Traditionalknowledgecategory->CategoryId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Traditionalknowledgecategory";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Traditionalknowledgecategory you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Traditionalknowledgecategory->CategoryId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getTraditionalknowledgecategoryListByCategoryId($CategoryId)
    {
        $obj_retResult = DAL_manageTraditionalknowledgecategory::getTraditionalknowledgecategoryListByCategoryId($CategoryId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildTraditionalknowledgecategory($CategoryId,$ChildCategoryId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageTraditionalknowledgecategory::getTraditionalknowledgecategoryListByCategoryId($ChildCategoryId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_TraditionalknowledgecategoryList = $obj_retResult->data;
				$obj_Traditionalknowledgecategory = $arr_TraditionalknowledgecategoryList[0];
				
				$arrParentIds = explode(",",$obj_Traditionalknowledgecategory->Url);
				
				foreach($arrParentIds as $TraditionalknowledgecategoryParentId)
				{
					if($TraditionalknowledgecategoryParentId == $CategoryId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>