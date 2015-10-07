<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_image.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_image.php");


class BL_manageVillage_image
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_image::addVillage_image($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_image::deleteVillage_image($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_image::updateVillage_image($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_image($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_image = new Village_image();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_image->PictureId = $packet[1];
		$obj_newVillage_image->VillageId = $packet[2];
		$obj_newVillage_image->PicturePath = $packet[3];
		$obj_newVillage_image->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_image = DAL_manageVillage_image::addVillage_image($obj_newVillage_image);
            if ($obj_retResult_Village_image->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_image->data->wsGetVillage_imageData();
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

    public static function addVillage_image2($PictureId,$VillageId,$PicturePath,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_image = new Village_image();
		
		$obj_newuser->setVillage_image($PictureId,$VillageId,$PicturePath,$Description);
       // $isExist = BL_manageVillage_image::isExist($obj_newVillage_image->id);

        if (!$isExist)
        {
            $obj_retResult_Village_image = DAL_manageVillage_image::addVillage_image($obj_newVillage_image);
            if ($obj_retResult_Village_image->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_image->data;
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
            $obj_retResult->msg = "Sorry! Village_image already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_image($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_image = new Village_image();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_image->PictureId = $packet[0];
		$obj_Village_image->VillageId = $packet[1];
		$obj_Village_image->PicturePath = $packet[2];
		$obj_Village_image->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_image = DAL_manageVillage_image::update($obj_Village_image);

        if ($obj_retResult_Village_image->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_image updation is Success";
			$retrunUserpacket = $obj_retResult_Village_image->data->wsGetVillage_imageData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_image updation is Failed";
			$result_Village_image = DAL_manageVillage_image::getVillage_imageByPictureId($obj_Village_image->PictureId);
			if($result_Village_image->type ==1)
			{
			$retrunUserpacket = $result_Village_image->data->wsGetVillage_imageData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_image2($PictureId,$VillageId,$PicturePath,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_image = new Village_image();
	
		$obj_newVillage_image->PictureId=$PictureId;
		$obj_newVillage_image->VillageId=$VillageId;
		$obj_newVillage_image->PicturePath=$PicturePath;
		$obj_newVillage_image->Description=$Description;

	   
        $issuccess = DAL_manageVillage_image::updateVillage_image($obj_newVillage_image);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_image::getVillage_imageByPictureId($obj_newVillage_image->PictureId);
            $obj_retResult->msg = "Village_image updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_image updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_imageList()
    {
        $obj_retResult = DAL_manageVillage_image::getVillage_imageList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_imageList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_image::getAllVillage_image($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_image::searchVillage_imageByPictureId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_image List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>PictureId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>PicturePath</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_imageList as $obj_Village_image)
            {               

                    $html .= $obj_Village_image->drawTableViewVillage_image(); 
                
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

	public static function deleteVillage_image($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$PictureId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_PictureId =0;
			
			$retResult = BL_manageVillage_image::getVillage_imageListByPictureId($PictureId);
			if($retResult->type ==1)
			{
			
			$obj_Village_image = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_image::deleteVillage_image($obj_Village_image->PictureId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_PictureId = $obj_Village_image->PictureId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_image";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_image you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_image->PictureId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_imageListByPictureId($PictureId)
    {
        $obj_retResult = DAL_manageVillage_image::getVillage_imageListByPictureId($PictureId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_image($PictureId,$ChildPictureId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_image::getVillage_imageListByPictureId($ChildPictureId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_imageList = $obj_retResult->data;
				$obj_Village_image = $arr_Village_imageList[0];
				
				$arrParentIds = explode(",",$obj_Village_image->Url);
				
				foreach($arrParentIds as $Village_imageParentId)
				{
					if($Village_imageParentId == $PictureId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>