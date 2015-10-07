<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Primarygeolayertype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePrimarygeolayertype.php");


class BL_managePrimarygeolayertype
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePrimarygeolayertype::addPrimarygeolayertype($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePrimarygeolayertype::deletePrimarygeolayertype($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePrimarygeolayertype::updatePrimarygeolayertype($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPrimarygeolayertype($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPrimarygeolayertype = new Primarygeolayertype();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPrimarygeolayertype->PrimaryGeoLayerTypeId = $packet[1];
		$obj_newPrimarygeolayertype->PrimaryGeoLayerName = $packet[2];
		$obj_newPrimarygeolayertype->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Primarygeolayertype = DAL_managePrimarygeolayertype::addPrimarygeolayertype($obj_newPrimarygeolayertype);
            if ($obj_retResult_Primarygeolayertype->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Primarygeolayertype->data->wsGetPrimarygeolayertypeData();
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

    public static function addPrimarygeolayertype2($PrimaryGeoLayerTypeId,$PrimaryGeoLayerName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPrimarygeolayertype = new Primarygeolayertype();
		
		$obj_newuser->setPrimarygeolayertype($PrimaryGeoLayerTypeId,$PrimaryGeoLayerName,$Description);
       // $isExist = BL_managePrimarygeolayertype::isExist($obj_newPrimarygeolayertype->id);

        if (!$isExist)
        {
            $obj_retResult_Primarygeolayertype = DAL_managePrimarygeolayertype::addPrimarygeolayertype($obj_newPrimarygeolayertype);
            if ($obj_retResult_Primarygeolayertype->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Primarygeolayertype->data;
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
            $obj_retResult->msg = "Sorry! Primarygeolayertype already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePrimarygeolayertype($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Primarygeolayertype = new Primarygeolayertype();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Primarygeolayertype->PrimaryGeoLayerTypeId = $packet[0];
		$obj_Primarygeolayertype->PrimaryGeoLayerName = $packet[1];
		$obj_Primarygeolayertype->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Primarygeolayertype = DAL_managePrimarygeolayertype::update($obj_Primarygeolayertype);

        if ($obj_retResult_Primarygeolayertype->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Primarygeolayertype updation is Success";
			$retrunUserpacket = $obj_retResult_Primarygeolayertype->data->wsGetPrimarygeolayertypeData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Primarygeolayertype updation is Failed";
			$result_Primarygeolayertype = DAL_managePrimarygeolayertype::getPrimarygeolayertypeByPrimaryGeoLayerTypeId($obj_Primarygeolayertype->PrimaryGeoLayerTypeId);
			if($result_Primarygeolayertype->type ==1)
			{
			$retrunUserpacket = $result_Primarygeolayertype->data->wsGetPrimarygeolayertypeData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePrimarygeolayertype2($PrimaryGeoLayerTypeId,$PrimaryGeoLayerName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newPrimarygeolayertype = new Primarygeolayertype();
	
		$obj_newPrimarygeolayertype->PrimaryGeoLayerTypeId=$PrimaryGeoLayerTypeId;
		$obj_newPrimarygeolayertype->PrimaryGeoLayerName=$PrimaryGeoLayerName;
		$obj_newPrimarygeolayertype->Description=$Description;

	   
        $issuccess = DAL_managePrimarygeolayertype::updatePrimarygeolayertype($obj_newPrimarygeolayertype);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePrimarygeolayertype::getPrimarygeolayertypeByPrimaryGeoLayerTypeId($obj_newPrimarygeolayertype->PrimaryGeoLayerTypeId);
            $obj_retResult->msg = "Primarygeolayertype updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Primarygeolayertype updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPrimarygeolayertypeList()
    {
        $obj_retResult = DAL_managePrimarygeolayertype::getPrimarygeolayertypeList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPrimarygeolayertypeList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePrimarygeolayertype::getAllPrimarygeolayertype($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePrimarygeolayertype::searchPrimarygeolayertypeByPrimaryGeoLayerTypeId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Primarygeolayertype List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>PrimaryGeoLayerTypeId</th>";
		$html .= "<th>PrimaryGeoLayerName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_PrimarygeolayertypeList as $obj_Primarygeolayertype)
            {               

                    $html .= $obj_Primarygeolayertype->drawTableViewPrimarygeolayertype(); 
                
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

	public static function deletePrimarygeolayertype($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$PrimaryGeoLayerTypeId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_PrimaryGeoLayerTypeId =0;
			
			$retResult = BL_managePrimarygeolayertype::getPrimarygeolayertypeListByPrimaryGeoLayerTypeId($PrimaryGeoLayerTypeId);
			if($retResult->type ==1)
			{
			
			$obj_Primarygeolayertype = $retResult->data[0];			
			$obj_result2 = DAL_managePrimarygeolayertype::deletePrimarygeolayertype($obj_Primarygeolayertype->PrimaryGeoLayerTypeId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_PrimaryGeoLayerTypeId = $obj_Primarygeolayertype->PrimaryGeoLayerTypeId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Primarygeolayertype";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Primarygeolayertype you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Primarygeolayertype->PrimaryGeoLayerTypeId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getPrimarygeolayertypeListByPrimaryGeoLayerTypeId($PrimaryGeoLayerTypeId)
    {
        $obj_retResult = DAL_managePrimarygeolayertype::getPrimarygeolayertypeListByPrimaryGeoLayerTypeId($PrimaryGeoLayerTypeId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPrimarygeolayertype($PrimaryGeoLayerTypeId,$ChildPrimaryGeoLayerTypeId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePrimarygeolayertype::getPrimarygeolayertypeListByPrimaryGeoLayerTypeId($ChildPrimaryGeoLayerTypeId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_PrimarygeolayertypeList = $obj_retResult->data;
				$obj_Primarygeolayertype = $arr_PrimarygeolayertypeList[0];
				
				$arrParentIds = explode(",",$obj_Primarygeolayertype->Url);
				
				foreach($arrParentIds as $PrimarygeolayertypeParentId)
				{
					if($PrimarygeolayertypeParentId == $PrimaryGeoLayerTypeId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>